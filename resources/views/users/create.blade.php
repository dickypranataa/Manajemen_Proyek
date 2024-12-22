@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah User Baru</h1>

    <form action="{{ route('users.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
        @csrf

        <!-- Input Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Username</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" id="username" required>
            @error('name')
                <small class="text-danger text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <!-- Input Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" id="password" required>
            @error('password')
                <small class="text-danger text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <!-- Select Role -->
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-medium">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="vendor">Vendor</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
            Simpan
        </button>
    </form>
</div>
@endsection