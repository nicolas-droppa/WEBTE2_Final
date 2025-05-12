<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Tables\AnswersSeeder;
use Database\Seeders\Tables\QuestionsSeeder;
use Database\Seeders\Tables\QuestionTagSeeder;
use Database\Seeders\Tables\TagsSeeder;
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
        $this->call([
            QuestionsSeeder::class,
            AnswersSeeder::class,
            TagsSeeder::class,
            QuestionTagSeeder::class,
        ]);
    }
}
