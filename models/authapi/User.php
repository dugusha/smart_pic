<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017/3/20
 * Time: 09:42
 * Email:liyongsheng@meicai.cn
 */
namespace  app\models\authapi;

use app\components\ApiModel;
use app\components\ApiModelException;
use Yii;
use yii\httpclient\Response;

class User extends ApiModel
{
    public $baseUrl = AUTH_SERVER;


    public static $menuList = [
        [
            "index" => "2",
            "text"  => "工单创建",
            "icon"  => "el-icon-plus",
            "items" => [
                [
                    "index" => '/newTicket',
                    "text"  => "新建工单",
                ],
            ]
        ],
        [
            "index" => "1",
            "text"  => "工单处理",
            "icon"  => "el-icon-menu",
            "items" => [
                [
                    "index" => '/',
                    "text"  => "个人工单",
                    "activeMenus"   => ['myCreated','ticketInfo']
                ],
                [
                    "index" => '/teamTicket',
                    "text"  => "部门工单",
                ],
                [
                    "index" => '/overtimeTicket',
                    "text"  => "超时工单",
                ],
            ]
        ],
        [
            "index" => "3",
            "text"  => "工单分析",
            "icon"  => "fa fa-bar-chart mr10",
            "items" => [
                [
                    "index" => '/ticketAnalyze',
                    "text"  => "工单分析",
                ],
            ]
        ],
        [
            "index" => "4",
            "text"  => "配置设置",
            "icon"  => "el-icon-setting",
            "items" => [
                [
                    "index" => '/teamset',
                    "text"  => "团队设置",
                ],
                [
                    "index" => '/overtimeSet',
                    "text"  => "超时设置",
                ],
            ]
        ],
    ];

    /**
     * @param string $token
     * @return mixed
     */
    public function getUserInfo($token)
    {
        $request = $this->request;
        $respond = $request->setMethod('post')
            ->setUrl('user/tokeninfo')
            ->setOptions([['content-type' => 'application/json']])
            ->setData([
                'user_token' => $token,
            ])
            ->send();
        return $respond->getData();
    }
    /**
     * @param string $token
     * @param string $entry url
     * @param array $params
     * @return array|mixed
     * @throws ApiModelException
     */
    public function checkAccess($token, $entry, $params=[])
    {
        $request = $this->request;
        $respond = $request->setMethod('post')
            ->setUrl('adminuser/checkaccess')
            ->setOptions([['content-type' => 'application/json']])
            ->setData([
                'user_token' => $token,
                'entry' => $entry,
                'system_key' => Yii::$app->id,
                'params' => $params,
            ])
            ->send();
        return $respond->getData();
    }

    /**
     * @return array|mixed
     */
    public function cityList()
    {
        $request = $this->request;
        $respond = $request->setMethod('get')
            ->setUrl('city/list')
            ->setOptions([['content-type' => 'application/json']])
            ->send();
        return $respond->getData();
    }

    /**
     * @param $token
     * @return array|mixed
     */
    public function getUserAction($token)
    {
        $request = $this->request;
        $respond = $request->setMethod('post')
            ->setUrl('role/listaccessbytokenandkey')
            ->setOptions([['content-type' => 'application/json']])
            ->setData([
                'user_token' => $token,
                'system_key' => SYSTEM_KEY
            ])
            ->send();
        return $respond->getData();
    }

    /**
     * @param $allowUrl
     * @return array
     */
    public function menuList($allowUrl)
    {
        $menuList = self::$menuList;
        foreach ($menuList as $key => $val){
            foreach ($val["items"] as $k => $v){
                if(!in_array($v["index"],$allowUrl)) unset($menuList[$key]["items"][$k]);
            }
            if(empty($menuList[$key]["items"])) unset($menuList[$key]);
            else $menuList[$key]["items"] = array_values($menuList[$key]["items"]);
        }
        return array_values($menuList);
    }

}