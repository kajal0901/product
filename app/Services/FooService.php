<?php

namespace App\Services;

class FooService
{

    /**
     * FooService constructor.
     */
    public function __construct()
    {
        echo "Test FooServices";
    }

    /**
     * @return string
     */
    public function testService(): string
    {
        return "FooService Test Method";
    }

}