<?php

use Illuminate\Database\Seeder;
use App\Models\Test;

class TestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test = Test::firstOrNew([
            'title' => '抽奖问答',
        ]);
        if (!$test->exists) {
            $test->fill([
                'question_ids'       => [1,2,3,4,5,6,7,8],
                'status'       => 1
            ])->save();
        }
    }
}
