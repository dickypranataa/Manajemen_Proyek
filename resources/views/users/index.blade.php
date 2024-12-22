@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Users</h1>
    <a href="{{ route('users.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 mb-4 inline-block">
        Tambah User
    </a>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-3 px-2 sm:px-6 text-left font-medium">ID</th>
                    <th class="py-3 px-2 sm:px-6 text-left font-medium">Username</th>
                    <th class="py-3 px-2 sm:px-6 text-left font-medium">Role</th>
                    <th class="py-3 px-2 sm:px-6 text-left font-medium">Tanggal Dibuat</th>
                    <th class="py-3 px-2 sm:px-6 text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-3 px-2 sm:px-6">{{ $user->id }}</td>
                    <td class="py-3 px-2 sm:px-6">{{ $user->name }}</td>
                    <td class="py-3 px-2 sm:px-6">{{ $user->role }}</td>
                    <td class="py-3 px-2 sm:px-6">{{ $user->created_at->format('d-m-Y') }}</td>
                    <td class="py-3 px-2 sm:px-6 text-center flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-400 text-white py-1 px-3 rounded-lg hover:bg-yellow-600 transition">
                            Edit
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-400 text-white py-1 px-3 rounded-lg hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection