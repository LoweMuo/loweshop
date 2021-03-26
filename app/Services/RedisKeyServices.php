<?php


namespace App\Services;


class RedisKeyServices
{

    public static function smsCodeLock($mobile, $type)
    {
        return __FUNCTION__.':'.$type.'_'.$mobile;
    }

    public static function smsCode($mobile, $type)
    {
        return __FUNCTION__.':'.$type.'_'.$mobile;
    }
}
