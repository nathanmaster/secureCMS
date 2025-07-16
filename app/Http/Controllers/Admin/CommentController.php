<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = ProductComment::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Approve a comment.
     */
    public function approve(ProductComment $comment)
    {
        $comment->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Comment approved successfully.');
    }

    /**
     * Reject/unapprove a comment.
     */
    public function unapprove(ProductComment $comment)
    {
        $comment->update(['is_approved' => false]);
        
        return redirect()->back()->with('success', 'Comment unapproved successfully.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(ProductComment $comment)
    {
        $comment->delete();
        
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
