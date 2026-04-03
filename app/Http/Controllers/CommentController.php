<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Comment;
use App\Services\Logging\ActionLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for comments on ideas.
 *
 * NOTE:
 * - No validation (TODO)
 * - No limit per user (add max 3 comments per idea) (TODO)
 * - No authorization on delete (TODO secure)
 */
class CommentController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Store a new comment for an idea.
     */
    public function store(Request $request, Idea $idea)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:2000'],
        ]);

        $commentCount = Comment::where('user_id', Auth::id())->count();

        if ($commentCount >= 3) {
            return redirect()->back()->withErrors(['limit' => 'Vous ne pouvez pas écrire plus de 3 commentaires.']);
        }

        $comment = Comment::create([
            'idea_id'     => $idea->id,
            'user_id'     => Auth::id(),
            'description' => $request->input('description'),
        ]);

        app(ActionLogService::class)->log(
            userId: Auth::id(),
            action: 'comment_created',
            ideaId: $idea->id,
            commentId: $comment->id,
            request: $request,
        );

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment added.');
    }

    /**
     * Remove a comment — réservé à l'auteur ou un admin.
     */
    public function destroy(Idea $idea, Comment $comment)
    {
        $this->authorize('delete', $comment);

        app(ActionLogService::class)->log(
            userId: Auth::id(),
            action: 'comment_deleted',
            ideaId: $idea->id,
            commentId: $comment->id,
        );

        $comment->delete();

        return redirect()
            ->route('ideas.show', $idea)
            ->with('status', 'Comment deleted.');
    }
}
