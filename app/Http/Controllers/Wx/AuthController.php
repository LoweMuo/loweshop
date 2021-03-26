<?php

namespace App\Http\Controllers\Wx;

use App\CodeResponse;
use App\Models\User;
use App\Services\RedisModelServices;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends WxController
{

    /**
     * 注册
     * @param  Request  $request
     * @return array|\Illuminate\Http\JsonResponse|mixed
     * @throws \App\Exceptions\BusinessException
     */
    public function register(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $mobile = $request->input('mobile');
        $code = $request->input('code');
        $wxCode = $request->input('wxCode');

        if (empty($username) || empty($password) || empty($mobile) || empty($code)) {
            return $this->badParameter();//参数不合法
        }
        $user_info = UserServices::getInstance()->getByUsername($username);
        if (!is_null($user_info)) {
            return $this->fail(CodeResponse::AUTH_NAME_REGISTERED);//用户名已注册
        }
        $validator = Validator::make([
            'mobile' => $mobile
        ], [
            'mobile' => [
                'required',
                'regex:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/'
            ]
        ]);
        if ($validator->fails()) {
            return $this->fail(CodeResponse::AUTH_INVALID_MOBILE);//手机号格式不正确
        }
        $user_info = UserServices::getInstance()->getByMobile($mobile);
        if (!is_null($user_info)) {
            return $this->fail(CodeResponse::AUTH_MOBILE_REGISTERED);//手机号已被注册
        }
        //验证验证码是否正确
        UserServices::getInstance()->checkSmsCode($mobile, $userServices::REGISTER_SMS_TYPE, $code);

        $user_model = new User();
        $user_model->username = $username;
        $user_model->password = md5($password);
        $user_model->mobile = $mobile;
        $user_model->avatar = 'https://yanxuan.nosdn.127.net/80841d741d7fa3073e0ae27bf487339f.jpg?imageView&quality=90&thumbnail=64x64';
        $user_model->nickname = $username;
        $user_model->last_login_time = \Carbon\Carbon::now()->toDateString();
        $user_model->last_login_ip = $request->getClientIp();
        $user_model->save();

        $return_data = [
            'token' => '',
            'userInfo' => [
                'nickName' => $username,
                'avatarUrl' => $user_model->avatar,
            ]
        ];
        return $this->success($return_data);
    }

    /**
     *发送验证码接口
     * @param  Request  $request
     * @param  string  mobile 手机号
     * @param  int  type   类型   1注册  2登录  3找回密码
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function captcha(Request $request)
    {

        $mobile = $request->input('mobile');
        $type = $request->input('type');

        if (empty($mobile) || empty($type)) {
            return $this->badParameter();//参数不合法
        }
        $validator = Validator::make([
            'mobile' => $mobile
        ], [
            'mobile' => [
                'required',
                'regex:/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/'
            ]
        ]);
        if ($validator->fails()) {
            return $this->fail(CodeResponse::AUTH_INVALID_MOBILE);//手机号格式不正确
        }

        //查找用户是否已经注册
        $user_info = UserServices::getInstance()->getByMobile($mobile);
        if ($type == UserServices::REGISTER_SMS_TYPE) {
            if (!is_null($user_info)) {
                return $this->fail(CodeResponse::AUTH_MOBILE_REGISTERED);//手机号已被注册
            }
        } elseif ($type == UserServices::RETRIEVE_PASSWORD_SMS_TYPE) {
            if (is_null($user_info)) {
                return $this->fail(CodeResponse::AUTH_MOBILE_UNREGISTERED);//先去注册吧
            }
        }

        //验证是否过期
        if (!RedisModelServices::smsCodeLock($mobile, $type)) {
            return $this->fail(CodeResponse::AUTH_CAPTCHA_FREQUENCY);//验证码未超时1分钟，不能发送
        }
        //todo 验证码 一天可发  10次   用redis   incr命令实现
        //(new UserServices)->checkMobileSendCaptchaCount();

        //保存验证码到缓存
        $code = RedisModelServices::setSmsCode($mobile, $type);
        //发送验证码
        UserServices::getInstance()->sendSmsCode($mobile, $code);
        return $this->success();
    }

}
