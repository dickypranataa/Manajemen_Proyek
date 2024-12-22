<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create User</h2>

        <!-- Tampilkan error jika ada -->
        @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Input Name -->
            <div>
                <label for="name" class="block text-gray-600">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Select Role -->
            <div>
                <label for="role" class="block text-gray-600">Role</label>
                <select id="role" name="role"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
                    <option value="employee" selected>Employee</option>
                    <option value="admin">Admin</option>
                    <option value="vendor">Vendor</option>
                </select>
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                Create User
            </button>
        </form>
    </div>
</body>

</html>