@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-6 p-6 bg-white shadow-lg rounded-lg">

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-blue-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Title</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Assigned To</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $complaint)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('admin.complaints.show', $complaint) }}" 
                           class="text-blue-600 hover:underline font-medium">
                           {{ $complaint->title }}
                        </a>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <span class="px-3 py-1 rounded-full 
                            {{ $complaint->status === 'Resolved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                            {{ ucfirst($complaint->status) }}
                        </span>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $complaint->assignedTo->name ?? 'Unassigned' }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $complaint->created_at->format('M d, Y h:i A') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
