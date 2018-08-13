<?php
/** 扫描类.
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2018/6/21
 * Time: 14:32
 */

namespace app\admin\controller;

use think\Controller;
use app\Utils\wechat\Jssdk;
use app\Utils\request\HttpRequestUtil;

/** 货主扫描二维码收获
 * Class Scan
 * @package app\admin\controller
 */
class Scan extends Controller
{
    /** 扫描的界面调转.
     * @return mixed
     */
    public function scanEntry(){
        return $this->fetch("scan");
    }

    /** 获取jsapi_ticket用于生成签名
     * @return null
     */
    public function getJsapiTicket(){
        $url = trim(input('post.url'));
        $jssdk = new JSSDK("wx5982ab63d135e0a0", "5da2957a39acefeac14c98a0e20bd3d7");
        $signPackage = $jssdk->GetSignPackage($url);
        return exit(json_encode($signPackage));
    }

    /**
     * 获取扫描二维码查询出的货品信息.
     */
    public function getCodeData(){
        $pk =trim(input('post.pk'));
        $userCode =trim(input('post.userCode'));
        $request = new HttpRequestUtil();
        $post_data = array("pk"=>$pk,"userCode"=>$userCode);
        $result = $request->httpJsonPost(TMS_SERVER_URL . "order/getGoodsDetail",json_encode($post_data));
        return exit($result);
    }

    public function sign(){
        $pk =trim(input('post.pk'));
        $userCode =trim(input('post.userCode'));
        $request = new HttpRequestUtil();
        $post_data = array("pk"=>$pk,"userCode"=>$userCode);
        $result = $request->httpJsonPost(TMS_SERVER_URL . "order/signInv",json_encode($post_data));
        return exit($result);
    }

    /**
     * 发送评价功能.
     */
    public function sendRemark(){
        $pk =trim(input('post.pk'));
        $userCode =trim(input('post.userCode'));
        $remark = trim(input('post.remark'));
        $average = trim(input('post.average'));
        $request = new HttpRequestUtil();
        $post_data = array("pk"=>$pk,"userCode"=>$userCode,"scorereason"=>$remark,'average'=>$average);
        $result = $request->httpJsonPost(TMS_SERVER_URL . "order/clientAppraisal",json_encode($post_data));
        return exit($result);
    }

}