<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use App\Models\User;
use App\Models\Test;

class AnswerExporter extends AbstractExporter
{
    public function export()
    {
        // $filename = $this->getTable().'.csv';
        $filename = '用户答题记录.csv';

        // 这里获取数据
        $data = $this->getData();
        $title_ZH = [0 => "ID", 1 => "用户编号:名", 2 => "题卷编号:标题", 3 => "答案(正确:T,错误:F)", 4 => "分数", 5 => "创建时间", 6 => "编辑时间"];
        if (!empty($data)) {
             $columns = array_dot($this->sanitize($data[0]));
             $titles = array_keys($columns);
        }
        $output = self::putcsv($title_ZH);
        foreach ($data as $row) {
             $row = array_only($row, $titles);
             $row['user_id'] = '(' . $row['user_id'] . ')' . User::find($row['user_id'])->name;
             $row['test_id'] = '(' . $row['test_id'] . ')' . Test::find($row['test_id'])->title;
             $html = '';
            foreach (explode(',', $row['answers']) as $key => $val) {
                $fa = $val == 1 ? 'T' : 'F';
                $html .= '(' . ($key+1).')'. $fa .' , ';
            }
             $row['answers'] =  $html;
             $output .= self::putcsv(array_dot($row));
        }

        // 在这里控制你想输出的格式,或者使用第三方库导出Excel文件
        $headers = [
            'Content-Encoding'    => 'UTF-8',
            'Content-Type'        => 'text/csv;charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        // 导出文件，
        response(rtrim($output, "\n"), 200, $headers)->send();

        exit;
    }

      /**
      * Remove indexed array.
      *
      * @param array $row
      *
      * @return array
      */
    protected function sanitize(array $row)
    {
        return collect($row)->reject(function ($val) {
            return is_array($val) && !Arr::isAssoc($val);
        })->toArray();
    }
     /**
      * @param $row
      * @param string $fd
      * @param string $quot
      * @return string
      */
    protected static function putcsv($row, $fd = ',', $quot = '"')
    {
        $str = '';
        foreach ($row as $cell) {
            $cell = str_replace([$quot, "\n"], [$quot . $quot, ''], $cell);
            if (strchr($cell, $fd) !== false || strchr($cell, $quot) !== false) {
                $str .= $quot . $cell . $quot . $fd;
            } else {
                $str .= $cell . $fd;
            }
        }
         return substr($str, 0, -1) . "\n";
    }
}

?>
