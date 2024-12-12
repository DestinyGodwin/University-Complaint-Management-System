@extends('layouts.staff')

@section('content')
<div class="container mx-auto mt-6 p-6 bg-gray-100 rounded shadow-md">
    <h1 class="text-3xl font-bold mb-4 text-gray-800">Assigned Complaints</h1>

    <table class="w-full border-collapse bg-white shadow rounded">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="text-left p-4">Title</th>
                <th class="text-left p-4">Status</th>
                <th class="text-left p-4">Submitted At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($complaints as $complaint)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">
                        <a href="{{ route('staff.complaints.show', $complaint) }}" class="text-blue-600 hover:underline">
                            {{ $complaint->title }}
                        </a>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded {{ $complaint->status === 'Resolved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                            {{ $complaint->status }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-600">{{ $complaint->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">No complaints assigned yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
