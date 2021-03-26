<?php

namespace Tests\Unit;


use App\CodeResponse;
use App\Exceptions\BusinessException;
use App\Models\User;
use App\Services\RedisModelServices;
use App\Services\UserServices;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * 单元测试
     * @return void
     */
    public function testCheckMobileSendCaptchaCount()
    {
        $mobile = '13711111111';
        foreach (range(0, 9) as $k) {
            $res = UserServices::getInstance()->checkMobileSendCaptchaCount($mobile);
            $this->assertTrue($res);

        }
        $res = UserServices::getInstance()->checkMobileSendCaptchaCount($mobile);
        $this->assertFalse($res);

    }

    public function testCheckCaptcha()
    {
        $mobile = '13711111111';

        $code = RedisModelServices::setSmsCode($mobile, UserServices::REGISTER_SMS_TYPE);
        $is_pass = UserServices::getInstance()->checkSmsCode($mobile, UserServices::REGISTER_SMS_TYPE, $code);
        $this->assertTrue($is_pass);

        $this->expectExceptionObject(new BusinessException(CodeResponse::AUTH_CAPTCHA_UNMATCH));
        UserServices::getInstance()->checkSmsCode($mobile, UserServices::REGISTER_SMS_TYPE, $code);

    }


}
