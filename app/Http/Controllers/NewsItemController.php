<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\NewsItemDraft as Draft;
use App\Http\Controllers\Controller;

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

    public function create(Request $request)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        // Create a new draft...
        $draft = new Draft;

        $draft->user()->associate($request->user());

        $draft->save();

        return view('edit_news_item', [
            'authors' => User::whereHas(
                'rank', function ($query) {
                    $query->where('seniority', '<=', 1);
                })->get(['id', 'battletag']),
            'draft' => $draft,
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

        $validatedData = $request->validate([
            'allowsComments' => 'boolean',
            'author' => 'exists:users,id',
            'body' => 'required',
            'publishDate' => 'nullable|date',
            'title' => 'required|max:255',
            'url' => [
                'required',
                Rule::unique('news_items')->ignore($news_item->id),
                'max:255',
            ],
        ]);

        // The news item is valid...

        // Set the new values...
        $news_item->fill([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'allows_comments' => $validatedData['allowsComments'],
            'url' => $validatedData['url'],
            'published_at' => $validatedData['publishDate']
                ? Carbon::parse($validatedData['publishDate'])
                : null,
        ]);

        // Set the author...
        $news_item->author()->associate(User::find($validatedData['author']));

        // Save the news item...
        $news_item->save();

        return response()->json($news_item);
    }

    public function saveDraft(Request $request, Draft $draft)
    {
        $this->authorize('create', NewsItem::class);

        // The current user can create news items...

        $draft->title = $request->input('title', null);

        if ($request->filled('body')) {
            $draft->body = $request->input('body');
        }

        $draft->save();

        return response(null, 204);
    }
}
