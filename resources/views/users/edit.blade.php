@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
        @csrf
        @method('PUT')

        <!-- Input Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Name</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Input Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" id="password">
            <small class="text-sm text-gray-600">Kosongkan jika tidak ingin mengubah password.</small>
        </div>

        <!-- Select Role -->
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-medium">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection