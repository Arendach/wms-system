<?php

namespace Web\Model;

use Web\Model\Settings\BasicModel as Model;
use RedBeanPHP\R;

class WorkSchedule extends Model
{
    const table = 'work_schedule_day';

    public static function getAllUsersDistinct()
    {
        return R::getAll('
            SELECT DISTINCT 
                `work_schedule_month`.`user` AS `id`,
                `users`.`login`
            FROM 
                `work_schedule_month`
            LEFT JOIN `users` ON(`users`.`id` = `work_schedule_month`.`user`)
            WHERE 
                `work_schedule_month`.`year` = ?
            AND
                `work_schedule_month`.`month` = ?
            ',
            [
                get('year'),
                get('month')
            ]);
    }

    public static function getUserWorkSchedule()
    {
        $data = R::getRow('
            SELECT
                `work_schedule_month`.*,
                `users`.`login`,
                `users`.`id` AS `user_id`
            FROM 
                `work_schedule_month`
            LEFT JOIN `users` ON(`users`.`id` = :user_id)
            WHERE 
                `work_schedule_month`.`year` = :year_id
            AND
                `work_schedule_month`.`month` = :month_id
            AND 
                `work_schedule_month`.`user` = :user_id
            LIMIT 1
            ',
            [
                ':user_id' => get('user'),
                ':year_id' => get('year'),
                ':month_id' => get('month')
            ]);

        if (empty($data)) {
            $data = static::check_date();
        }

        $data['schedules'] = R::getAll('
            SELECT 
                *
            FROM 
                `work_schedule_day`
            WHERE
                `user` = ?
            AND
                MONTH(`date`) = ?
            AND
                YEAR(`date`) = ?
            ',
            [
                $data['user_id'],
                $data['month'],
                $data['year']
            ]);

        return ($data);
    }

    public static function check_date()
    {
        R::ext('xdispense', function ($type) {
            return R::getRedBean()->dispense($type);
        });

        $year = get('year');
        $start_year = date_parse(START_LIFE)['year'];
        $this_year = date('Y');

        $month = get('month');
        $start_month = date_parse(START_LIFE)['month'];
        $this_month = date('m');

        if ($year >= $start_year && $year <= $this_year && $month >= $start_month && $month <= $this_month) {
            $bean = R::xdispense('work_schedule_month');
            $bean->price_month = 3500;
            $bean->for_car = 0;
            $bean->bonuse = 0;
            $bean->user = user()->id;
            $bean->year = $year;
            $bean->month = $month;
            $bean->date = date('Y-m-d h:i:s');
            $bean->fine = 0;
            $bean->coefficient = 1;

            $result = $bean;

            R::store($bean);

            $result->login = user()->login;

            return $result;

        } else {
            redirect(route('404'));
        }
    }

    public static function get_day($user, $date)
    {
        return R::findOne('work_schedule_day', '`user` = ? AND `date` = ?', [$user, $date]);
    }

    public static function findMonth($data)
    {
        return R::findOne('work_schedule_month', '`user` = ? AND `month` = ? AND `year` = ?', [
            $data->user,
            $data->month,
            $data->year
        ]);
    }
}