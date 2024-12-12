@extends('layouts.student')

@section('content')
<div class="container mx-auto mt-6 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Complaint Details</h1>

    <div class="mb-6">
        <p class="text-lg"><strong>Title:</strong> {{ $complaint->title }}</p>
        <p class="text-lg"><strong>Description:</strong> {{ $complaint->description }}</p>
        <p class="text-lg"><strong>Status:</strong> 
            <span class="px-3 py-1 rounded-full {{ $complaint->status === 'Resolved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                {{ ucfirst($complaint->status) }}
            </span>
        </p>
    </div>

    @if($complaint->file_path && Storage::exists($complaint->file_path))
    <p class="mt-4"><strong>Attached File:</strong></p>
    <div class="flex space-x-4">
        <!-- Preview File -->
        <a href="{{ route('complaints.preview', $complaint->id) }}" 
           target="_blank" 
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


    <h2 class="text-2xl font-bold mb-4">Comments</h2>
    @if($comments->isEmpty())
        <p class="text-gray-500">No comments yet.</p>
    @else
        <ul class="space-y-4">
            @foreach($comments as $comment)
                <li class="p-4 bg-gray-100 rounded shadow-sm">
                    <div class="flex justify-between">
                        <strong class="text-blue-600">{{ $comment->user->name }}</strong>
                        <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 text-gray-700">{{ $comment->content }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
