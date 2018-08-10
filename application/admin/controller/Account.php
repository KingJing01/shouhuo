<?php

namespace app\admin\controller;

use  think\Controller;
use  app\Utils\request\HttpRequestUtil;

/**
 * 账户登陆的控制器.
 */
class Account extends Controller
{
    public function login()
    {
        //返回模板名  view.Account下的login.html
        return $this->fetch("login");
    }

    //用户登录
    public function dologin()
    {

        $username = trim(input('post.username'));

        $pwd = trim(input('post.pwd'));

        if (!$username) {
            exit(json_encode(array('code' => 1, 'msg' => '用户名不能为空')));
        }

        if (!$pwd) {
            exit(json_encode(array('code' => 1, 'msg' => '验证码不能为空')));
        }
        //发送请求获取数据
        $arr = array("userCode" => $username, "checkCode" => $pwd);
        $request = new HttpRequestUtil();
        $res = $request->httpJsonPost(TMS_SERVER_URL . 'weChatLogin', json_encode($arr));
        return exit($res);
    }

    //给手机发送验证码
    public function getVertication(){
        $username = trim(input('post.username'));
        if (!$username) {
            exit(json_encode(array('code' => 1, 'msg' => '用户名不能为空')));
        }
        $arr = array("userPhone" => $username);
        $request = new HttpRequestUtil();
        $res = $request->httpJsonPost(TMS_SERVER_URL . 'sendVerification', json_encode($arr));
        return exit($res);
        }

}


?>