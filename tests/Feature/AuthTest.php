<?php

namespace Tests\Feature;

use App\CodeResponse;
use App\Services\RedisModelServices;
use App\Services\UserServices;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRegister()
    {
        $mobile='13711111111';

        $code = RedisModelServices::setSmsCode($mobile, UserServices::REGISTER_SMS_TYPE);
        $response = $this->post('wx/auth/register',
            [
                'username' => 'lowemuo22',
                'password' => '123',
                'mobile' => $mobile,
                'code' => $code
            ]
        );
        $response->assertJson([
            'errno'=>0,
            'errmsg'=>'success'
        ]);
    }

    public function testCaptcha()
    {
        $response = $this->post('wx/auth/captcha',
            [
                'mobile' => '13711111111',
                'type' => 1
            ]
        );
//        echo $response->getContent();
        $response->assertJson([
            'errno'=>0,
            'errmsg'=>'success'
        ]);
    }
}
