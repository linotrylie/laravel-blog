<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2020/3/21
 * Time: 16:54
 */

namespace App\Constants;


class Constant
{
    const REDIS_USER = 'userid:%s:info';//用户登录key
    const REDIS_USER_TOKEN = 'userid:%s:token';//用户Token
    const USER_TOKEN_EXPIRED_TIME = 86400;//用户token过期时间
    const HOME_MENU_LIST_EXPIRED_TIME = 86400;//过期时间
    const HOME_MENU_LIST = 'home_menu_list';
}