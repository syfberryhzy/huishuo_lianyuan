<?php

use Illuminate\Database\Seeder;
use App\Models\Award;

class AwardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $award = Award::firstOrNew([
            'title' => '一等奖：50元话费',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => '0',
                'end_probability'       => "60.00",
                'number'  => 4,
                'is_lottery'          => 1
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '二等奖：1G流量套餐',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => '0',
                'end_probability'       => "60.00",
                'number'  => 10,
                'is_lottery'          => 1
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '三等奖：垃圾分类500积分',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 0,
                'end_probability'       => 0,
                'number'  => 15,
                'is_lottery'          => 1
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '谢谢参与',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 0,
                'end_probability'       => 0,
                'number'  => 0,
                'is_lottery'          => 0
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '不要灰心',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 0,
                'end_probability'       => 0,
                'number'  => 0,
                'is_lottery'          => 0
            ])->save();
        }

        $award = Award::firstOrNew([
            'title' => '要加油哦',
        ]);
        if (!$award->exists) {
            $award->fill([
                'activity_id'     => 1,
                'start_probability'       => 0,
                'end_probability'       => 0,
                'number'  => 0,
                'is_lottery'          => 0
            ])->save();
        }
    }
}
