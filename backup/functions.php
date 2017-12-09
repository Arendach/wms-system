<?php
function connect_db()
{
    $db = mysqli_connect(HOST, USER, PASSWORD, DB);

    if (mysqli_connect_error($db))
        exit("Нет соединения с БД");


    mysqli_set_charset($db, "utf8");

    return $db;
}

function get_tables($db)
{

    $sql = "SHOW TABLES";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        exit(mysqli_error($db));
    }

    $tables = array();
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_row($result);
        $tables[] = $row[0];
    }

    return $tables;

}

function get_dump($db, $tables)
{

    if (is_array($tables)) {
        $filename = DIR_SQL . date('Y.m.d-H.i.s') . "_dump.sql";
        $fp = fopen($filename, "w");

        $text = "
-- SQL Dump
-- my_ version: 1.0
--
-- Дата ".date('d.m.Y H:i:s')."
--
-- База дынных: `" . DB . "`
--
-- ---------------------------------------------------
-- ---------------------------------------------------
";
        fwrite($fp, $text);

        foreach ($tables as $item) {
            $text = "
-- 
-- Структура таблицы - " . $item . "
--
";
            fwrite($fp, $text);


            $text = "";
            $text .= "DROP TABLE IF EXISTS `" . $item . "`;";

            $sql = "SHOW CREATE TABLE " . $item;
            $result = mysqli_query($db, $sql);
            if (!$result) {
                exit(mysqli_error($db));
            }
            $row = mysqli_fetch_row($result);

            $text .= "\n" . $row[1] . ";";
            fwrite($fp, $text);

            $text = "";
            $text .=
                "
--			
-- Dump BD - tables :" . $item . "
--
			";
            $text .= "\nINSERT INTO `" . $item . "` VALUES";
            fwrite($fp, $text);

            $sql2 = "SELECT * FROM `$item`";
            $result2 = mysqli_query($db, $sql2);
            if (!$result2) {
                exit(mysqli_error($db));
            }
            $text = "";

            $write = false;
            for ($i = 0; $i < mysqli_num_rows($result2); $i++) {
                $row = mysqli_fetch_row($result2);

                if ($i == 0) $text .= "(";
                else  $text .= ",(";

                foreach ($row as $v) {
                    $text .= "\"" . mysqli_real_escape_string($db, $v) . "\",";
                }
                $text = rtrim($text, ",");
                $text .= ")";

                if ($i > FOR_WRITE) {
                    fwrite($fp, $text);
                    $text = "";
                    $write = true;
                }

            }
            if($text == '' && $write === false)
                $text = '()';

            $text .= ";\n";
            fwrite($fp, $text);
        }
        fclose($fp);
    }
    return isset($filename) ? $filename : false;
}

?>