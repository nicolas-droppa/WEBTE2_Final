<?php
namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Command :
         * artisan seed:generate --mode=table --tables=tests,test_question
         *
         */

        $dataTables = [
            [
                'test_id' => 1,
                'question_id' => 2,
            ],
            [
                'test_id' => 1,
                'question_id' => 3,
            ],
            [
                'test_id' => 1,
                'question_id' => 4,
            ],
            [
                'test_id' => 1,
                'question_id' => 5,
            ],
            [
                'test_id' => 1,
                'question_id' => 6,
            ],
            [
                'test_id' => 2,
                'question_id' => 7,
            ],
            [
                'test_id' => 2,
                'question_id' => 8,
            ],
            [
                'test_id' => 2,
                'question_id' => 9,
            ],
            [
                'test_id' => 2,
                'question_id' => 10,
            ],
            [
                'test_id' => 2,
                'question_id' => 11,
            ],
            [
                'test_id' => 3,
                'question_id' => 12,
            ],
            [
                'test_id' => 3,
                'question_id' => 13,
            ],
            [
                'test_id' => 3,
                'question_id' => 14,
            ],
            [
                'test_id' => 3,
                'question_id' => 15,
            ],
            [
                'test_id' => 3,
                'question_id' => 16,
            ],
            [
                'test_id' => 4,
                'question_id' => 17,
            ],
            [
                'test_id' => 4,
                'question_id' => 18,
            ],
            [
                'test_id' => 4,
                'question_id' => 19,
            ],
            [
                'test_id' => 4,
                'question_id' => 20,
            ],
            [
                'test_id' => 4,
                'question_id' => 21,
            ],
            [
                'test_id' => 5,
                'question_id' => 22,
            ],
            [
                'test_id' => 5,
                'question_id' => 23,
            ],
            [
                'test_id' => 5,
                'question_id' => 27,
            ],
            [
                'test_id' => 5,
                'question_id' => 28,
            ],
            [
                'test_id' => 5,
                'question_id' => 29,
            ],
            [
                'test_id' => 6,
                'question_id' => 30,
            ],
            [
                'test_id' => 6,
                'question_id' => 31,
            ],
            [
                'test_id' => 6,
                'question_id' => 32,
            ],
            [
                'test_id' => 6,
                'question_id' => 33,
            ],
            [
                'test_id' => 6,
                'question_id' => 34,
            ],
            [
                'test_id' => 7,
                'question_id' => 35,
            ],
            [
                'test_id' => 7,
                'question_id' => 36,
            ],
            [
                'test_id' => 7,
                'question_id' => 37,
            ],
            [
                'test_id' => 7,
                'question_id' => 38,
            ],
            [
                'test_id' => 7,
                'question_id' => 39,
            ],
            [
                'test_id' => 8,
                'question_id' => 40,
            ],
            [
                'test_id' => 8,
                'question_id' => 41,
            ],
            [
                'test_id' => 8,
                'question_id' => 42,
            ],
            [
                'test_id' => 8,
                'question_id' => 43,
            ],
            [
                'test_id' => 8,
                'question_id' => 44,
            ],
            [
                'test_id' => 9,
                'question_id' => 45,
            ],
            [
                'test_id' => 9,
                'question_id' => 46,
            ],
            [
                'test_id' => 9,
                'question_id' => 47,
            ],
            [
                'test_id' => 9,
                'question_id' => 48,
            ],
            [
                'test_id' => 9,
                'question_id' => 49,
            ],
            [
                'test_id' => 10,
                'question_id' => 50,
            ],
            [
                'test_id' => 10,
                'question_id' => 51,
            ],
            [
                'test_id' => 10,
                'question_id' => 52,
            ],
            [
                'test_id' => 10,
                'question_id' => 53,
            ],
            [
                'test_id' => 10,
                'question_id' => 55,
            ],
            [
                'test_id' => 11,
                'question_id' => 56,
            ],
            [
                'test_id' => 11,
                'question_id' => 57,
            ],
            [
                'test_id' => 11,
                'question_id' => 58,
            ],
            [
                'test_id' => 11,
                'question_id' => 59,
            ],
            [
                'test_id' => 11,
                'question_id' => 60,
            ],
            [
                'test_id' => 12,
                'question_id' => 61,
            ],
            [
                'test_id' => 12,
                'question_id' => 62,
            ],
            [
                'test_id' => 12,
                'question_id' => 63,
            ],
            [
                'test_id' => 12,
                'question_id' => 64,
            ],
            [
                'test_id' => 12,
                'question_id' => 65,
            ],
            [
                'test_id' => 13,
                'question_id' => 66,
            ],
            [
                'test_id' => 13,
                'question_id' => 67,
            ],
            [
                'test_id' => 13,
                'question_id' => 68,
            ],
            [
                'test_id' => 13,
                'question_id' => 69,
            ],
            [
                'test_id' => 13,
                'question_id' => 70,
            ],
            [
                'test_id' => 14,
                'question_id' => 71,
            ],
            [
                'test_id' => 14,
                'question_id' => 72,
            ],
            [
                'test_id' => 14,
                'question_id' => 73,
            ],
            [
                'test_id' => 14,
                'question_id' => 74,
            ],
            [
                'test_id' => 14,
                'question_id' => 75,
            ],
            [
                'test_id' => 15,
                'question_id' => 76,
            ],
            [
                'test_id' => 15,
                'question_id' => 77,
            ],
            [
                'test_id' => 15,
                'question_id' => 78,
            ],
            [
                'test_id' => 15,
                'question_id' => 79,
            ],
            [
                'test_id' => 15,
                'question_id' => 80,
            ],
            [
                'test_id' => 16,
                'question_id' => 81,
            ],
            [
                'test_id' => 16,
                'question_id' => 82,
            ],
            [
                'test_id' => 16,
                'question_id' => 83,
            ],
            [
                'test_id' => 16,
                'question_id' => 84,
            ],
            [
                'test_id' => 16,
                'question_id' => 85,
            ],
            [
                'test_id' => 17,
                'question_id' => 86,
            ],
            [
                'test_id' => 17,
                'question_id' => 87,
            ],
            [
                'test_id' => 17,
                'question_id' => 88,
            ],
            [
                'test_id' => 17,
                'question_id' => 89,
            ],
            [
                'test_id' => 17,
                'question_id' => 90,
            ],
            [
                'test_id' => 18,
                'question_id' => 91,
            ],
            [
                'test_id' => 18,
                'question_id' => 92,
            ],
            [
                'test_id' => 18,
                'question_id' => 93,
            ],
            [
                'test_id' => 18,
                'question_id' => 94,
            ],
            [
                'test_id' => 18,
                'question_id' => 95,
            ],
            [
                'test_id' => 19,
                'question_id' => 96,
            ],
            [
                'test_id' => 19,
                'question_id' => 97,
            ],
            [
                'test_id' => 19,
                'question_id' => 98,
            ],
            [
                'test_id' => 19,
                'question_id' => 99,
            ],
            [
                'test_id' => 19,
                'question_id' => 100,
            ],
            [
                'test_id' => 20,
                'question_id' => 101,
            ],
            [
                'test_id' => 20,
                'question_id' => 102,
            ],
            [
                'test_id' => 20,
                'question_id' => 103,
            ],
            [
                'test_id' => 20,
                'question_id' => 104,
            ],
            [
                'test_id' => 20,
                'question_id' => 105,
            ],
            [
                'test_id' => 21,
                'question_id' => 106,
            ],
            [
                'test_id' => 21,
                'question_id' => 107,
            ],
            [
                'test_id' => 21,
                'question_id' => 108,
            ],
            [
                'test_id' => 21,
                'question_id' => 109,
            ],
            [
                'test_id' => 21,
                'question_id' => 110,
            ],
            [
                'test_id' => 22,
                'question_id' => 111,
            ],
            [
                'test_id' => 22,
                'question_id' => 112,
            ],
            [
                'test_id' => 22,
                'question_id' => 113,
            ],
            [
                'test_id' => 22,
                'question_id' => 114,
            ],
            [
                'test_id' => 22,
                'question_id' => 115,
            ],
            [
                'test_id' => 23,
                'question_id' => 116,
            ],
            [
                'test_id' => 23,
                'question_id' => 117,
            ],
            [
                'test_id' => 23,
                'question_id' => 118,
            ],
            [
                'test_id' => 23,
                'question_id' => 119,
            ],
            [
                'test_id' => 23,
                'question_id' => 120,
            ],
            [
                'test_id' => 24,
                'question_id' => 121,
            ],
            [
                'test_id' => 24,
                'question_id' => 122,
            ],
            [
                'test_id' => 24,
                'question_id' => 123,
            ],
            [
                'test_id' => 24,
                'question_id' => 124,
            ],
            [
                'test_id' => 24,
                'question_id' => 125,
            ],
            [
                'test_id' => 25,
                'question_id' => 126,
            ],
            [
                'test_id' => 25,
                'question_id' => 127,
            ],
            [
                'test_id' => 25,
                'question_id' => 128,
            ],
            [
                'test_id' => 25,
                'question_id' => 129,
            ],
            [
                'test_id' => 25,
                'question_id' => 130,
            ],
            [
                'test_id' => 26,
                'question_id' => 131,
            ],
            [
                'test_id' => 26,
                'question_id' => 132,
            ],
            [
                'test_id' => 26,
                'question_id' => 133,
            ],
            [
                'test_id' => 26,
                'question_id' => 134,
            ],
            [
                'test_id' => 26,
                'question_id' => 135,
            ],
            [
                'test_id' => 27,
                'question_id' => 136,
            ],
            [
                'test_id' => 27,
                'question_id' => 137,
            ],
            [
                'test_id' => 27,
                'question_id' => 138,
            ],
            [
                'test_id' => 28,
                'question_id' => 138,
            ],
            [
                'test_id' => 27,
                'question_id' => 139,
            ],
            [
                'test_id' => 28,
                'question_id' => 139,
            ],
            [
                'test_id' => 27,
                'question_id' => 140,
            ],
            [
                'test_id' => 28,
                'question_id' => 141,
            ],
            [
                'test_id' => 28,
                'question_id' => 142,
            ],
            [
                'test_id' => 28,
                'question_id' => 143,
            ]
        ];
        
        DB::table("test_question")->insert($dataTables);
    }
}