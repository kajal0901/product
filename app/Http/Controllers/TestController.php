<?php

namespace App\Http\Controllers;

use App\Services\FooService;

class TestController extends Controller
{

    public function index(FooService $customServiceInstance)
    {
        echo $customServiceInstance->testService();
    }

}
