<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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

            $content->header('用户');
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

            $content->header('用户');
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

            $content->header('用户');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->openid('微信标识');
            $grid->phone('电话');
            $grid->email('邮箱');
            $grid->created_at('创建时间');
            # 禁用创建按钮
            $grid->disableCreation();
            # 禁用行操作列
            $grid->disableActions();
            # 禁用行选择checkbox
            $grid->disableRowSelector();
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

            # 禁用id查询框
            // $filter->disableIdFilter();
            $filter->like('name', '用户名');
            $filter->like('phone', '电话');
            $filter->like('email', '邮箱');
            $filter->between('created_at', '创建时间')->datetime();
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '用户名');
            $form->text('openid', '微信标识');
            $form->mobile('phone', '电话')->options(['mask' => '999 9999 9999']);
            $form->email('email', '邮箱');
        });
    }
}
