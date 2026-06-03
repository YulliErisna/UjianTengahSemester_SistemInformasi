<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventarisRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Otorisasi ditangani di controller via Gate::allows('manage-inventaris')
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_alat' => ['sometimes', 'required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'integer', 'exists:kategoris,id'],
            'kondisi' => ['sometimes', 'required', 'string', 'in:Baik,Rusak Ringan,Rusak Berat,Dalam Perbaikan'],
            'jumlah' => ['sometimes', 'required', 'integer', 'min:1'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'nomor_seri' => ['nullable', 'string', 'max:255'],
            'tanggal_pengadaan' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_alat.required' => 'Nama barang wajib diisi.',
            'kondisi.in' => 'Kondisi tidak valid.',
        ];
    }
}

