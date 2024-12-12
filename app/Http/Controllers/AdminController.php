<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Requests\AssignComplaintRequest;
use App\Http\Requests\ResolveComplaintRequest;

class AdminController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('comments', 'category', 'assignedTo')->get();
        
        return view('admin.dashboard', compact('complaints',));
    }

    // public function assign(AssignComplaintRequest $request, Complaint $complaint)
    // {
    //     $complaint->update(['assigned_to' => $request->assigned_to]);

    //     return redirect()->route('admin.index')->with('success', 'Complaint assigned successfully.');
    // }
    public function assign(Request $request, Complaint $complaint)
{
    $validated = $request->validate([
        'assigned_to' => 'required|exists:users,id',
    ]);

    $complaint->update([
        'assigned_to' => $validated['assigned_to'],
        'status' => 'Assigned',
    ]);

    return redirect()->back()->with('success', 'Complaint assigned successfully.');
}

    // public function resolve(ResolveComplaintRequest $request, Complaint $complaint)
    // {
    //     $complaint->update(['status' => 'Resolved']);

    //     return redirect()->route('admin.index')->with('success', 'Complaint resolved successfully.');
    // }
    public function resolve(Complaint $complaint)
{
    $complaint->update(['status' => 'Resolved']);

    return redirect()->back()->with('success', 'Complaint resolved successfully.');
}

    public function escalate(Complaint $complaint)
    {
        $complaint->update(['assigned_to' => null, 'status' => 'Escalated']);

        return redirect()->route('staff.index')->with('success', 'Complaint escalated successfully.');
    }

    // public function show(Complaint $complaint)
    // {
    //     $complaint->load('comments.user');
    //     $comments = $complaint->comments()->with(relations: 'user')->latest()->get();
    //     return view('admin.complaints.show', compact('complaint', 'comments'));
    // }
//     public function show(Complaint $complaint)
// {
//     $complaint->load('comments.user');
//     $comments = $complaint->comments()->with('user')->latest()->get();

//     return view('admin.complaints.show', compact('complaint', 'comments'));
// }
// public function show(Complaint $complaint)
// {
//     // Update complaint status to 'In Progress' if not already resolved
//     if ($complaint->status !== 'Resolved') {
//         $complaint->update(['status' => 'In Progress']);
//     }

//     $complaint->load('comments.user');
//     $comments = $complaint->comments()->with('user')->latest()->get();

//     return view('admin.complaints.show', compact('complaint', 'comments'));
// }
public function show(Complaint $complaint)
{
    if ($complaint->status !== 'Resolved') {
        $complaint->update(['status' => 'In Progress']);
    }

    $complaint->load('comments.user');
    $comments = $complaint->comments()->with('user')->latest()->get();
    $staffMembers = User::role('staff')->get(); // Fetch all staff members for assignment.

    return view('admin.complaints.show', compact('complaint', 'comments', 'staffMembers'));
}
}
