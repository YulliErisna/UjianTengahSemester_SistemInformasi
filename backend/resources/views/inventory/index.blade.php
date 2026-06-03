@extends('layouts.app')

@section('title', 'Inventaris - LabSys')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Inventaris</h1>
        <a href="{{ route('inventory.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Tambah Barang
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('inventory.index') }}" class="mb-4">
        <div class="flex gap-2">
            <input name="search" value="{{ request('search') }}" placeholder="Cari nama/nama seri/deskripsi" class="flex-1 border rounded px-3 py-2">
            <button type="submit" class="bg-gray-900 text-white px-3 py-2 rounded">Cari</button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Kondisi</th>
                    <th class="px-4 py-3 text-left">Jumlah</th>
                    <th class="px-4 py-3 text-left">Lokasi</th>
                    <th class="px-4 py-3 text-left">Serial</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($inventaris as $item)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $item->nama_alat }}</td>
<td class="px-4 py-3">{{ optional($item->kategori)->nama_kategori ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->kondisi }}</td>
                        <td class="px-4 py-3">{{ $item->jumlah }}</td>
                        <td class="px-4 py-3">{{ $item->lokasi ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->nomor_seri ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('inventory.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('inventory.destroy', $item) }}" class="inline" onsubmit="return confirm('Hapus inventaris ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data inventaris.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $inventaris->links() }}
    </div>
</div>
@endsection

