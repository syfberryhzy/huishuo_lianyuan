<?php

namespace App\Admin\Controllers;

use App\Models\Answer;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Question;
use App\Models\User;
use App\Models\Test;
use App\Admin\Extensions\AnswerExporter;

class AnswerController extends Controller
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

            $content->header('记录');
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

            $content->header('记录');
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

            $content->header('记录');
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
        return Admin::grid(Answer::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user_id('用户名')->display(function ($user_id) {
                return User::find($user_id)->name;
            });
            $grid->test_id('题卷名')->display(function ($test_id) {
                return Test::find($test_id)->title;
            });
            $grid->answers('答题记录')->display(function ($answers) {
                $html = '';
                foreach (explode(',', $answers) as $key => $val) {
                    $fa = $val == 1 ? 'fa-check' : 'fa-times';
                    $html .= ($key+1).': <i class="fa '. $fa .'" aria-hidden="true"></i>&nbsp;&nbsp;';
                    if (($key+1) % 5 == 0) {
                        $html .= '<br/>';
                    }
                }
                return $html;
            });
            $grid->score('得分')->sortable();
            $grid->created_at('创建时间');
            $this->gridSearch($grid);
            $grid->disableCreation();
            $grid->exporter(new AnswerExporter());
            // $grid->disableActions();
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

            $filter->disableIdFilter();

            $filter->where(function ($query) {
                $query->where('id', '=', "{$this->input}")
                    ->orWhere('user_id', '=', "{$this->input}")
                    ->orWhere('test_id', '=', "{$this->input}");
            }, 'ID或用户ID或题卷ID');

            $filter->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select('id')->from('users')->where('name', 'like', "%{$this->input}%");
                });
            }, '用户名');

            $filter->where(function ($query) {
                $query->whereExists(function ($query) {
                    $query->select('id')->from('tests')->where('title', 'like', "%{$this->input}%");
                });
            }, '题卷标题');

            $filter->between('score', '得分');
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
        return Admin::form(Answer::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id', '')->options(User::all()->pluck('name', 'id'));
            $form->select('test_id', '')->options(Test::all()->pluck('title', 'id'));
            $form->number('score')->rules('required|digst|max:100|min:0')->help('分数0 ~ 100');
            $form->select('status', '状态')->options([0 => '隐藏', 1 => '显示']);
        });
    }
}
