<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventarisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_alat' => ['required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'exists:kategoris,id'],
            'kondisi' => ['required', 'in:Baik,Rusak Ringan,Rusak Berat,Dalam Perbaikan'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'nomor_seri' => ['nullable', 'string', 'max:255'],
            'tanggal_pengadaan' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}

