<?php
namespace app\controllers;

use app\adapter\AdAdapter;
use app\components\Controller;
use app\components\Util;
use yii\base\Exception;

/**
 *
 * 用户信息
 * Class UserController
 * @package app\controllers
 */
class SmartPicController extends Controller
{
    public function actionGetFrame()
    {
        $ret = AdAdapter::getInstance()->getFrame();
        return $ret;
    }

    /**
     * 智能图片保存
     * @return mixed
     */
    public function actionSave(){
        $param = Util::getRequestData();
        Util::checkEmpty($param,[
//            "img_url",
            "element",
        ]);

//        if(isset($params['img']) && !empty($params['img'])){
//            $base64 = $params['img'];
//            $dirPath = dirname(__FILE__)  . '/../common';
//            $user = $this->user;
//            $ret =  ImgService::getInstance()->uploadStringToImgToOss($base64 , $dirPath , $user);
//
//            if(!empty($ret) && isset($ret['success'][0]) && isset($ret['success'][0]['img_server']) && isset($ret['success'][0]['path'])){
//                $param["img_url"] =  IMG_D_SERVER.'/' . $ret['success'][0]['path'];
//            }
//        }

        $param["operator_id"] = 1;
        $param["operator_name"] = "sp";
        return AdAdapter::getInstance()->smartPicSave($param);
    }

    /**
     * 智能图片获取
     * @return mixed
     */
    public function actionGetById(){
        $param = Util::getRequestData();
        Util::checkEmpty($param,[
            "id",
        ]);
        $param["with_element"] = 1;
        $ret = AdAdapter::getInstance()->smartPicGetById($param);
        $ret["element"] = $ret["element"];
        return $ret;
    }

}