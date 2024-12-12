@extends('layouts.student')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Student Dashboard</h1>

    <!-- Display session or error messages -->
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

    <!-- Button to Submit a Complaint -->
    <div class="mb-6">
        <a href="{{ route('student.complaints.create') }}" 
           class="inline-block bg-blue-600 text-white px-5 py-3 rounded shadow-md hover:bg-blue-700 transition">
            Submit a Complaint
        </a>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Submitted On</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($complaints as $complaint)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-blue-600 font-medium cursor-pointer" onclick="window.location='{{ route('student.complaints.show', $complaint) }}'">
                            {{ $complaint->title }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-sm font-medium rounded {{ $complaint->status === 'resolved' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                {{ ucfirst($complaint->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $complaint->created_at->format('F j, Y, g:i a') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No complaints submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
