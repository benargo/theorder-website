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
}
