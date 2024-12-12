<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function previewFile($id)
{
    $complaint = Complaint::findOrFail($id);

    if (!$complaint->file_path || !Storage::exists($complaint->file_path)) {
        abort(404, 'File not found');
    }

    // Generate file URL for preview
    return response()->file(storage_path('app/' . $complaint->file_path));
}

public function downloadFile($id)
{
    $complaint = Complaint::findOrFail($id);

    if (!$complaint->file_path || !Storage::exists($complaint->file_path)) {
        abort(404, 'File not found');
    }

    // Download the file
    return response()->download(storage_path('app/' . $complaint->file_path));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }
}
