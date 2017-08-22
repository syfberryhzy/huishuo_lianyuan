<?php

namespace App\Admin\Controllers;

use App\Models\Test;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Question;

class TestController extends Controller
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

            $content->header('题卷');
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

            $content->header('题卷');
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

            $content->header('题卷');
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
        return Admin::grid(Test::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title', '题卷标题');
            $grid->question_ids('题目类')->display(function ($ids) {
                $questions = Question::select('id', 'question')->whereIn('id', $ids)->get()->toArray();
                $data = collect($questions)->keyBy('id');
                $list = '';
                foreach ($ids as $val) {
                    $list .= $val . ": " . $data[$val]['question'] . "<br/>";
                }
                return $list;
            });
            $grid->status('显示/隐藏')->display(function ($status) {
                return $status == 1 ? '显示': '隐藏';
            });
            $grid->created_at('创建时间');
            # 禁用导出数据按钮
            $grid->disableExport();
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

            $filter->like('title', '标题');
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Test::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title', '标题')->rules('required|min:2|max:20');
            $form->multipleSelect('question_ids', '选题')->options(Question::all()->pluck('question', 'id'))->help('多选');
            $form->select('status', '状态')->options([0 => '隐藏', 1 => '显示']);
        });
    }
}
