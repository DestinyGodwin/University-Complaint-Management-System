<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Requests\ResolveComplaintRequest;

class StaffController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('comments', 'category')->where('assigned_to', auth()->id())->get();
        return view('staff.dashboard', compact('complaints'));
    }

    // public function resolve(ResolveComplaintRequest $request, Complaint $complaint)
    // {
    //     $complaint->update(['status' => 'Resolved']);

    //     return redirect()->route('staff.index')->with('success', 'Complaint resolved successfully.');
    // }

    public function resolve(Complaint $complaint)
    {
        $complaint->update(['status' => 'Resolved']);
    
        return redirect()->back()->with('success', 'Complaint resolved successfully.');
    }
    public function escalate(Complaint $complaint)
    {
        $complaint->update(['assigned_to' => null, 'status' => 'Escalated']);

        return redirect()->route('staff.index')->with('success', 'Complaint escalated to admin.');
    }
    public function show(Complaint $complaint)
    {
        if ($complaint->status !== 'Resolved') {
            $complaint->update(['status' => 'In Progress']);
        }
    
        $complaint->load('comments.user');
        $comments = $complaint->comments()->with('user')->latest()->get();
        $staffMembers = User::role('staff')->get(); // Fetch all staff members for assignment.
    
        return view('staff.complaints.show', compact('complaint', 'comments', 'staffMembers'));
    }
}
