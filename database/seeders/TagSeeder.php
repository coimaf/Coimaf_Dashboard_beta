<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagNames = ['Tag1', 'Tag2', 'Tag3', 'Tag4', 'Tag5'];

        foreach ($tagNames as $tagName) {
            Tag::create([
                'name' => $tagName,
            ]);
        }
    }
}
