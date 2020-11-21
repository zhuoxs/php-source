<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2019/3/12 0012
 * Time: 上午 9:28
 */
defined("IN_IA") or exit("Access Denied");
class Qrcode_KundianFarmModel{
    public function createPost($goodsData,$filename=""){
        global $_W;
        $file_bg = $_W['siteroot'].'/addons/kundian_farm/resource/image/bg.png';
        // font type
        ini_set("gd.jpeg_ignore_warning", 1);
        $font_simhei = str_replace('\\','/',realpath(dirname(__FILE__).'/')).'/simhei.ttf';
        $img_bg = imagecreatefrompng($file_bg);//背景
        $img_code = @imagecreatefromjpeg($goodsData['user_qrcode']);//二维码
        $image_size=getimagesize($goodsData['cover']);
        $img_type=explode('/',$image_size['mime']);
        if($img_type[1]=='png'){
            $img_cover =imagecreatefrompng($goodsData['cover']); //商品图片
        }else{
            $img_cover=imagecreatefromjpeg($goodsData['cover']);
        }
        //获取背景图片的宽度和高度
        $width = imagesx($img_bg);
        $height = imagesy($img_bg);

        //创建一张与背景图同样大小的真彩色图像
        $im = imagecreatetruecolor($width, $height);
        imagecopy($im, $img_bg, 0, 0, 0, 0, $width, $height);

        //商品封面
        $width_cover = imagesx($img_cover);
        $height_cover = imagesy($img_cover);

        /** 加载商品封面图片时的重要步骤，使用imagecopyresampled 先对封面图片进行缩放（直接使用imagecopymerge 不能讲图片进行放大处理） */
        //建立画板 ，缩放图片至指定尺寸
        $canvas=imagecreatetruecolor(740, 740);
        $color = imagecolorallocate($im, 0, 0, 0);
        imagefill($canvas, 0, 0, $color);
        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($canvas, $img_cover, 0, 0, 0, 0, 740, 740,$width_cover,$height_cover);

        imagecopymerge($im, $canvas, 30, 30, 0, 0, 740, 740, 100);

        $color_red = ImageColorAllocate($im, 255, 70, 70);
        $color_black=ImageColorAllocate($im,54,54,54);
        $color_gray=ImageColorAllocate($im,181,181,181);
        $color_line=ImageColorAllocate($im,207,207,207);

        $test_r = '30';//文本右偏移
        $text=$goodsData['goods_name'];
        //商品名称渲染
        $goods_name=str_split($text,66);
        if(count($goods_name)>=2 ){
            $goods_name[0]=$goods_name[0].'...';
        }
        imagettftext($im, 23, 0, $test_r, 820, $color_black, $font_simhei, $goods_name[0]);

        //商品价格，销量渲染
        $price='￥'.$goodsData['price'];
        imagettftext($im, 40, 0, $test_r, 900, $color_red, $font_simhei, $price);

        $price_font=imagettfbbox(40,0,$font_simhei,$price);
        $old_x=$price_font[2]+50;
        imagettftext($im, 20, 0, $old_x, 900, $color_gray, $font_simhei, '￥'.$goodsData['old_price']);

        $old_font=imagettfbbox(20,0,$font_simhei,'￥'.$goodsData['old_price']);

        imageline($im,$old_x,890,$old_font[2]+$old_x,890,$color_gray);


        $sale_count='已售'.$goodsData['sale_count'].'件';
        $font_box=imagettfbbox(23,0,$font_simhei,$sale_count);
        $x=$width-($font_box[2]-$font_box[0]);
        imagettftext($im, 23, 0, $x-30, 900, $color_gray, $font_simhei, $sale_count);
        imageline($im,30,1000,$width-30,1000,$color_line);

        //小程序名称渲染
        $model_name=$_W['account']['name'];
        imagettftext($im, 20, 0, $test_r, 1240, $color_gray, $font_simhei, $model_name);
        $model_tag='长按识别小程序码';
        imagettftext($im, 23, 0, $test_r, 1190, $color_black, $font_simhei, $model_tag);

        //加载二维码图片
        $width_code = imagesx($img_code);
        $height_code = imagesy($img_code);

        $q_canvas=imagecreatetruecolor(300, 300);
        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($q_canvas, $img_code, 0, 0, 0, 0, 300, 300,$width_code,$height_code);
        imagefill($q_canvas, 0, 0, $color);
        imagecopymerge($im, $q_canvas, $width-350, $height-370, 0, 0, 300, 300, 100);

        //生成图片
        if(!empty($filename)){
            $res = imagejpeg ($im,$filename,90); //保存到本地
            imagedestroy($im);
            if(!$res) return false;
            return $filename;
        }else{
            header('Content-Type: image/png');
            //最后处理 输出、销毁
            Imagepng($im);
            ImageDestroy($img_code);
            ImageDestroy($img_bg);
            ImageDestroy($im);
        }
    }

