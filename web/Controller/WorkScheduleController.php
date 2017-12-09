<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 15.09.2017
 * Time: 17:21
 */

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\WorkSchedule;

class WorkScheduleController extends Controller
{
    /**
     * @GET
     */
    public function index()
    {
        if (get('year')) {
            if (get('month')) {
                if (get('user')) {
                    $this->user();
                } else {
                    $this->month();
                }
            } else {
                $this->year();
            }
        } elseif (get('show') == 'my') {
            $this->user_all();
        } else {
            $this->all();
        }
    }

    public function all()
    {
        $data = [
            'title' => 'Менеджери :: Звіти',
            'section' => 'Звіти',
            'components' => ['breadcrumbs']
        ];
        $this->view->display('/work_schedule/all', $data);
    }

    public function year()
    {
        $data = [
            'title' => 'Менеджери :: Звіти',
            'components' => ['breadcrumbs']
        ];
        $this->view->display('/work_schedule/year', $data);
    }

    public function month()
    {
        $data = [
            'title' => 'Менеджери :: Звіти',
            'components' => ['breadcrumbs'],
            'users' => get_object(WorkSchedule::getAllUsersDistinct())
        ];
        $this->view->display('/work_schedule/month', $data);
    }

    public function user()
    {
        if (user()->id != get('user') && !can()) {
            $this->display_403();
        }

        $items = get_object(WorkSchedule::getUserWorkSchedule());
        $new = [];
        $workday = 0;
        $day_off = 0;
        for ($i = 1; $i < day_in_month($items->month, $items->year) + 1; $i++) {
            $date = $items->year . '-' . $items->month . '-' . $i; // Дата Y-m-d

            /**
             * Вираховуємо кількість робочих і вихідних днів
             */
            if (date_to_day($date) == 'Субота' || date_to_day($date) == 'Неділя')
                $day_off++;
            else
                $workday++;

            /**
             * Заповнюємо масив, де ключ це - число, а значення це - масив даних з БД
             */
            foreach ($items->schedules as $item) {
                if (date_parse($item->date)['day'] == $i) {
                    $new[$i] = $item;
                    unset($item);
                }
            }
        }


        $over_full_days = 0; // Кількість пропрацьованих вихідних
        $over_full_hours = 0; // Кількість перепрацьованих годин
        $bonus_per_hour = 0; // бонус за перевиконання
        $bonus_per_day = 0; // бонус за перевиконання
        foreach ($new as $item) {
            // перевіряєм чи менеджер перевиконав норму в цей день
            $b = ($item->went_away - $item->dinner_break - $item->turn_up) - $item->work_day;
            if ($b > 0) {
                $over_full_hours += $b;
                // якщо було перевиконання, то доплюсовуємо бонус
                $bonus_per_hour += ($items->price_month / $workday / 8) * $b * $items->coefficient;
            }

            /**
             * Якщо вихідний то рахуємо бонус за роботу в вихідний
             */
            if ($item->type == false) {
                $c = ($item->went_away - $item->dinner_break - $item->turn_up);
                if ($c > 0) {
                    $over_full_days++;
                    $bonus_per_day += ($items->price_month / $workday) * $items->coefficient;
                }
            }
        }

        $bonus = round($bonus_per_day + $bonus_per_hour, 2);

        /**
         * Формула вирахування зарплати
         * Ставка за місяць + бонуси за додаткові дні + бонуси + бонуси за перевиконання годин - штрафи
         */
        $salary = $items->price_month + $items->for_car + $bonus - $items->fine;

        unset($items->schedules);

        $to_js = [
            'Data' => [
                'user' => $items->user,
                'year' => $items->year,
                'month' => $items->month,
            ]
        ];

        $data = [
            'title' => 'Менеджери :: Звіти',
            'data' => $items,
            'components' => ['breadcrumbs', 'modal', 'sweet_alert', 'jquery'],
            'scripts' => ['work_schedule/user.js'],
            'schedules' => $new,
            'to_js' => $to_js,
            'workday' => $workday,
            'day_off' => $day_off,
            'bonus' => $bonus,
            'salary' => $salary
        ];
        $this->view->display('/work_schedule/user', $data);
    }

    public function user_all()
    {
        $data = [
            'components' => ['breadcrumbs']
        ];

        $this->view->display('/work_schedule/my', $data);
    }

    public function get_form($post)
    {
        $object = new WorkScheduleController();
        if (method_exists($object, $post->form . '_form')) {
            $method_name = $post->form . '_form';
            $this->$method_name(get_object($post->data));
        }
    }

    public function update_day_form($post)
    {
        $date = $post->year . '-' . $post->month . '-' . $post->day;
        $day = WorkSchedule::get_day($post->user, $date);
        echo $this->view->render('/work_schedule/forms/update_day', $day);
    }

    public function create_day_form($post)
    {
        echo $this->view->render('/work_schedule/forms/create_day', ['day' => $post->day]);
    }

    public function edit_head_form($post)
    {
        $data = WorkSchedule::findMonth($post);
        echo $this->view->render('/work_schedule/forms/edit_head', ['data' => $data]);
    }

    /**
     * @POST
     */
    public function update($post)
    {
        $table = '';
        if ($post->data['type_update'] == 'day')
            $table = 'work_schedule_day';
        elseif ($post->data['type_update'] == 'head')
            $table = 'work_schedule_month';

        unset($post->data['type_update']);

        WorkSchedule::update($post->data, $post->id, $table);
    }

    public function create($post)
    {
        $date = $post->year . '-' . $post->month . '-' . $post->day;
        unset($post->year);
        unset($post->month);
        unset($post->day);
        unset($post->form);

        $post->date = $date;
        WorkSchedule::insert($post);
    }
}