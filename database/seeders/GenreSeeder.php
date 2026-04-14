<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = ['小説','ビジネス','技術書','自己啓発','歴史','語学','資格試験','コミック','エッセイ','その他'];

        foreach($genres as $name){
            Genre::firstOrCreate(['name' => $name]);
        }

    }
}

