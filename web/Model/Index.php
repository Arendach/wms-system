<?php

namespace Web\Model;

use Web\Model\Settings\BasicModel as Model;
use RedBeanPHP\R;

class Index extends Model
{
    public static function work_schedule()
    {
        $schedules = R::count('work_schedule_day', '`user` = ? AND MONTH(`date`) = ? AND YEAR(`date`) = ?', [
            user()->id,
            date('m'),
            date('Y'),
        ]);

        return date('d') - $schedules;
    }

    public static function work_schedules_month()
    {
        $year = date('m') == 1 ? date('Y') - 1 : date('Y');
        $month = date('m' == 1) ? 12 : date('m') - 1;

        $schedules = R::count('work_schedule_day', '`user` = ? AND MONTH(`date`) = ? AND YEAR(`date`) = ?', [
            user()->id,
            $month,
            $year
        ]);

        return [
            'work_schedules_month' => day_in_month($month, $year) - $schedules,
            'year' => $year,
            'month' => $month
        ];
    }
}