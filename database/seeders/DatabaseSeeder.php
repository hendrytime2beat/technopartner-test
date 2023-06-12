<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('m_users')->insert([
        	'name_user' => 'Administrator',
        	'username' => 'admin',
        	'password' => md5('admin'),
        	'profile_picture' => '-',
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        
        DB::table('m_users')->insert([
        	'name_user' => 'User',
        	'username' => 'user',
        	'password' => md5('user'),
        	'profile_picture' => '-',
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
