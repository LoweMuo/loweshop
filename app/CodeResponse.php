<?php

namespace App;

class CodeResponse
{
    //系统错误
    const SUCCESS = [0, 'success'];
    const BAD_PARAMETER = [401, '参数不合法'];
    const BAD_PARAMETER_VALUE = [402, '参数值不正确'];
    const UNLOGIN = [501, '请登录'];
    const SERIOUS = [502, '系统内部错误'];
    const UNSUPPORT = [503, '系统内部错误'];
    const UPDATED_DATE_EXPIRED = [504, '更新数据已经失效'];
    const UPDATED_DATA_FAILED = [505, '更新数据失败'];
    const UNAUTHZ = [506, '无操作权限'];

    //业务错误
    const AUTH_INVALID_ACCOUNT = [700, 'aaaa'];
    const AUTH_CAPTCHA_UNSUPPORT = [701, '小程序后台验证码服务不支持'];
    const AUTH_CAPTCHA_FREQUENCY = [702, '验证码未超时1分钟，不能发送'];
    const AUTH_CAPTCHA_UNMATCH = [703, '验证码错误'];
    const AUTH_NAME_REGISTERED = [704, '用户名已注册'];
    const AUTH_MOBILE_REGISTERED = [705, '手机号已注册'];
    const AUTH_MOBILE_UNREGISTERED = [706, '快去注册吧'];
    const AUTH_INVALID_MOBILE = [707, '手机号格式不正确'];
    const AUTH_OPENID_UNACCESS = [708, 'openid 获取失败'];
    const AUTH_OPENID_BINDED = [709, 'openid已绑定账号'];

    const GOODS_UNSHELVE = [710, 'aaaa'];
    const GOODS_NO_STOCK = [711, 'aaaa'];
    const GOODS_UNKNOWN = [712, 'aaaa'];
    const GOODS_INVALID = [713, 'aaaa'];

    const ORDER_UNKNOWN = [720, 'aaaa'];
    const ORDER_INVALID = [721, 'aaaa'];
    const ORDER_CHECKOUT_FAIL = [722, 'aaaa'];
    const ORDER_CANCEL_FAIL = [723, 'aaaa'];
    const ORDER_PAY_FAIL = [724, 'aaaa'];

    const ORDER_INVALID_OPERATION = [725, 'aaaa'];
    const ORDER_COMMENTED = [726, 'aaaa'];
    const ORDER_COMMENT_EXPIRED = [727, 'aaaa'];

    const GROUPON_EXPIRED = [730, 'aaaa'];
    const GROUPON_OFFLINE = [731, 'aaaa'];
    const GROUPON_FULL = [732, 'aaaa'];
    const GROUPON_JOIN = [733, 'aaaa'];

    const COUPON_EXCEED_LIMIT = [740, 'aaaa'];
    const COUPON_RECEIVE_FAIL = [741, 'aaaa'];
    const COUPON_CODE_INVALID = [742, 'aaaa'];

    const AFTERSALE_UNALLOWED = [750, 'aaaa'];
    const AFTERSALE_INVALID_AMOUNT = [751, 'aaaa'];
    const AFTERSALE_INVALID_STATUS = [752, 'aaaa'];

}
