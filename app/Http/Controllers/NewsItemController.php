<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsItemDraft as Draft;
use App\Notifications\NewsItemPublished;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsItemController extends Controller
{
    public function checkUrl(Request $request)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        abort_unless($request->filled('url'), 400);

        // The required parameter was provided and isn't null...

        $url_is_available = DB::table('news_items')
                                    ->where('url', $request->input('url'))
                                    ->doesntExist();

        return response()->json([
            'urlIsAvailable' => $url_is_available,
        ]);
    }

    protected function checkForDraft(NewsItem $news_item = null)
    {
        // Check if the current user has a draft for this article...
        if ($news_item) {

            $draft = $news_item->drafts()->where('user_id', Auth::id())->first();

            if ($draft) return $draft;
        }

        // Either the current user doesn't have a draft for this news item, or
        // no news item was provided. In either case, we should now create a
        // new draft...
        $this->authorize('create', Draft::class);

        $draft = new Draft;

        $draft->user()->associate(Auth::user());

        // Associate the news item if there is one...
        if ($news_item) {
            $draft->newsItem()->associate($news_item);
        }

        $draft->save();

        return $draft;
    }

    public function create(Request $request)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        // Create a new draft...
        $draft = new Draft;

        $draft->user()->associate(Auth::user());

        $draft->save();

        return $this->editor($draft);
    }

    public function edit(NewsItem $news_item = null, Request $request)
    {
        if ($news_item) {
            $this->authorize('update', $news_item);
        }

        // The current user can edit news items...

        // Check if a draft ID has been passed in the query string...
        if ($request->query('draft', false)) {
            $draft = Draft::findOrFail($request->query('draft'));
        }
        else {
            $draft = $this->checkForDraft($news_item);
        }

        $this->authorize('update', $draft);

        // The current user can edit this draft...

        return $this->editor($draft, $news_item);
    }

    public function editor(Draft $draft, NewsItem $news_item = null)
    {
        return view('edit_news_item', [
            'authors' => User::whereHas(
                'rank', function ($query) {
                    $query->where('seniority', '<=', 1);
                })->get(['id', 'battletag']),
            'draft' => $draft,
            'item_id' => $news_item ? $news_item->id : null,
        ]);
    }

    public function getManageList(Request $request)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        // Get all the drafts without articles...
        $drafts = DB::table('news_item_drafts')
                ->leftJoin('users', 'news_item_drafts.user_id', '=', 'users.id')
                ->select('news_item_id', 'news_item_drafts.id as draft_id', 'title', 'user_id as author_id', 'users.battletag as author_battletag', 'news_item_drafts.updated_at')
                ->where(function ($query) {
                    $query->whereNotNull('title')
                          ->orWhereNotNull('body');
                })
                ->where('user_id', Auth::id())
                ->whereNull('news_item_id')
                ->orderBy('news_item_drafts.created_at', 'desc')
                ->get();

        // Get all the news articles...
        $news_items = DB::table('news_items')
                ->leftJoin('users', 'news_items.author_id', '=', 'users.id')
                ->select(
                    'news_items.id as news_item_id',
                    DB::raw('(
                        select id from news_item_drafts
                        where news_item_drafts.news_item_id = news_items.id
                            and news_item_drafts.user_id = ' . Auth::id() . '
                            and news_item_drafts.updated_at >= news_items.updated_at
                        order by news_item_drafts.created_at
                        limit 1
                    ) as draft_id'),
                    'title',
                    'author_id',
                    'users.battletag as author_battletag',
                    'published_at',
                    'news_items.updated_at'
                )
                ->orderBy('news_items.published_at', 'desc')
                ->orderBy('news_items.created_at', 'desc')
                ->get();

        // Merge the collections together. This will append the news items
        // below the drafts...
        $merged = $drafts->merge($news_items);

        $merged->transform(function ($item, $key) {
            $item->author_battletag = str_before(decrypt($item->author_battletag), '#');
            $item->edit_url = url(
                '/inner-circle/news/editor' . ($item->draft_id ? '?draft=' . $item->draft_id : ''),
                ['item' => $item->news_item_id]
            );

            return $item;
        });

        $per_page = $request->query('per_page', 20);
        $page_number = (Paginator::resolveCurrentPage() ?: 1);

        // Create a paginator...
        return new LengthAwarePaginator($merged->forPage($page_number, $per_page), $merged->count(), $per_page, null, ['path' => action('NewsItemController@getManageList', [], false)]);
    }

    public function index()
    {
        $news_items = NewsItem::whereDate('published_at', '<=', Carbon::now())
                                    ->orderBy('published_at', 'desc')
                                    ->paginate(10);

        return view(
            'news_index',
            [
                'news_items' => $news_items,
            ]
        );
    }

    public function publish(NewsItem $news_item = null, Request $request)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        // If there is no model provided, create a new one...
        if (! $news_item) {
            $news_item = new NewsItem;
        }

        $validated_data = $request->validate([
            'allowsComments' => 'boolean',
            'author' => 'exists:users,id',
            'body' => 'string',
            'draftId' => 'exists:news_item_drafts,id',
            'publishDate' => 'nullable|date',
            'title' => 'string|max:255',
            'url' => [
                'string',
                Rule::unique('news_items')->ignore($news_item->id),
                'max:255',
            ],
        ]);

        // The news item is valid...

        // Set the new values...
        $news_item->fill([
            'title' => array_get($validated_data, 'title', $news_item->title),
            'body' => array_get($validated_data, 'body', $news_item->body),
            'allows_comments' => array_get($validated_data, 'allowsComments', $news_item->allows_comments),
            'url' => array_get($validated_data, 'url', $news_item->url),
            'published_at' => $validated_data['publishDate']
                ? Carbon::parse($validated_data['publishDate'])
                : null,
        ]);

        // Set the author...
        if (array_has($validated_data, 'author')) {
            $news_item->author()->associate(User::find($validated_data['author']));
        }

        // Save the news item...
        $news_item->save();

        // Set the news item ID against the draft...
        if (array_has($validated_data, 'draftId')) {
            $draft = Draft::find($validated_data['draftId']);
            $draft->newsItem()->associate($news_item);
            $draft->save();
        }

        // If we should send a notification to Discord...
        if ($this->shouldNotifyDiscord($news_item)) {
            $this->notifyDiscord($news_item);
        }

        // Return the news item...
        return response()->json($news_item);
    }

    public function saveDraft(Request $request, Draft $draft)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        // Return early if both the title and body are empty. We don't want to
        // throw an error, but still inform the client that the action has not
        // been completed...
        if (! $request->filled('title') && ! $request->filled('body')) {
            return response(null, 202);
        }

        $draft->update([
            'title' => $request->input('title'),
            'body' => $request->input('body')
            ]);

        return response(null, 204);
    }

    protected function notifyDiscord(NewsItem $news_item)
    {
        // If the news item is scheduled to be published at least one minute
        // in the future...
        if ($news_item->published_at->greaterThanOrEqualTo(now()->addMinute())) {
            $notification = (new NewsItemPublished())->delay(new Carbon($news_item->published_at));
        }
        else {
            $notification = new NewsItemPublished();
        }

        $news_item->notify($notification);
    }

    /**
     * Test whether we should notify Discord.
     *
     * This should only apply if the article was just published or scheduled to
     * be published later.
     *
     * @param  App\Models\NewsItem  $news_item
     * @return boolean
     */
    protected function shouldNotifyDiscord(NewsItem $news_item)
    {
        return (
            $news_item->published_at
            && $news_item->published_at instanceof Carbon
            && $news_item->published_at->greaterThanOrEqualTo(now()->subMinute())
        );
    }
}
