<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use App\Models\ServiceField;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PENGADUAN
        $pengaduan = ServiceType::create([
            'key' => 'pengaduan',
            'nama_layanan' => 'Pengaduan Masyarakat',
            'kategori' => 'Pengaduan',
            'is_builtin' => true,
            'status' => 'aktif',
        ]);

        $this->createFields($pengaduan->id, [
            ['field_key' => 'nama_pelapor', 'label' => 'Nama Pelapor', 'field_type' => 'text', 'validation_rule' => 'required|string|max:100', 'is_required' => true, 'urutan' => 1],
            ['field_key' => 'kategori_masalah', 'label' => 'Kategori Masalah', 'field_type' => 'select', 'options' => ['Jalan Rusak', 'Sampah', 'Lampu Mati', 'Keamanan', 'Lainnya'], 'validation_rule' => 'required|string', 'is_required' => true, 'urutan' => 2],
            ['field_key' => 'deskripsi', 'label' => 'Deskripsi Masalah', 'field_type' => 'textarea', 'validation_rule' => 'required|string|max:1000', 'is_required' => true, 'urutan' => 3],
            ['field_key' => 'lokasi', 'label' => 'Lokasi Kejadian', 'field_type' => 'text', 'validation_rule' => 'required|string|max:255', 'is_required' => true, 'urutan' => 4],
            ['field_key' => 'foto_bukti', 'label' => 'Foto Bukti', 'field_type' => 'file', 'validation_rule' => 'nullable|file|image|max:5120', 'is_required' => false, 'urutan' => 5],
        ]);

        // 2. PERIZINAN
        $perizinan = ServiceType::create([
            'key' => 'perizinan',
            'nama_layanan' => 'Perizinan Usaha Mikro',
            'kategori' => 'Ekonomi',
            'is_builtin' => true,
            'status' => 'aktif',
        ]);

        $this->createFields($perizinan->id, [
            ['field_key' => 'nama_usaha', 'label' => 'Nama Usaha', 'field_type' => 'text', 'validation_rule' => 'required|string|max:150', 'is_required' => true, 'urutan' => 1],
            ['field_key' => 'jenis_usaha', 'label' => 'Jenis Usaha', 'field_type' => 'text', 'validation_rule' => 'required|string|max:100', 'is_required' => true, 'urutan' => 2],
            ['field_key' => 'nik_pemilik', 'label' => 'NIK Pemilik', 'field_type' => 'text', 'validation_rule' => 'required|digits:16', 'is_required' => true, 'urutan' => 3],
            ['field_key' => 'alamat_usaha', 'label' => 'Alamat Usaha', 'field_type' => 'textarea', 'validation_rule' => 'required|string|max:500', 'is_required' => true, 'urutan' => 4],
            ['field_key' => 'foto_ktp', 'label' => 'Foto KTP', 'field_type' => 'file', 'validation_rule' => 'required|file|image|max:5120', 'is_required' => true, 'urutan' => 5],
        ]);

        // 3. PEMBUKUAN
        $pembukuan = ServiceType::create([
            'key' => 'pembukuan',
            'nama_layanan' => 'Pembukuan Desa',
            'kategori' => 'Administrasi',
            'is_builtin' => true,
            'status' => 'aktif',
        ]);

        $this->createFields($pembukuan->id, [
            ['field_key' => 'jenis_transaksi', 'label' => 'Jenis Transaksi', 'field_type' => 'select', 'options' => ['Pemasukan', 'Pengeluaran'], 'validation_rule' => 'required|string', 'is_required' => true, 'urutan' => 1],
            ['field_key' => 'jumlah', 'label' => 'Jumlah (Rp)', 'field_type' => 'number', 'validation_rule' => 'required|numeric|min:0', 'is_required' => true, 'urutan' => 2],
            ['field_key' => 'keterangan', 'label' => 'Keterangan', 'field_type' => 'textarea', 'validation_rule' => 'required|string|max:500', 'is_required' => true, 'urutan' => 3],
            ['field_key' => 'tanggal_transaksi', 'label' => 'Tanggal Transaksi', 'field_type' => 'date', 'validation_rule' => 'required|date', 'is_required' => true, 'urutan' => 4],
            ['field_key' => 'bukti_transaksi', 'label' => 'Bukti Transaksi', 'field_type' => 'file', 'validation_rule' => 'nullable|file|max:5120', 'is_required' => false, 'urutan' => 5],
        ]);
    }

    private function createFields(int $serviceTypeId, array $fields): void
    {
        foreach ($fields as $field) {
            ServiceField::create(array_merge($field, ['service_type_id' => $serviceTypeId]));
        }
    }
}
