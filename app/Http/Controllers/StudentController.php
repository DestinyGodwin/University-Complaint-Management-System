<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\Department;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('comments', 'category')->where('user_id', auth()->id())->get();
        return view('student.dashboard', compact('complaints'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('student.complaints.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt',
        ]);
    
        // Handle file upload
        $filePath = $request->file('file') ? $request->file('file')->store('complaints') : null;
    
        // Define a mapping between categories and departments
        $categoryDepartmentMapping = [
            'Accommodation' => 'Housing',
            'IT support' => 'IT support',
            'Transportation' => 'Transportation',
            'Library resources' => 'Library services',
        ];
    
        // Retrieve the category name based on the ID
        $category = Category::find($validated['category_id']);
    
        if (!$category || !isset($categoryDepartmentMapping[$category->name])) {
            return redirect()->back()->withErrors(['error' => 'No matching department found for the selected category.']);
        }
        // Retrieve the department name based on the mapping
        $departmentName = $categoryDepartmentMapping[$category->name];
    
        // Find the department by name
        $department = Department::where('name', $departmentName)->first();
    
        if (!$department) {
            return redirect()->back()->withErrors(['error' => 'No department found for the selected category.']);
        }
    
        // Get a random staff member with the "staff" role in the department
        $staffMember = $department->users()
            ->role('staff') // Use Spatie's method to filter by role
            ->inRandomOrder()
            ->first();
    
        if (!$staffMember) {
            return redirect()->back()->withErrors(['error' => 'No staff member available in the selected department.']);
        }
        // Create the complaint and assign it to the staff
        Complaint::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'file_path' => $filePath,
            'assigned_to' => $staffMember->id,
        ]);
    
        return redirect()->route('student.dashboard')->with('success', 'Complaint submitted successfully.');
    }
    

    public function show(Complaint $complaint)
    {
        if ($complaint->user_id !== auth()->id()) {
            abort(403);
        }

        $complaint->load('comments.user');
        $comments = $complaint->comments()->with(relations: 'user')->latest()->get();
        return view('student.complaints.show', compact('complaint', 'comments'));
    }
}
