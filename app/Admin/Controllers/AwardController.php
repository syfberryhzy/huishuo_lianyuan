<?php

namespace App\Admin\Controllers;

use App\Models\Award;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Activity;

class AwardController extends Controller
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

            $content->header('奖品');
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

            $content->header('奖品');
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

            $content->header('奖品');
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
        return Admin::grid(Award::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title', '奖品名称');
            $grid->activity_id('列表名称')->display(function ($activity_id) {
                  return Activity::find($activity_id)->title;
            });
            $grid->start_probability('开始概率');
            $grid->end_probability('结束概率');
            $grid->number('中奖个数');
            $grid->is_lottery('是否中奖')->display(function ($is_lottery) {
                return $is_lottery == 1 ? '中奖' : '未中奖';
            });
            $grid->image('分享图片')->display(function ($image) {
                return '<img src="' . config('admin.upload.host') . $image . '" style="width:60px;">';
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
            $filter->like('title', '奖品名称');
            $filter->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select('id')->from('activities')->where('title', 'like', "%{$this->input}%");
                });
            }, '列表名称');
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Award::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '奖品名称')->unique();
            $form->select('activity_id', '列表名称')->options(Activity::all()->pluck('title', 'id'));
            $form->number('start_probability', '开始概率')->rules('required|min:0')->help('比率：万分之一');
            $form->number('end_probability', '结束概率')->rules('required|min:0')->help('比率：万分之一<br/>说明:<br/>1.开始概率要小于结束概率<br/>2.概率只为1~10000任意值<br/>3.同一个列表名称下的概率区间不应重叠');
            $form->number('number', '中奖个数')->default(0)->rules('required|min:0')->help('活动每周的限制中奖个数');
            $form->select('is_lottery', '是否中奖')->options([0 => '未中奖', 1 => '中奖']);
            $form->text('header', '分享标题');
            $form->text('des', '分享文本');
	    $form->image('image', '分享图片')->help('最佳的尺寸不要超过300x300');
        });
    }
}
