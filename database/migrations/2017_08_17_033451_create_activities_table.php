<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('活动主题')->unique();
            $table->dateTime('start_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间')->nullable();
            $table->decimal('getScore', 10, 2)->default('0.00')->comment('及格分数');
            $table->string('activity_week')->comment('活动周期（可多选）,分隔')->default('');
            $table->string('image')->comment('图片');
            $table->text('rule')->comment('抽奖规则');
            $table->tinyInteger('status')->comment('状态')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
