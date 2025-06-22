<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roadmap;

class RoadmapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['planned', 'in-progress', 'completed'];

        for ($i = 1; $i <= 10; $i++) {
            Roadmap::create([
                'title' => "Roadmap Item $i",
                'description' => "This is a description for Roadmap Item $i.",
                'status' => $statuses[array_rand($statuses)],
                'category' => ['UI', 'Backend', 'API', 'Feature'][array_rand([0, 1, 2, 3])],
            ]);
        }
    }
}