    //分销中心生成分享海报
    public function createSharePoster($user=[],$filename=""){
        global $_W;
        $file_bg = $_W['siteroot'].'/addons/kundian_farm/resource/image/sharebg-1.png';

        ini_set("gd.jpeg_ignore_warning", 1);
        $font_simhei = str_replace('\\','/',realpath(dirname(__FILE__).'/')).'/simhei.ttf';
        $img_bg = imagecreatefrompng($file_bg);//背景
        $img_code = @imagecreatefromjpeg($user['user_qrcode']);//二维码

        //获取背景图片的宽度和高度
        $width = imagesx($img_bg);
        $height = imagesy($img_bg);

        //创建一张与背景图同样大小的真彩色图像
        $im = imagecreatetruecolor($width, $height);
        imagecopy($im, $img_bg, 0, 0, 0, 0, $width, $height);

        //建立画板 ，缩放图片至指定尺寸
        $canvas=imagecreatetruecolor(132, 132);
        $color = imagecolorallocate($im, 0, 0, 0);
        imagefill($canvas, 0, 0, $color);
        $imgg= $this->yuan_img($user['cover']);//将用户头像转化为原型头像

        //用户头像大小
        $width_cover = imagesx($imgg);
        $height_cover = imagesy($imgg);

        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($canvas, $imgg, 0, 0, 0, 0, 132, 132,$width_cover,$height_cover);

        imagecopymerge($im, $canvas, 256, 570, 0, 0, 132, 132, 100);

        $color_black=ImageColorAllocate($im,54,54,54);
        $color_gray=ImageColorAllocate($im,99,99,99);

        //用户没名称、提示语
        $model_name=$user['nickname'];
        $fontBox = imagettfbbox(20, 0, $font_simhei, $model_name);//文字水平居中实质
        imagettftext ( $im, 20, 0, ceil(($width - $fontBox[2]) / 2), 750, $color_black, $font_simhei, $model_name );

        $model_tag='扫码一起成为分销商';
        $fontBox1 = imagettfbbox(20, 0, $font_simhei, $model_tag);//文字水平居中实质
        imagettftext ( $im, 20, 0, ceil(($width - $fontBox1[2]) / 2), 820, $color_gray, $font_simhei, $model_tag );

        //加载二维码图片
        $width_code = imagesx($img_code);
        $height_code = imagesy($img_code);

        $q_canvas=imagecreatetruecolor(300, 300);
        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($q_canvas, $img_code, 0, 0, 0, 0, 300, 300,$width_code,$height_code);
        imagefill($q_canvas, 0, 0, $color);
        imagecopymerge($im, $q_canvas, 175, 160, 0, 0, 300, 300, 100);

        //生成图片
        if(!empty($filename)){
            $res = imagejpeg ($im,$filename,90); //保存到本地
            imagedestroy($im);
            if(!$res) return false;
            return $filename;
        }else{
            header('Content-Type: image/png');
            //最后处理 输出、销毁
            Imagepng($im);
            ImageDestroy($img_code);
            ImageDestroy($img_bg);
            ImageDestroy($im);
        }
    }

