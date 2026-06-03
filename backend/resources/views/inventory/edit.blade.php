@extends('layouts.app')

@section('title', 'Edit Inventaris - LabSys')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Barang</h1>

    <div class="bg-white shadow rounded-lg p-6">
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <div class="font-bold mb-2">Periksa kembali input berikut:</div>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('inventory.update', $inventaris) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="nama_alat">Nama Barang</label>
                    <input id="nama_alat" name="nama_alat" value="{{ old('nama_alat', $inventaris->nama_alat) }}" required class="w-full border rounded px-3 py-2">
                    @error('nama_alat')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="kategori_id">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih kategori --</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" @selected(old('kategori_id', $inventaris->kategori_id)==$kat->id)>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="kondisi">Kondisi</label>
                    <select id="kondisi" name="kondisi" required class="w-full border rounded px-3 py-2">
                        @foreach (['Baik','Rusak Ringan','Rusak Berat','Dalam Perbaikan'] as $k)
                            <option value="{{ $k }}" @selected(old('kondisi', $inventaris->kondisi)===$k)>{{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kondisi')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="jumlah">Jumlah</label>
                    <input id="jumlah" name="jumlah" type="number" min="1" value="{{ old('jumlah', $inventaris->jumlah) }}" required class="w-full border rounded px-3 py-2">
                    @error('jumlah')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="lokasi">Lokasi</label>
                    <input id="lokasi" name="lokasi" value="{{ old('lokasi', $inventaris->lokasi) }}" class="w-full border rounded px-3 py-2">
                    @error('lokasi')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="nomor_seri">Nomor Serial</label>
                    <input id="nomor_seri" name="nomor_seri" value="{{ old('nomor_seri', $inventaris->nomor_seri) }}" class="w-full border rounded px-3 py-2">
                    @error('nomor_seri')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="tanggal_pengadaan">Tanggal Pengadaan</label>
                    <input id="tanggal_pengadaan" name="tanggal_pengadaan" type="date" value="{{ old('tanggal_pengadaan', optional($inventaris->tanggal_pengadaan)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2">
                    @error('tanggal_pengadaan')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1" for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $inventaris->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('inventory.index') }}" class="px-4 py-2 rounded border hover:bg-gray-50">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

