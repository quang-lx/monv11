<?php

namespace Modules\Mon\Http\Controllers;


class WebController extends BaseController
{

    public function view($name, $data = [], $mergeData = [])
    {
        $namespace = 'base';
        return view("$namespace::$name", $data, $mergeData);
    }
}
