<?php
header("Content-Type:text/html;charset=UTF-8");

include "config.php";
include "functions.php";

$db = connect_db();

/**
 * Всі таблиці з бази даних
 */
// $tables = get_tables($db);

/**
 * Ці таблиці являють собою статичні дані, а саме
 * всі населені пункти України та вулиці міст( поки що тільки Києва )
 */
/*$tables = [
    'located_area',             // Райони
    'located_countrys',         // Країни
    'located_region',           // Області
    'located_village',          // Села, СМТ, Міста
    'streets',                  // Вулиці
];*/

/**
 * Ці таблиці містять динамічні дані які часто оновлюються
 * і яким необхідний частий бекап
 */
$tables = [
    'categories',               // Категорії товарів
    'changes',                  // Зміни в замовленні
    'clients',                  // Постійні клієнти
    'clients_group',            // Групи постійних клієнтів
    'client_orders',            // Замовлення постійних клієнтів
    'colors',                   // Кольорові підказки
    'combine_product',          // Комбіновані товари
    'coupons',                  // Купони(диконтні картки)
    'curiers',                  // Курєри
    'defAttributes',            // Атрибути
    'groupe_manufacturers',     // Групи виробників
    'history_product',          // Історія товарів
    'logistics',                // Доставка
    'manufacturers',            // Виробники
    'orders',                   // Замовлення
    'pays',                     // Способи оплати
    'products',                 // Товари
    'product_to_order',         // Товари в замовленні
    'regions',                  // Регіони
    'storage',                  // Склади
    'users',                    // Користувачі(менеджери)
    'users_access',             // Ключі доступу користувача
    'users_access_all',         // Список всіх можливих ключів
    'variables',                // Перемінні
    'work_schedule_day',        // Звіт зробленої роботи за день
    'work_schedule_month',      // Звіт за місяць
];


$filename = get_dump($db,$tables);
if($filename !== false) {
    $to = EMAIL_TO; //Кому
    $from = EMAIL_FROM; //От кого
    $subject = "Backup " . date('d.m.Y'); //Тема
    $message = "Прийшов новий бекап!"; //Текст письма
    $boundary = "---"; //Разделитель
    /* Заголовки */
    $headers = "From: $from\nReply-To: $from\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
    $body = "--$boundary\n";
    /* Присоединяем текстовое сообщение */
    $body .= "Content-type: text/html; charset='utf-8'\n";
    $body .= "Content-Transfer-Encoding: quoted-printablenn";
    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
    $body .= $message."\n";
    $body .= "--$boundary\n";
    $file = fopen($filename, "r"); //Открываем файл
    $text = fread($file, filesize($filename)); //Считываем весь файл
    fclose($file); //Закрываем файл
    /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
    $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($filename)."?=\n";
    $body .= "Content-Transfer-Encoding: base64\n";
    $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
    $body .= chunk_split(base64_encode($text))."\n";
    $body .= "--".$boundary ."--\n";
    mail($to, $subject, $body, $headers); //Отправляем письмо
} else {
    echo 'error!!';
}
