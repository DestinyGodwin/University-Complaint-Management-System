@extends('layouts.student')

@section('content')
<div class="container mx-auto py-6">
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-200">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h2 class="text-2xl font-bold mb-6">Submit a Complaint</h2>

    <form action="{{ route('student.complaints.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-sm font-bold mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2">Description</label>
            <textarea name="description" id="description" class="w-full border-gray-300 rounded p-2" rows="5" required></textarea>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-sm font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" class="w-full border-gray-300 rounded p-2">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="file" class="block text-sm font-bold mb-2">Attach File (optional)</label>
            <input type="file" name="file" id="file" class="w-full">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
