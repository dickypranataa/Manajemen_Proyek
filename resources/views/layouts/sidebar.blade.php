@php $user = Auth::user() @endphp

<!-- Sidebar -->
<div id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen fixed md:relative transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 z-40">
    <div class="p-6">
        <h4 class="text-2xl font-bold">Admin Dashboard</h4>
    </div>
    <div class="space-y-2">
        <!-- Menu Dashboard -->
        <a href="{{ route('dashboard.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded transition">Dashboard</a>

        <!-- Menu Notifikasi -->
        <a href="{{ route('notifikasi.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded transition flex items-center">
            Notifikasi
            @isset($totalNotifications)
            @if($totalNotifications > 0)
            <span class="ml-2 bg-red-600 text-white text-sm font-bold px-2 py-1 rounded-full">
                {{ $totalNotifications }}
            </span>
            @endif
            @endisset
        </a>

        <!-- Menu Users -->
        @if($user->role == 'admin')
        <a href="{{ route('users.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded transition">Users List</a>
        @endif

        <!-- Menu Barang -->
        @if($user->role == 'admin' || $user->role == 'employee')
        <a href="{{ route('barang.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded transition">Barang</a>
        @endif

        @if($user->role == 'admin')
        <a href="{{ route('transaksi.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded transition">Transaksi</a>
        @endif

        @if($user->role == 'admin')
        <a href="{{ route('laporan.index') }}" class="block py-2 px-4 hover:bg-gray-700 rounded transition">Laporan</a>
        @endif

        <!-- Menu Logout -->
        <form action="{{ route('logout') }}" method="POST" class="inline w-full">
            @csrf
            <button type="submit" class="block py-2 px-4 hover:bg-gray-700 rounded transition text-left w-full">
                Logout
            </button>
        </form>
    </div>
</div>

<!-- Tombol Toggle -->
<button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-gray-800 text-white p-2 rounded">
    ☰
</button>

<!-- JavaScript untuk Toggle -->
<script>
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full'); // Toggle sidebar
    });
</script>