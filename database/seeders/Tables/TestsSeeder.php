<?php
namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestsSeeder extends Seeder
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
                'id' => 1,
                'title' => 'Test_1',
                'created_at' => '2025-05-15 17:11:39',
                'updated_at' => '2025-05-15 17:11:39',
            ],
            [
                'id' => 2,
                'title' => 'Test_2',
                'created_at' => '2025-05-15 17:12:49',
                'updated_at' => '2025-05-15 17:12:49',
            ],
            [
                'id' => 3,
                'title' => 'Test_3',
                'created_at' => '2025-05-15 17:18:24',
                'updated_at' => '2025-05-15 17:18:24',
            ],
            [
                'id' => 4,
                'title' => 'Test_4',
                'created_at' => '2025-05-15 17:19:51',
                'updated_at' => '2025-05-15 17:19:51',
            ],
            [
                'id' => 5,
                'title' => 'Test_5',
                'created_at' => '2025-05-15 17:20:21',
                'updated_at' => '2025-05-15 17:20:21',
            ],
            [
                'id' => 6,
                'title' => 'Test_6',
                'created_at' => '2025-05-15 17:22:17',
                'updated_at' => '2025-05-15 17:22:17',
            ],
            [
                'id' => 7,
                'title' => 'Test_7',
                'created_at' => '2025-05-15 17:23:12',
                'updated_at' => '2025-05-15 17:23:12',
            ],
            [
                'id' => 8,
                'title' => 'Test_8',
                'created_at' => '2025-05-15 17:24:10',
                'updated_at' => '2025-05-15 17:24:10',
            ],
            [
                'id' => 9,
                'title' => 'Test_9',
                'created_at' => '2025-05-15 17:24:46',
                'updated_at' => '2025-05-15 17:24:46',
            ],
            [
                'id' => 10,
                'title' => 'Test_10',
                'created_at' => '2025-05-15 17:25:12',
                'updated_at' => '2025-05-15 17:25:12',
            ],
            [
                'id' => 11,
                'title' => 'Test_11',
                'created_at' => '2025-05-15 17:25:51',
                'updated_at' => '2025-05-15 17:25:51',
            ],
            [
                'id' => 12,
                'title' => 'Test_12',
                'created_at' => '2025-05-15 17:26:23',
                'updated_at' => '2025-05-15 17:26:23',
            ],
            [
                'id' => 13,
                'title' => 'Test_13',
                'created_at' => '2025-05-15 17:26:51',
                'updated_at' => '2025-05-15 17:26:51',
            ],
            [
                'id' => 14,
                'title' => 'Test_14',
                'created_at' => '2025-05-15 17:27:32',
                'updated_at' => '2025-05-15 17:27:32',
            ],
            [
                'id' => 15,
                'title' => 'Test_15',
                'created_at' => '2025-05-15 17:28:05',
                'updated_at' => '2025-05-15 17:28:05',
            ],
            [
                'id' => 16,
                'title' => 'Test_16',
                'created_at' => '2025-05-15 17:28:58',
                'updated_at' => '2025-05-15 17:28:58',
            ],
            [
                'id' => 17,
                'title' => 'Test_17',
                'created_at' => '2025-05-15 17:29:31',
                'updated_at' => '2025-05-15 17:29:31',
            ],
            [
                'id' => 18,
                'title' => 'Test_18',
                'created_at' => '2025-05-15 17:29:56',
                'updated_at' => '2025-05-15 17:29:56',
            ],
            [
                'id' => 19,
                'title' => 'Test_19',
                'created_at' => '2025-05-15 17:30:42',
                'updated_at' => '2025-05-15 17:30:42',
            ],
            [
                'id' => 20,
                'title' => 'Test_20',
                'created_at' => '2025-05-15 17:31:07',
                'updated_at' => '2025-05-15 17:31:07',
            ],
            [
                'id' => 21,
                'title' => 'Test_21',
                'created_at' => '2025-05-15 17:31:31',
                'updated_at' => '2025-05-15 17:31:31',
            ],
            [
                'id' => 22,
                'title' => 'Test_22',
                'created_at' => '2025-05-15 17:31:53',
                'updated_at' => '2025-05-15 17:31:53',
            ],
            [
                'id' => 23,
                'title' => 'Test_23',
                'created_at' => '2025-05-15 17:32:15',
                'updated_at' => '2025-05-15 17:32:15',
            ],
            [
                'id' => 24,
                'title' => 'Test_24',
                'created_at' => '2025-05-15 17:32:38',
                'updated_at' => '2025-05-15 17:32:38',
            ],
            [
                'id' => 25,
                'title' => 'Test_25',
                'created_at' => '2025-05-15 17:33:00',
                'updated_at' => '2025-05-15 17:33:00',
            ],
            [
                'id' => 26,
                'title' => 'Test_26',
                'created_at' => '2025-05-15 17:33:25',
                'updated_at' => '2025-05-15 17:33:25',
            ],
            [
                'id' => 27,
                'title' => 'Test_27',
                'created_at' => '2025-05-15 17:33:46',
                'updated_at' => '2025-05-15 17:33:46',
            ],
            [
                'id' => 28,
                'title' => 'Test_28',
                'created_at' => '2025-05-15 17:34:28',
                'updated_at' => '2025-05-15 17:34:28',
            ]
        ];
        
        DB::table("tests")->insert($dataTables);
    }
}