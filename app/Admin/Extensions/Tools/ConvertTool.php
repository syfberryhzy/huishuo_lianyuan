<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;
use Encore\Admin\Admin;

class ConvertTool extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }

    public function script()
    {
        return <<<EOT

        $('.grid-check-row').on('click', function () {

            console.log($(this).data('id'));
            var id = $(this).data('id');

            $.ajax({
                method: 'post',
                url: '/admin/game/circle/converts/release',
                data: {
                    _token:LA.token,
                    action: id
                },
                success: function (res) {
                    $.pjax.reload('#pjax-container');
                    toastr.success(res.message);
                }
            });

        });

EOT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return '<button type="button" class="btn btn-sm btn-success grid-check-row" data-id="'. $this->action .'"><i class="fa fa-plus"></i> 兑换 </button>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
