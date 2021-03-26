<?php

namespace App\Services;

use App\CodeResponse;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Notifications\VerificationCode;
use Illuminate\Support\Facades\Notification;
use Leonis\Notifications\EasySms\Channels\EasySmsChannel;
use Overtrue\EasySms\PhoneNumber;


class UserServices extends BaseServices
{
    const REGISTER_SMS_TYPE = 1;
    const LOGIN_SMS_TYPE = 2;
    const RETRIEVE_PASSWORD_SMS_TYPE = 3;

    /**
     * 根据用户名返回用户信息
     * @param  type  $username
     * @return []
     */
    public function getByUsername($username)
    {
        return User::query()->where('username', $username)->where('deleted', 0)->first();
    }

    /**
     * 根据手机号返回用户信息
     * @param  type  $mobile
     * @return []
     */
    public function getByMobile($mobile)
    {
        return User::query()->where('mobile', $mobile)->where('deleted', 0)->first();
    }

    /**
     * 验证码 一天发送次数验证
     * @param  String  $mobile
     *
     */
    public function checkMobileSendCaptchaCount(string $mobile)
    {
        //todo 验证码 一天可发  10次   用redis   incr命令实现
        return true;
    }

    /**
     * 发送验手机证码
     * @param  string  $mobile
     * @param  string  $code
     */
    public function sendSmsCode(string $mobile, string $code)
    {
        if (app()->environment('testing')) {
            return;
        }
        Notification::route(
            EasySmsChannel::class,
            new PhoneNumber($mobile, $code)
        )->notify(new VerificationCode($code));
    }

    /**
     * 验证验证码是否正确
     * @param  string  $mobile
     * @param  string  $type  验证码类型  1注册  2登录  3找回密码
     * @param  string  $code
     * @return bool
     * @throws BusinessException
     */
    public function checkSmsCode(string $mobile, string $type, string $code)
    {
        $isPass = $code == RedisModelServices::getSmsCode($mobile, $type);
        if ($isPass) {
            RedisModelServices::delSmsCode($mobile, $type);
            return true;
        } else {
            throw new BusinessException(CodeResponse::AUTH_CAPTCHA_UNMATCH);//验证码错误
        }
    }


}
