<?php
namespace App\Admin\Controllers;

use App\Models\Question;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class QuestionController extends Controller
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

            $content->header('题库');
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

            $content->header('题库');
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

            $content->header('题库');
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
        return Admin::grid(Question::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->question('题目');
            $grid->options('选项');
            $grid->corrent('正确选项');
            $grid->status('显示/隐藏')->display(function ($status) {
                return $status == 1 ? '显示': '隐藏';
            });
            $grid->created_at('创建时间');
            $this->gridSearch($grid);
        });
    }

    public function gridSearch($grid)
    {
        $grid->filter( function ($filter) {

            $filter->useModal();

            $filter->where(function ($query) {
                $query->where('question', 'like', "%{$this->input}%")
                    ->orWhere('options', 'like', "%{$this->input}%");
            }, '题目或选项');
        });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Question::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('question', '题目')
                  ->rules('required|max:30');

            $form->textarea('options', '选项')
                  ->default("A. \r\nB. \r\nC. \r\nD. ")
                  ->help('选项内容请在A.B.C.D.后面填充');

            $form->text('corrent', '答案')->rules('required|max:1')->help('请输入A/B/C/D');

            $form->select('status', '状态')
                  ->options([
                    0 => '隐藏',
                    1 => '显示'
                  ]);
        });
    }
}
