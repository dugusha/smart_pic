<?php
namespace app\controllers;

use app\adapter\AdAdapter;
use app\components\Controller;
use app\components\Util;
use app\models\authapi\User;
use Yii;

class ShowController extends Controller
{
    /**
     * 根据智能图片ids获取智能图片元素
     * @return array
     */
    public function actionDraw()
    {
        $ttf = \Yii::$app->basePath."/components/TrueType/simkai.ttf";
        $url = "https://img-oss.yunshanmeicai.com/goods/default/40,05ecaedc135807";
        //生成真彩图
        $img = imagecreatetruecolor(400, 200);
        //设置透明背景
        $color=imagecolorallocate($img,255,255,255);
        imagecolortransparent($img,$color);
        imagefill($img,0,0,$color);
        //加载源图片
        $srcImage=imagecreatefromjpeg($url);
        //这里我们可以使用一个getimagesize()
        $srcImageInfo=getimagesize($url);
        $imageWidth=$srcImageInfo[0];
        $imageHeight=$srcImageInfo[1];

        //拷贝源图片到目标画布
        imagecopyresized($img,$srcImage,100,20,0,0,300,300,$imageWidth,$imageHeight);
        //4.向画布上写字
        $textcolor=imagecolorallocate($img,0,0,0);
        imagettftext($img, 50, 0, 10, 100, $textcolor, $ttf, "测试");
        //5.保存
//        imagepng($img,$url);
        //3.输出图像到网页，也可以另存
        header("content-type:image/png");
        imagepng($img);
        //6.释放
        imagedestroy($img);
        exit;
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
        $element = [];
        foreach ($ret["element"] as $item){
            if($item["source_id"]!=0){
                if($item["source_type"]==1) $item["source_local_value"] = "￥".rand(1,100).".".rand(10,99);
                else $item["source_local_value"] = 'https://img-oss.yunshanmeicai.com/goods/default/37,0bc5ea1d8e5904';
            }
            $element[] = $item;
        }
//        p($element);
        self::draw($ret["width"],$ret["height"],$element);
    }

    protected function draw($width,$height,$element){
        Util::myArraySort($element,"z");
        $ttf = \Yii::$app->basePath."/components/TrueType/simkai.ttf";
        //生成真彩图
        $img = imagecreatetruecolor($width, $height);
        //设置透明背景
        $color=imagecolorallocate($img,999,999,999);
        imagecolortransparent($img,$color);
        imagefill($img,0,0,$color);


        foreach ($element as $item){
            $x = $item["x"];
            $y = $item["y"];
            if ($item["source_type"]==1){
                $item["color"] = self::hex2rgb($item["color"]);
                $fontSize = $item["size"]*3/4;//像素字体
                $fontColor = imagecolorallocate ( $img, $item["color"]["r"], $item["color"]["g"], $item["color"]["b"] );//字的RGB颜色
                $fontBox = imagettfbbox($fontSize, 0, $ttf, $item["source_local_value"]);//文字水平居中实质
                if ($item["align"]=="center") $x = $item["x"] + $item["width"]/2 - $fontBox[2]/2;
                elseif ($item["align"]=="right") $x = $item["x"] + $item["width"] - $fontBox[2];
                $y = $item["y"]+($item["height"]+$fontSize)/2;
                imagettftext ( $img, $fontSize, 0, $x, $y, $fontColor, $ttf, $item["source_local_value"] );
                for ($i = 0;$i<$item["bold"];$i++) imagettftext ( $img, $fontSize, 0, $x, $y, $fontColor, $ttf, $item["source_local_value"] );
            }else{
                $srcImage = "";
                try{
                    $srcImage=imagecreatefromjpeg($item["source_local_value"]);
                }catch (\Exception $e){}
                try{
                    $srcImage=imagecreatefrompng($item["source_local_value"]);
                }catch (\Exception $e){}

                if(empty($srcImage)) continue;

                //这里我们可以使用一个getimagesize()
                $srcImageInfo=getimagesize($item["source_local_value"]);
                $imageWidth=$srcImageInfo[0];
                $imageHeight=$srcImageInfo[1];

                //拷贝源图片到目标画布
                imagecopyresized($img,$srcImage, $x, $y,0,0,$item["width"],$item["height"],$imageWidth,$imageHeight);

            }
        }
//        //加载源图片
//        $srcImage=imagecreatefromjpeg($url);
//        //这里我们可以使用一个getimagesize()
//        $srcImageInfo=getimagesize($url);
//        $imageWidth=$srcImageInfo[0];
//        $imageHeight=$srcImageInfo[1];
//
//        //拷贝源图片到目标画布
//        imagecopyresized($img,$srcImage,100,20,0,0,300,300,$imageWidth,$imageHeight);
        //5.保存
//        imagepng($img,$url);
        //3.输出图像到网页，也可以另存
        header("content-type:image/png");
        imagepng($img);
        //6.释放
        imagedestroy($img);
        exit;
    }

    function hex2rgb($hexColor) {
        $color = str_replace('#', '', $hexColor);
        if (strlen($color) > 3) {
            $rgb = array(
                'r' => hexdec(substr($color, 0, 2)),
                'g' => hexdec(substr($color, 2, 2)),
                'b' => hexdec(substr($color, 4, 2))
            );
        } else {
            $color = $hexColor;
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $rgb = array(
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }

}