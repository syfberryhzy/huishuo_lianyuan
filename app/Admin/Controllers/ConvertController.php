<?php

namespace App\Admin\Controllers;

use App\Models\Convert;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\User;
use App\Models\Lottery;
use App\Admin\Extensions\Tools\ConvertTool;
use Illuminate\Http\Request;

class ConvertController extends Controller
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

            $content->header('兑奖');
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

            $content->header('兑奖');
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

            $content->header('兑奖');
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
        return Admin::grid(Convert::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->user_id('用户名')->display(function ($user_id) {
                return User::find($user_id)->name;
            });
            $grid->lottery_id('抽奖编号');
            $grid->username('兑奖姓名');
            $grid->phone('兑奖号码');
            $grid->status('处理状态')->display(function ($status) {
                return $status == 1 ? '已处理' : '待处理';
            });
            $grid->created_at('申请时间');
            $grid->disableRowSelector();
            $grid->disableCreation();
            //$grid->disableExport();
            $grid->disableBatchDeletion();
            // $grid->actions();
            $grid->actions(function ($actions) {
               #隐藏编辑按钮
                $actions->disableEdit();
               #隐藏删除按钮
                $actions->disableDelete();
                if ($actions->row->status == 0) {
                    $actions->append(new ConvertTool($actions->getKey()));
                } else {
                    $actions->append('暂无操作');
                }
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
            $filter->like('lottery_id', '抽奖编号');
            $filter->like('username', '兑奖姓名');
            $filter->like('phone', '兑奖号码');
            $filter->between('created_at', '申请时间')->datetime();
        });
    }

    public function release(Request $request)
    {
        $info = Convert::find($request->action);
        $lottery = Lottery::find($info->lottery_id);
        if ($info->status == 0) {
            $lottery->is_convert = 1;
            $info->status = 1;
            $lottery->save();
            $info->save();
            return response()->json(['message' => '兑换成功', 'status' => 1], 201);
        }
        return response()->json(['message' => '系统有误', 'status' => 0], 400);
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Convert::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id', '用户名')->options(User::all()->pluck('name', 'id'));
            $form->select('lottery_id', '抽奖编号')->options(Lottery::all()->pluck('id', 'id'));
            $form->text('username', '兑奖姓名');
            $form->mobile('phone', '兑奖号码')->options(['mask' => '999 9999 9999']);
            $form->select('status', '处理状态')->options([ 0 => '待处理', 1 => '已处理']);
        });
    }
}
