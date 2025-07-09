<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Statistik Dokumen -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Dokumen</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalDocuments }}</p>
                        <a href="{{ route('documents.index') }}" class="mt-4 inline-block text-sm text-blue-600 hover:text-blue-800">Lihat Semua Dokumen →</a>
                    </div>
                </div>

                <!-- Statistik Kategori -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Kategori</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $totalCategories }}</p>
                        <a href="{{ route('categories.index') }}" class="mt-4 inline-block text-sm text-green-600 hover:text-green-800">Kelola Kategori →</a>
                    </div>
                </div>

                <!-- Statistik Tag -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Tag</h3>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalTags }}</p>
                        <a href="{{ route('tags.index') }}" class="mt-4 inline-block text-sm text-purple-600 hover:text-purple-800">Kelola Tag →</a>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Cepat -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('documents.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Upload Dokumen Baru
                        </a>
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Kategori
                        </a>
                        <a href="{{ route('tags.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Tag
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
