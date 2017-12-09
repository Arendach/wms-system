<?php

namespace Web\Controller;

use Web\App\Controller;
use Web\Model\Api\NewPost;

class TestController extends Controller
{
    public function index()
    {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
        </head>
        <body>

        <script src="/web/template/default/js/URLs.js"></script>
        <script>
            GET.set('qwerty', '1223').query);
        </script>
        </body>
        </html>
        <?php
    }

}