<?php


namespace App\Services;


use Illuminate\Support\Facades\Cache;

class RedisModelServices
{

    /**
     * 验证码时间锁
     * @param $mobile
     * @param $type
     * @return bool
     */
    public static function smsCodeLock($mobile, $type)
    {
        return Cache::add(RedisKeyServices::smsCodeLock($mobile, $type), 1, 600);
    }

    /**
     * 将验证码保存缓存
     * @param $mobile
     * @param $type
     * @param $code
     * @return bool
     */
    public static function setSmsCode($mobile, $type)
    {
        $code = random_int(100000, 999999);
        Cache::put(RedisKeyServices::smsCode($mobile, $type), $code, 600);
        return $code;
    }

    /**
     * 获取缓存验证码
     * @param $mobile
     * @param $type
     * @return mixed
     */
    public static function getSmsCode($mobile, $type)
    {
        return Cache::get(RedisKeyServices::smsCode($mobile, $type));
    }

    /**
     * 删除验证码
     * @param $mobile
     * @param $type
     * @return bool
     */
    public static function delSmsCode($mobile, $type)
    {
        return Cache::forget(RedisKeyServices::smsCode($mobile, $type));
    }

}