    public function createStorePoster($user=[],$filename=""){
        global $_W;
        $file_bg = $_W['siteroot'].'/addons/kundian_farm/resource/image/sharebg-1.png';

        ini_set("gd.jpeg_ignore_warning", 1);
        $font_simhei = str_replace('\\','/',realpath(dirname(__FILE__).'/')).'/simhei.ttf';
        $img_bg = imagecreatefrompng($file_bg);//背景
        $img_code = @imagecreatefromjpeg($user['user_qrcode']);//二维码

        //获取背景图片的宽度和高度
        $width = imagesx($img_bg);
        $height = imagesy($img_bg);

        //创建一张与背景图同样大小的真彩色图像
        $im = imagecreatetruecolor($width, $height);
        imagecopy($im, $img_bg, 0, 0, 0, 0, $width, $height);

        $c_cover=getimagesize($user['cover']);
        $c_w=$c_cover[0] > $c_cover[1] ? $c_cover[1] : $c_cover[0];
        //建立画板 ，缩放图片至指定尺寸
        $canvas=imagecreatetruecolor($c_w, $c_w);
        $color = imagecolorallocate($im, 0, 0, 0);
        imagefill($canvas, 0, 0, $color);
        $imgg= $this->yuan_img($user['cover'],$c_w, $c_w);//将用户头像转化为原型头像

        //用户头像大小
        $width_cover = imagesx($imgg);
        $height_cover = imagesy($imgg);

        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($canvas, $imgg, 0, 0, 0, 0, 132, 132,$width_cover,$height_cover);

        imagecopymerge($im, $canvas, 256, 570, 0, 0, 132, 132, 100);

        $color_black=ImageColorAllocate($im,54,54,54);
        $color_gray=ImageColorAllocate($im,99,99,99);

        //用户没名称、提示语
        $model_name=$user['name'];
        $fontBox = imagettfbbox(20, 0, $font_simhei, $model_name);//文字水平居中实质
        imagettftext ( $im, 20, 0, ceil(($width - $fontBox[2]) / 2), 750, $color_black, $font_simhei, $model_name );

        $model_tag='进农场逛逛';
        $fontBox1 = imagettfbbox(20, 0, $font_simhei, $model_tag);//文字水平居中实质
        imagettftext ( $im, 20, 0, ceil(($width - $fontBox1[2]) / 2), 820, $color_gray, $font_simhei, $model_tag );

        //加载二维码图片
        $width_code = imagesx($img_code);
        $height_code = imagesy($img_code);

        $q_canvas=imagecreatetruecolor(300, 300);
        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($q_canvas, $img_code, 0, 0, 0, 0, 300, 300,$width_code,$height_code);
        imagefill($q_canvas, 0, 0, $color);
        imagecopymerge($im, $q_canvas, 175, 160, 0, 0, 300, 300, 100);

        //生成图片
        if(!empty($filename)){
            $res = imagejpeg ($im,$filename,90); //保存到本地
            imagedestroy($im);
            if(!$res) return false;
            return $filename;
        }else{
            header('Content-Type: image/png');
            //最后处理 输出、销毁
            Imagepng($im);
            ImageDestroy($img_code);
            ImageDestroy($img_bg);
            ImageDestroy($im);
        }
    }


    //将图片生成为圆图片
    public function yuan_img($imgpath) {
        $src_img = imagecreatefromstring(file_get_contents($imgpath));
        $w = imagesx($src_img);$h = imagesy($src_img);
        $w = $h = min($w, $h);

        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 0);
        imagefill($img, 0, 0, $bg);
        $r   = $w / 2; //圆半径
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r))) {
                    imagesetpixel($img, $x, $y, $rgbColor);
                }
            }
        }

        return $img;
    }
}