<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Karena database mysql ini baru di migrate (masih kosong),
// jadinya tabel user masih belum ada data jadi mau tidak mau solusi tercepat sementara membuat database seeder untuk demo

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan proteksi foreign key sementara karna sebelumnya error pada foreign keynya jadinya dicegat MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Bersihkan data lama jika ada demi menghindari duplikat ID 1 (karna sebelumnya udah mencoba seeder tapi masih error jadinya di bypass lagi)
        DB::table('users')->where('id', 1)->delete();
        DB::table('threads')->where('id', 1)->delete();

        // 2. Suntik User ID 1 lagi
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Naufal Demo',
            'email' => 'naufal@demo.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Suntik Thread ID 1 lagi
        DB::table('threads')->insert([
            'id' => 1,
            'user_id' => 1,
            'content' => 'Halo guys, ini project UAS Threads kelompok kita!',
            'image' => null,
            'parent_thread_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Hidupkan kembali proteksi foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}