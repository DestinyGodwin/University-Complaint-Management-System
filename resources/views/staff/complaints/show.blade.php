@extends('layouts.student')

@section('content')
<div class="container mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Complaint Details</h1>

    <div class="mb-6 border-b pb-4">
        <p class="text-lg font-semibold text-gray-700 mb-2"><span class="text-gray-900">Title:</span> {{ $complaint->title }}</p>
        <p class="text-lg font-medium text-gray-600 mb-4"><span class="text-gray-900">Description:</span> {{ $complaint->description }}</p>
        <p class="text-lg font-medium text-gray-600">
            <span class="text-gray-900">Status:</span> 
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $complaint->status === 'Resolved' ? 'bg-green-100 text-green-800' : ($complaint->status === 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ $complaint->status }}
            </span>
        </p>
    </div>

    @if ($complaint->file_path && Storage::exists($complaint->file_path))
                <p class="mt-4"><strong>Attached File:</strong></p>
                <div class="flex space-x-4">
                    <!-- Preview File -->
                    <a href="{{ route('complaints.preview', $complaint->id) }}" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                        Preview File
                    </a>

                    <!-- Download File -->
                    <a href="{{ route('complaints.download', $complaint->id) }}"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">
                        Download File
                    </a>
                </div>
            @endif

    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Comments</h2>
        @if($comments->isEmpty())
            <p class="text-gray-500">No comments yet.</p>
        @else
            <ul class="space-y-4">
                @foreach($comments as $comment)
                <li class="bg-gray-50 p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-lg font-medium text-gray-700">{{ $comment->user->name }}</span>
                        <span class="text-sm text-gray-500">{{ $comment->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <p class="text-gray-600">{{ $comment->content }}</p>
                </li>
                @endforeach
            </ul>
        @endif
    </div>

    <a href="{{ route('student.dashboard') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white font-medium rounded shadow hover:bg-blue-500 transition duration-150">
        Back to Dashboard
    </a>
</div>
@endsection
