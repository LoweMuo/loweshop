<?php


namespace App\Http\Controllers\Wx;


use App\CodeResponse;
use App\Http\Controllers\Controller;

class WxController extends Controller
{
    protected function returnMassage($codeResponse, $info = '', $data = null)
    {
        list($errno, $errmsg) = $codeResponse;
        $res = ['errno' => $errno, 'errmsg' => $info ?: $errmsg];
        if (!is_null($data)) {
            $res['data'] = $data;
        }
        return response()->json($res);
    }

    /**
     * 成功
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null)
    {
        return $this->returnMassage(CodeResponse::SUCCESS, '', $data);
    }

    /**
     * 失败
     * @param $codeResponse
     * @param  string  $info
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fail($codeResponse, $info = '')
    {
        return $this->returnMassage($codeResponse, $info);
    }

    /**
     * 参数不合法
     * @return mixed
     */
    protected function badParameter()
    {
        return $this->returnMassage(CodeResponse::BAD_PARAMETER);
    }

    /**
     * 参数值不正确
     * @return mixed
     */
    protected function badParameterValue()
    {
        return $this->returnMassage(CodeResponse::BAD_PARAMETER_VALUE);
    }

    /**
     * 请登录
     * @return mixed
     */
    protected function unlogin()
    {
        return $this->returnMassage(CodeResponse::UNLOGIN);
    }

    /**
     * 系统内部错误
     * @return mixed
     */
    protected function serious()
    {
        return $this->returnMassage(CodeResponse::SERIOUS);
    }

    /**
     * 业务不支持
     * @return mixed
     */
    protected function unsupport()
    {
        return $this->returnMassage(CodeResponse::UNSUPPORT);
    }

    /**
     * 更新数据已经失效
     * @return mixed
     */
    protected function updatedDateExpired()
    {
        return $this->returnMassage(CodeResponse::UPDATED_DATE_EXPIRED);
    }

    /**
     * 更新数据失败
     * @return mixed
     */
    protected function updatedDataFailed()
    {
        return $this->returnMassage(CodeResponse::UPDATED_DATA_FAILED);
    }

    /**
     * 无操作权限
     * @return mixed
     */
    protected function unauthz()
    {
        return $this->returnMassage(CodeResponse::UNAUTHZ);
    }
}
