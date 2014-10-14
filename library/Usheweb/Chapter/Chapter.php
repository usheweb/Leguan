<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Usheweb\Chapter;

/**
 * 验证码类
 *
 * @link http://blog.csdn.net/liruxing1715/article/details/6897286
 */
class Chapter
{
	//验证码字符
	private $_charset = 'abcdefghkmnprstwxyzABCDEFGHKMNPRSTWXYZ23456789'; 
    private $_code;                        //验证码  
    private $_len = 4;                    //验证码长度  
    private $_width = 130;                    //宽度  
    private $_height = 50;                    //高度  
    private $_img;                            //图形资源句柄
    private $_fontsize = 20;                //指定字体大小
    private $_font;

    public function __construct($width = 100, $height = 35, $len = 4, $fontSize = 20)
    {
    	$this->_width = $width;
    	$this->_height = $height;
    	$this->_len = $len;
        $this->_fontSize = $fontSize;

        $this->setFont('elephant.ttf');
    }

    /**
     * 设置图片宽度
     *
     * @param $width int
     * @return void
     */
    public function setWidth($width)
    {
    	$this->_width = $width;
    }

    /**
     * 设置图片高度
     *
     * @param $height int
     * @return void
     */
    public function setHeight($height)
    {
    	$this->_height = $height;
    }

    /**
     * 设置验证码字符数
     *
     * @param $len int
     * @return void
     */
    public function setLen($len)
    {
    	$this->_len = $len;
    }

    /**
     * 设置字体尺寸
     *
     * @param $fontSize int
     * @return void
     */
    public function setFontSize($fontSize)
    {
        $this->_fontSize = $fontSize;
    }

    /**
     * 设置字体
     *
     * @param $font string
     * @return void
     */
    public function setFont($font)
    {
        $this->_font = $font;
    }

    /**
     * 显示验证码
     */ 
    public function show()
    {  
        $this->_createBg();
        $this->_createCode();
        $this->_createLine();
        $this->_createFont();
        $this->_outPut();
    }  
  
    /**
     * 获取验证码 
     */ 
    public function getChapter()
    {  
        return strtolower($this->_code);  
    } 

    //生成随机码  
    private function _createCode()
    {  
        $_len = strlen($this->_charset)-1;  
        for ($i=0;$i<$this->_len;$i++) {  
            $this->_code .= $this->_charset[mt_rand(0,$_len)];  
        }  
    }

    //生成背景  
    private function _createBg()
    {  
        $this->_img = imagecreatetruecolor($this->_width, $this->_height);  
        $color = imagecolorallocate($this->_img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));  
        imagefilledrectangle($this->_img,0,$this->_height,$this->_width,0,$color);  
    }
  
    //生成文字  
    private function _createFont()
    {      
        $_x = $this->_width / $this->_len;  
        for ($i=0;$i<$this->_len;$i++) {  
            $this->_fontcolor = imagecolorallocate($this->_img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));

            //判断是否支持 FreeType
            $gdInfo = gd_info();
            if(isset($gdInfo['FreeType Support'])
               && $gdInfo['FreeType Support'] === true){
                $font = array(dirname(__FILE__), 'font', $this->_font);
                $font = implode(DIRECTORY_SEPARATOR, $font);

                imagettftext($this->_img,$this->_fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->_height / 1.4,$this->_fontcolor,$font,$this->_code[$i]);
            }else{
                imagechar($this->_img, mt_rand(3,30), $_x*$i+mt_rand(5,15), mt_rand(0,$this->_height/2), $this->_code[$i], $this->_fontcolor);
            }
        }  
    }
  
    //生成线条、雪花  
    private function _createLine()
    {  
        for ($i=0;$i<6;$i++) {  
            $color = imagecolorallocate($this->_img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));  
            imageline($this->_img,mt_rand(0,$this->_width),mt_rand(0,$this->_height),mt_rand(0,$this->_width),mt_rand(0,$this->_height),$color);  
        }  
        for ($i=0;$i<100;$i++) {  
            $color = imagecolorallocate($this->_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));  
            imagestring($this->_img,mt_rand(1,5),mt_rand(0,$this->_width),mt_rand(0,$this->_height),'*',$color);  
        }  
    }

    //输出  
    private function _outPut()
    {  
        header('Content-type:image/png');  
        imagepng($this->_img);  
        imagedestroy($this->_img);  
    } 
}