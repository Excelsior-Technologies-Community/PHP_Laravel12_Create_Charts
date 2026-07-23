<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        \App\Models\Chart::insert([
            ['title' => 'Monthly Sales', 'type' => 'bar', 'labels' => json_encode(['Jan','Feb','Mar','Apr','May','Jun']), 'values' => json_encode([1200,1900,300,500,200,800]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Revenue Growth', 'type' => 'line', 'labels' => json_encode(['Q1','Q2','Q3','Q4']), 'values' => json_encode([4500,5200,4800,6000]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Category Share', 'type' => 'pie', 'labels' => json_encode(['Electronics','Clothing','Books','Other']), 'values' => json_encode([40,25,20,15]), 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Skills', 'type' => 'radar', 'labels' => json_encode(['PHP','JS','CSS','Laravel','React']), 'values' => json_encode([90,85,70,95,80]), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
