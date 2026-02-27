<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        DB::table('users')->insert([
            'name' => 'Admin Sistem',
            'email' => 'admin@peminjaman.local',
            'password' => bcrypt('admin123'),
            'phone' => '081234567890',
            'address' => 'Gedung Pusat',
            'role' => 'admin',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Petugas User
        DB::table('users')->insert([
            'name' => 'Petugas Penyimpanan',
            'email' => 'petugas@peminjaman.local',
            'password' => bcrypt('petugas123'),
            'phone' => '081234567891',
            'address' => 'Gedung Penyimpanan',
            'role' => 'petugas',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Sample Peminjam Users
        for ($i = 1; $i <= 5; $i++) {
            DB::table('users')->insert([
                'name' => "Peminjam User $i",
                'email' => "peminjam$i@peminjaman.local",
                'password' => bcrypt('peminjam123'),
                'phone' => "0812345678" . str_pad($i, 2, '0', STR_PAD_LEFT),
                'address' => "Jalan Pendidikan No. $i",
                'role' => 'peminjam',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create Categories
        $categories = [
            ['name' => 'Peralatan Laboratorium', 'description' => 'Alat-alat untuk laboratorium'],
            ['name' => 'Peralatan Olahraga', 'description' => 'Alat-alat untuk kegiatan olahraga'],
            ['name' => 'Peralatan Multimedia', 'description' => 'Alat-alat untuk presentasi dan multimedia'],
            ['name' => 'Peralatan Kantor', 'description' => 'Alat-alat untuk kegiatan kantoran'],
            ['name' => 'Peralatan Elektronik', 'description' => 'Peralatan elektronik dan listrik'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create Sample Tools
        $tools = [
            // Lab Equipment
            ['category_id' => 1, 'name' => 'Mikroskop', 'code' => 'LAB001', 'quantity' => 5, 'available_quantity' => 5, 'condition' => 'sangat baik', 'location' => 'Lab A', 'description' => 'Mikroskop optik untuk praktikum biologi'],
            ['category_id' => 1, 'name' => 'Bunsen Burner', 'code' => 'LAB002', 'quantity' => 10, 'available_quantity' => 8, 'condition' => 'baik', 'location' => 'Lab Kimia', 'description' => 'Pembakar Bunsen untuk praktikum kimia'],
            ['category_id' => 1, 'name' => 'Buret', 'code' => 'LAB003', 'quantity' => 20, 'available_quantity' => 15, 'condition' => 'baik', 'location' => 'Lab Kimia', 'description' => 'Buret untuk titrasi'],

            // Sports Equipment
            ['category_id' => 2, 'name' => 'Bola Voli', 'code' => 'SPORT001', 'quantity' => 12, 'available_quantity' => 10, 'condition' => 'baik', 'location' => 'Gudang Olahraga', 'description' => 'Bola voli standar internasional'],
            ['category_id' => 2, 'name' => 'Raket Badminton', 'code' => 'SPORT002', 'quantity' => 20, 'available_quantity' => 18, 'condition' => 'baik', 'location' => 'Gudang Olahraga', 'description' => 'Raket badminton set'],
            ['category_id' => 2, 'name' => 'Tenis Meja', 'code' => 'SPORT003', 'quantity' => 2, 'available_quantity' => 2, 'condition' => 'sangat baik', 'location' => 'Ruang Olahraga', 'description' => 'Meja tenis meja portable'],

            // Multimedia Equipment
            ['category_id' => 3, 'name' => 'Proyektor LCD', 'code' => 'MM001', 'quantity' => 3, 'available_quantity' => 2, 'condition' => 'baik', 'location' => 'Ruang Multimedia', 'description' => 'Proyektor LCD 3000 lumen'],
            ['category_id' => 3, 'name' => 'Screen Proyektor', 'code' => 'MM002', 'quantity' => 4, 'available_quantity' => 4, 'condition' => 'sangat baik', 'location' => 'Ruang Multimedia', 'description' => 'Layar proyektor manual 200 inch'],
            ['category_id' => 3, 'name' => 'Speaker Aktif', 'code' => 'MM003', 'quantity' => 6, 'available_quantity' => 5, 'condition' => 'baik', 'location' => 'Ruang Multimedia', 'description' => 'Speaker aktif 2000W'],

            // Office Equipment
            ['category_id' => 4, 'name' => 'Laminating Machine', 'code' => 'OFF001', 'quantity' => 2, 'available_quantity' => 2, 'condition' => 'sangat baik', 'location' => 'Ruang Kerja', 'description' => 'Mesin laminating A4'],
            ['category_id' => 4, 'name' => 'Paper Shredder', 'code' => 'OFF002', 'quantity' => 1, 'available_quantity' => 1, 'condition' => 'baik', 'location' => 'Ruang Kerja', 'description' => 'Mesin penghancur dokumen'],

            // Electronics
            ['category_id' => 5, 'name' => 'Laptop', 'code' => 'ELEC001', 'quantity' => 8, 'available_quantity' => 6, 'condition' => 'baik', 'location' => 'Lab Komputer', 'description' => 'Laptop untuk praktikum'],
            ['category_id' => 5, 'name' => 'Kamera DSLR', 'code' => 'ELEC002', 'quantity' => 3, 'available_quantity' => 2, 'condition' => 'sangat baik', 'location' => 'Ruang Media', 'description' => 'Kamera DSLR Canon 24MP'],
        ];

        foreach ($tools as $tool) {
            DB::table('tools')->insert([
                'category_id' => $tool['category_id'],
                'name' => $tool['name'],
                'code' => $tool['code'],
                'quantity' => $tool['quantity'],
                'available_quantity' => $tool['available_quantity'],
                'condition' => $tool['condition'],
                'location' => $tool['location'],
                'description' => $tool['description'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
