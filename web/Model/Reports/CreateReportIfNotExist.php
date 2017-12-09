<?php

namespace Web\Model\Reports;

use RedBeanPHP\R;

trait CreateReportIfNotExist
{

    /**
     * Пошук звіту за минулмй місяць
     * Повертає суму на кінець місяця
     * @param $year
     * @param $month
     * @param $user
     * @return array
     */
    public function getOldReport($year, $month, $user)
    {
        $result = [];

        $sql = '`year` = ? AND `month` = ? AND `user` = ?';
        $binds = ['year' => $this->getYear($year, $month), 'month' => $this->getPrevMonth($month), $user];

        if (R::count('report_items', $sql, $binds)) {
            $bean = R::findOne('report_items', $sql, $binds);
            $result['just_now'] = $bean->just_now;
        } else {
            $result['just_now'] = 0;
        }

        return $result;
    }

    /**
     * @param $month
     * @return int - Попередній місяць
     */
    public function getPrevMonth($month)
    {
        if ($month == 1)
            return 12;
        else
            return $month - 1;
    }

    /**
     * @param $year
     * @param $month
     * @return int - Повертає рік
     */
    public function getYear($year, $month)
    {
        if ($month == 1)
            return $year - 1;
        else
            return $year;
    }

    /**
     * Пошук звіту в базі даних,
     * якщо звіт не знайдений а дата по які шукаємо співпадає з сьогоднішньою
     * то створюється новий звіт і він повертається як резутат роботи функції
     * інакше FALSE
     * @param $year
     * @param $month
     * @param $user
     * @return \RedBeanPHP\OODBBean|boolean
     */
    public function getReport($year, $month, $user)
    {
        $sql = '`year` = ? AND `month` = ? AND `user` = ?';
        $binds = [$year, $month, $user];

        if (!R::count('report_items', $sql, $binds)) {
            if (date('Ym') == $year . $month) {
               $this->createReportIfNotExists($user);
            } else {
                return false;
            }
        }

        return R::findOne('report_items', $sql, $binds);
    }

    /**
     * @param $user
     */
    public function createReportIfNotExists($user)
    {
        $bean = R::xdispense('report_items');
        $old = $this->getOldReport(date('Y'), date('m'), $user);
        $bean->just_now = 0;
        $bean->start_month = $old['just_now'];
        $bean->year = date('Y');
        $bean->month = date('m');
        $bean->user = $user;
        R::store($bean);
    }

    /**
     * @CRON_TASK
     * Створення Звіту для кожного користувача
     */
    public function createReportFromUsers()
    {
        $users = R::findAll('users');

        foreach ($users as $user) {
            $this->createReportIfNotExists($user->id);
        }

    }
}