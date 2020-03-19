<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2020/1/16
 * Time: 14:25
 */

if(!function_exists('success')) {
    function success($data = []) {
        $res = [
            'code' => 200,
            'message'  => config('httpcode.1'),
            'data' => $data,
        ];

        return response()->json($res, 1, [], JSON_UNESCAPED_UNICODE);
    }
}

if(!function_exists('error')) {
    function error($code, $message = null, $data = []) {
        $message = $message ?? config('httpcode.' . $code, '请求失败，请重试');
        $res     = [
            'code' => $code,
            'message'  => $message,
            'data' => $data,
        ];

        return response()->json($res, 0, [], JSON_UNESCAPED_UNICODE);
    }
}