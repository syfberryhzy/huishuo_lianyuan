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
            $grid->options('选项')->display(function ($options) {
                return str_replace(';', '<br/>', $options);
            });
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
                  ->rules('required|max:30')->help('题目字数长度建议为11,超出可能影响前端展示');

            $form->textarea('options', '选项')
                  ->default("A.---; \r\nB.--; \r\nC.---; \r\nD.---;")
                  ->help("<br/>1. 请将各选项中的---替换成选项文本，保持样式不变;<br/>2.添加更多选项时，样式请参照已有选项。若少于四个选项请删除多余项<br/>3. 每个选项字数长度建议为9， 超出影响前端页面展示");

            $form->text('corrent', '答案')->rules('required|max:1')->help('请输入A/B/C/D')
                  ->help('每个选项字数长度建议为9,超出影响前端页面展示');

            $form->select('status', '状态')
                  ->options([
                    0 => '隐藏',
                    1 => '显示'
                  ]);
        });
    }
}
