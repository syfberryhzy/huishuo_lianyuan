<?php

namespace App\Admin\Controllers;

use App\Models\Lottery;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\User;
use App\Models\Activity;
use App\Models\Award;
use App\Models\Answer;

class LotteryController extends Controller
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

            $content->header('抽奖');
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

            $content->header('抽奖');
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

            $content->header('抽奖');
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
        return Admin::grid(Lottery::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->answer_id('答题ID');
            $grid->user_id('用户名')->display(function ($user_id) {
                return User::find($user_id)->name;
            });
            $grid->activity_id('列表名')->display(function ($activity_id) {
                return Activity::find($activity_id)->title;
            });

            $grid->award_id('奖品名')->display(function ($award_id) {
                return Award::find($award_id)->title;
            });
            $grid->is_winning('是否中奖')->display(function ($is_winning) {
                return $is_winning == 1 ? '中奖' : '未中奖';
            });
            $grid->is_convert('是否兑奖')->display(function ($is_convert) {
                return $is_convert == 1 ? '已兑奖' : '未兑奖';
            });
            $grid->created_at('抽奖时间');
            $grid->disableRowSelector();
            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableBatchDeletion();
            $grid->disableActions();
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

            $filter->where(function ($query) {
                $query->where('title', 'like', "%{$this->input}%")
                    ->orWhere('content', 'like', "%{$this->input}%");
            }, 'Text');

            $filter->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select('id')->from('users')->where('name', 'like', "%{$this->input}%");
                });
            }, '用户名');
            $filter->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select('id')->from('activities')->where('title', 'like', "%{$this->input}%");
                });
            }, '列表名');
            $filter->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select('id')->from('awards')->where('title', 'like', "%{$this->input}%");
                });
            }, '奖品名');
            $filter->between('created_at', '抽奖时间')->datetime();
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Lottery::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id', '用户名')->options(User::all()->pluck('name', 'id'));
            $form->select('activity_id', '列表名')->options(Activity::all()->pluck('title', 'id'));
            $form->select('award_id', '奖品名')->options(Award::all()->pluck('title', 'id'));
            $form->radio('is_winning', '是否中奖')->options([0 => '未中奖', 1 => '已中奖']);
            $form->radio('is_convert', '是否兑奖')->options([0 => '未兑奖', 1 => '已兑奖']);
        });
    }
}
