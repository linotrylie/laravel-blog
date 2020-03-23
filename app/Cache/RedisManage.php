<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2020/3/21
 * Time: 16:23
 */

namespace App\Cache;


use Illuminate\Support\Facades\Redis;
use Log;

class RedisManage
{
    public function set($key,$value,$expiredTime = null)
    {
        try{
            Redis::set($key,$value);
            if(!is_null($expiredTime)){
                Redis::expire($key,$expiredTime);
            }
        }catch (\Exception $e){
            Log::error("Redis set {$key}-{$value} failed!");
            return false;
        }
        return true;
    }

    public function get($key)
    {
        try{
            $val = Redis::get($key);
        }catch (\Exception $e){
            Log::error("Redis get {$key} failed!");
            return false;
        }
        return $val;
    }
}