<?php

namespace Web\App\View;


class Template
{
    /**
     * @var string
     */
    private $patterns_path = '/web/App/View/patterns/';

    /**
     * @var array
     */
    private $patterns = [];

    public function __construct()
    {
        $this->set_patterns();
    }

    /**
     * @return array
     */
    public function set_patterns()
    {
        $scan = scandir(ROOT . $this->patterns_path);
        $files = [];
        foreach ($scan as $file) {
            if (preg_match('/^[\w\-\_\.]+\.php$/', $file)) {
                if (is_file(ROOT . $this->patterns_path . $file)) {
                    $files[] = $file;
                }
            }
        }

        foreach ($files as $file) {
            $temp = include ROOT . $this->patterns_path . $file;
            if (my_count($temp) > 0) {
                foreach ($temp as $item) {
                    $this->patterns[] = $item;
                }
            }
        }
    }

    public function get_cache() {

    }

    public function run($content)
    {
        foreach ($this->patterns as $item)
            $content = preg_replace($item['pattern'], $item['replace'], $content);

        return $content;
    }

}