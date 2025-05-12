<?php
namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
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
         * artisan seed:generate --mode=table --tables=tags,questions,answers,question_tag
         *
         */

        $dataTables = [
            [
                'id' => 1,
                'name_sk' => 'algebra',
                'name_en' => 'algebra',
                'created_at' => '2025-05-10 16:51:22',
                'updated_at' => '2025-05-10 16:51:22',
            ],
            [
                'id' => 2,
                'name_sk' => 'úprava výrazov',
                'name_en' => 'algebraic manipulation',
                'created_at' => '2025-05-10 16:51:22',
                'updated_at' => '2025-05-10 16:51:22',
            ],
            [
                'id' => 3,
                'name_sk' => 'zjednodušenie',
                'name_en' => 'simplification',
                'created_at' => '2025-05-10 16:51:22',
                'updated_at' => '2025-05-10 16:51:22',
            ],
            [
                'id' => 4,
                'name_sk' => 'zlomok',
                'name_en' => 'fraction',
                'created_at' => '2025-05-10 17:12:54',
                'updated_at' => '2025-05-10 17:12:54',
            ],
            [
                'id' => 5,
                'name_sk' => 'polynóm',
                'name_en' => 'polynomial',
                'created_at' => '2025-05-10 20:39:32',
                'updated_at' => '2025-05-10 20:39:32',
            ],
            [
                'id' => 6,
                'name_sk' => 'kvadratická rovnica',
                'name_en' => 'quadratic equation',
                'created_at' => '2025-05-10 20:39:32',
                'updated_at' => '2025-05-10 20:39:32',
            ],
            [
                'id' => 7,
                'name_sk' => 'absolútna hodnota',
                'name_en' => 'absolute value',
                'created_at' => '2025-05-10 20:51:01',
                'updated_at' => '2025-05-10 20:51:01',
            ],
            [
                'id' => 8,
                'name_sk' => 'lineárna rovnica',
                'name_en' => 'linear equation',
                'created_at' => '2025-05-10 20:51:01',
                'updated_at' => '2025-05-10 20:51:01',
            ],
            [
                'id' => 9,
                'name_sk' => 'odmocnina',
                'name_en' => 'square root',
                'created_at' => '2025-05-10 20:59:06',
                'updated_at' => '2025-05-10 20:59:06',
            ],
            [
                'id' => 10,
                'name_sk' => 'definičný obor funkcie',
                'name_en' => 'domain of a function',
                'created_at' => '2025-05-10 21:44:43',
                'updated_at' => '2025-05-10 21:44:43',
            ],
            [
                'id' => 11,
                'name_sk' => 'nerovnica',
                'name_en' => 'inequation',
                'created_at' => '2025-05-10 21:54:49',
                'updated_at' => '2025-05-10 21:54:49',
            ],
            [
                'id' => 12,
                'name_sk' => 'povrch',
                'name_en' => 'area',
                'created_at' => '2025-05-10 22:42:24',
                'updated_at' => '2025-05-10 22:42:24',
            ],
            [
                'id' => 13,
                'name_sk' => 'objem',
                'name_en' => 'volume',
                'created_at' => '2025-05-10 22:42:24',
                'updated_at' => '2025-05-10 22:42:24',
            ],
            [
                'id' => 14,
                'name_sk' => 'geometria',
                'name_en' => 'geometry',
                'created_at' => '2025-05-10 22:42:24',
                'updated_at' => '2025-05-10 22:42:24',
            ],
            [
                'id' => 15,
                'name_sk' => 'funkcia',
                'name_en' => 'function',
                'created_at' => '2025-05-10 22:52:08',
                'updated_at' => '2025-05-10 22:52:08',
            ],
            [
                'id' => 16,
                'name_sk' => 'logaritmus',
                'name_en' => 'logarithm',
                'created_at' => '2025-05-10 22:52:08',
                'updated_at' => '2025-05-10 22:52:08',
            ],
            [
                'id' => 17,
                'name_sk' => 'inverzná funkcia',
                'name_en' => 'inverse function',
                'created_at' => '2025-05-10 23:02:03',
                'updated_at' => '2025-05-10 23:02:03',
            ],
            [
                'id' => 18,
                'name_sk' => 'skladanie funkcií',
                'name_en' => 'function composition',
                'created_at' => '2025-05-10 23:19:44',
                'updated_at' => '2025-05-10 23:19:44',
            ],
            [
                'id' => 19,
                'name_sk' => 'trigonometria',
                'name_en' => 'trigonometry',
                'created_at' => '2025-05-10 23:26:03',
                'updated_at' => '2025-05-10 23:26:03',
            ],
            [
                'id' => 20,
                'name_sk' => 'rovnica',
                'name_en' => 'equation',
                'created_at' => '2025-05-10 23:55:41',
                'updated_at' => '2025-05-10 23:55:41',
            ],
            [
                'id' => 21,
                'name_sk' => 'exponenciálna rovnica',
                'name_en' => 'exponential equation',
                'created_at' => '2025-05-11 00:04:13',
                'updated_at' => '2025-05-11 00:04:13',
            ],
            [
                'id' => 25,
                'name_sk' => 'postupnosť',
                'name_en' => 'sequence',
                'created_at' => '2025-05-11 00:58:26',
                'updated_at' => '2025-05-11 00:58:26',
            ],
            [
                'id' => 26,
                'name_sk' => 'aritmetická postupnosť',
                'name_en' => 'arithmetic sequence',
                'created_at' => '2025-05-11 00:58:26',
                'updated_at' => '2025-05-11 00:58:26',
            ],
            [
                'id' => 27,
                'name_sk' => 'geometrická postupnosť',
                'name_en' => 'geometric sequence',
                'created_at' => '2025-05-11 01:16:37',
                'updated_at' => '2025-05-11 01:16:37',
            ],
            [
                'id' => 28,
                'name_sk' => 'rad',
                'name_en' => 'series',
                'created_at' => '2025-05-11 01:48:13',
                'updated_at' => '2025-05-11 01:48:13',
            ],
            [
                'id' => 29,
                'name_sk' => 'nekonečný rad',
                'name_en' => 'infinite series',
                'created_at' => '2025-05-11 01:48:13',
                'updated_at' => '2025-05-11 01:48:13',
            ],
            [
                'id' => 30,
                'name_sk' => 'kombinatorika',
                'name_en' => 'combinatorics',
                'created_at' => '2025-05-11 01:55:12',
                'updated_at' => '2025-05-11 01:55:12',
            ],
            [
                'id' => 31,
                'name_sk' => 'geometria v rovine',
                'name_en' => 'plane geometry',
                'created_at' => '2025-05-11 02:28:20',
                'updated_at' => '2025-05-11 02:28:20',
            ],
            [
                'id' => 32,
                'name_sk' => 'analyticá geometria v rovine',
                'name_en' => 'plane analytic geometry',
                'created_at' => '2025-05-11 03:03:24',
                'updated_at' => '2025-05-11 03:03:24',
            ],
            [
                'id' => 33,
                'name_sk' => 'vektorová algebra',
                'name_en' => 'vector algebra',
                'created_at' => '2025-05-11 03:03:24',
                'updated_at' => '2025-05-11 03:03:24',
            ],
            [
                'id' => 34,
                'name_sk' => 'analyticá geometria v priestore',
                'name_en' => 'analytic geometry in space',
                'created_at' => '2025-05-11 03:44:34',
                'updated_at' => '2025-05-11 03:44:34',
            ],
            [
                'id' => 36,
                'name_sk' => 'množina',
                'name_en' => 'set',
                'created_at' => '2025-05-11 19:39:49',
                'updated_at' => '2025-05-11 19:39:49',
            ],
            [
                'id' => 37,
                'name_sk' => 'výrok',
                'name_en' => 'statement',
                'created_at' => '2025-05-11 19:55:14',
                'updated_at' => '2025-05-11 19:55:14',
            ],
            [
                'id' => 38,
                'name_sk' => 'odpor',
                'name_en' => 'resistance',
                'created_at' => '2025-05-12 00:49:58',
                'updated_at' => '2025-05-12 00:49:58',
            ],
            [
                'id' => 39,
                'name_sk' => 'frekvencia',
                'name_en' => 'frequency',
                'created_at' => '2025-05-12 00:52:25',
                'updated_at' => '2025-05-12 00:52:25',
            ],
            [
                'id' => 40,
                'name_sk' => 'napätie',
                'name_en' => 'voltage',
                'created_at' => '2025-05-12 00:54:56',
                'updated_at' => '2025-05-12 00:54:56',
            ],
            [
                'id' => 41,
                'name_sk' => 'kritické myslenie',
                'name_en' => 'critical thinking',
                'created_at' => '2025-05-12 01:01:42',
                'updated_at' => '2025-05-12 01:01:42',
            ]
        ];
        
        DB::table("tags")->insert($dataTables);
    }
}