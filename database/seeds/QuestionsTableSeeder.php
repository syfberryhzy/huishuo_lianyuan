<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = Question::firstOrNew([
            'question' => '垃圾可以分成几类？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.两类; \r\nB.三类;\r\nC.四类;\r\nD.五类;",
                'corrent'       => 'C',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '下列哪个不属于厨余垃圾？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.过期食品; \r\nB.剩饭剩菜;\r\nC.鱼刺和骨头;\r\nD.废弃的金属勺子;",
                'corrent'       => 'D',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '联运环境的可回收垃圾箱箱体是什么颜色？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.绿色; \r\nB.红色;\r\nC.蓝色;\r\nD.黄色;",
                'corrent'       => 'C',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '下列哪些不属于可回收垃圾？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.废铁丝、废铁; \r\nB.用过的餐巾纸、茶叶渣;\r\nC.玻璃瓶、废塑;\r\nD.旧衣服、废报纸;",
                'corrent'       => 'B',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '下列哪个不是有害垃圾？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.碎玻璃片; \r\nB.过期药品;\r\nC.废水银温度;\r\nD.废电池;",
                'corrent'       => 'A',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '过期药品属于_____，需要特殊安全处理？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.其他垃圾; \r\nB.有害垃圾;\r\nC.不可回收垃圾;\r\nD.餐厨垃圾;",
                'corrent'       => 'B',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '哪种垃圾可以作为肥料滋养土壤、庄稼？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.厨余垃圾; \r\nB.可回收垃圾;\r\nC.有害垃圾;\r\nD.其他垃圾;",
                'corrent'       => 'A',
                'status'       => 1
            ])->save();
        }

        $question = Question::firstOrNew([
            'question' => '哪种垃圾可以再造成新瓶子、再生纸和塑料玩具？',
        ]);
        if (!$question->exists) {
            $question->fill([
                'options'       => "A.厨余垃圾; \r\nB.可回收垃圾;\r\nC.有害垃圾;\r\nD.其他垃圾;",
                'corrent'       => 'B',
                'status'       => 1
            ])->save();
        }
    }
}
