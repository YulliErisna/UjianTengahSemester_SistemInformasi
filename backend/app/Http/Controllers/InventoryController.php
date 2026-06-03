<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventarisRequest;
use App\Http\Requests\UpdateInventarisRequest;
use App\Models\Inventaris;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function __construct()
    {
        // Opsional: proteksi dengan middleware auth.
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $query = Inventaris::with('kategori');

        if ($request->filled('search')) {
            $q = $request->input('search');
            $query->where(function ($qq) use ($q) {
                $qq->where('nama_alat', 'like', "%{$q}%")
                    ->orWhere('nomor_seri', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $inventaris = $query->latest()->paginate(10)->withQueryString();
        return view('inventory.index', compact('inventaris'));
    }

    public function create(): View
    {
        $kategoris = Kategori::query()->orderBy('nama_kategori')->get();
        return view('inventory.create', compact('kategoris'));
    }

    public function store(StoreInventarisRequest $request): RedirectResponse
    {
        Inventaris::create($request->validated());
        return redirect()->route('inventory.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function edit(Inventaris $inventaris): View
    {
        $kategoris = Kategori::query()->orderBy('nama_kategori')->get();
        return view('inventory.edit', compact('inventaris', 'kategoris'));
    }

    public function update(UpdateInventarisRequest $request, Inventaris $inventaris): RedirectResponse
    {
        $inventaris->update($request->validated());
        return redirect()->route('inventory.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventaris): RedirectResponse
    {
        $inventaris->delete();
        return redirect()->route('inventory.index')->with('success', 'Inventaris berhasil dihapus.');
    }
}

