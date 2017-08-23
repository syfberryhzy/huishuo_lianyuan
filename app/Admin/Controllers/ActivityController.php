<?php

namespace App\Admin\Controllers;

use App\Models\Activity;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ActivityController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('活动');
            $content->description('列表');

            $content->body($this->grid());
        });
    }


    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('活动');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('活动');
            $content->description('添加');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Activity::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title', '标题');
            $grid->start_time('起始时间')->display(function ($time) {
                return str_replace('00:00:00', '', $time);
            });
            $grid->end_time('终止时间')->display(function ($time) {
                return str_replace('00:00:00', '', $time);
            });
            $grid->getScore('通关分数')->sortable();
            $grid->activity_week('活动周期')->display(function ($weeks) {
                // return $weeks;
                $weekArr = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
                $newWeeks = [];
                foreach ($weeks as $key => $val) {
                    $newWeeks[] = $weekArr[$val];
                }
                return implode(' , ', $newWeeks);
            });
            $grid->created_at('创建时间');
            $grid->disableRowSelector();
            $grid->disableExport();
            $grid->disableBatchDeletion();
            $grid->actions(function ($actions) {
                  $actions->disableDelete();
            });
            $this->gridSearch($grid);
        });
    }
    /**
     * 查询过滤
     * @param  [type] $grid [description]
     * @return [type]       [description]
     */
    public function gridSearch($grid)
    {
        $grid->filter( function ($filter) {

            $filter->useModal();
            // 禁用id查询框
            // $filter->disableIdFilter();
            $filter->like('title', '标题');
            $filter->between('start_time', '起始时间')->datetime();
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Activity::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '列表标题')->unique();
            $form->dateRange('start_time', 'end_time', '有效时间');
            $form->number('getScore', '通关分数')->rules('required|min:0')->help('分数0 ~ 100');
            $weekArr = [0 => '星期日', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六'];
            $form->multipleSelect('activity_week', '活动周期')->options($weekArr);
            $form->image('image', '转盘图片');
            $form->textarea('rule', '列表规则')->rows(10);
            $form->select('status', '显示\隐藏')->options([0 => '隐藏', 1 => '显示'])->default(1);
        });
    }
}
