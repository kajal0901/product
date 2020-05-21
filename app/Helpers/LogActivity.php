<?php

namespace App\Helpers;

use App\LogActivity as LogActivityModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    /**
     * Method for log activity
     * @param string  $message
     * @param Request $request
     */
    public static function addToLog(string $message, Request $request)
    {
//        $log = [];
//        $log['subject'] = $message;
//        $log['url'] = $request->fullUrl();
//        $log['method'] = $request->method();
//        $log['ip'] = $request->ip();
//        $log['user_id'] = Auth::id();
//        LogActivityModel::create($log);
    }
}