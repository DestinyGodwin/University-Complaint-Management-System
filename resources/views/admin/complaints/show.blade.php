@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-6 p-6 bg-gray-100 rounded shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Complaint Details</h1>

    <!-- Complaint Information -->
    <div class="bg-white p-6 rounded shadow-md mb-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">General Information</h2>
        <p><strong>Title:</strong> {{ $complaint->title }}</p>
        <p><strong>Description:</strong> {{ $complaint->description }}</p>
        <p><strong>Status:</strong>
            <span class="px-3 py-1 rounded {{ $complaint->status === 'Resolved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                {{ $complaint->status }}
            </span>
        </p>

        @if ($complaint->file_path && Storage::exists($complaint->file_path))
            <p class="mt-4"><strong>Attached File:</strong></p>
            <div class="flex space-x-4 mt-2">
                <!-- Preview File -->
                <a href="{{ route('complaints.preview', $complaint->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition">
                    Preview File
                </a>

                <!-- Download File -->
                <a href="{{ route('complaints.download', $complaint->id) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500 transition">
                    Download File
                </a>
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="bg-white p-6 rounded shadow-md mb-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Actions</h2>

        <div class="flex flex-wrap gap-4">
            <!-- Assign Form -->
            <form action="{{ route('admin.complaints.assign', $complaint->id) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                @method('PUT')
                <select name="assigned_to" class="border rounded p-2">
                    <option value="" disabled selected>Assign to Staff</option>
                    @foreach ($staffMembers as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition">
                    Assign
                </button>
            </form>

            <!-- Resolve Form -->
            <form action="{{ route('admin.complaints.resolve', $complaint->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500 transition">
                    Mark as Resolved
                </button>
            </form>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Comments</h2>

        @if ($comments->isEmpty())
            <p class="text-gray-500">No comments yet.</p>
        @else
            <ul class="space-y-4">
                @foreach ($comments as $comment)
                    <li class="bg-gray-50 p-4 rounded shadow-sm">
                        <strong class="text-blue-600">{{ $comment->user->name }}</strong>
                        <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                        <p class="mt-2">{{ $comment->content }}</p>
                    </li>
                @endforeach
            </ul>
        @endif

        <!-- Add Comment -->
        <h3 class="text-lg font-semibold mt-6">Add a Comment</h3>
        <form action="{{ route('admin.complaints.comments.store', $complaint->id) }}" method="POST" class="mt-4">
            @csrf
            <textarea name="content" class="w-full p-3 border rounded" rows="4" placeholder="Write your comment here"></textarea>
            <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition">
                Submit
            </button>
        </form>
    </div>
</div>
@endsection
