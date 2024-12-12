<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);
    
        // Add comment
        $complaint->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);
    
        // Update complaint status to 'In Progress' if not resolved
        if ($complaint->status !== 'Resolved') {
            $complaint->update(['status' => 'In Progress']);
        }
    
        return back()->with('success', 'Comment added successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
