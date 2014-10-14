<?php
class Request extends LeguanBase{
	public function __construct(){
		//$this->Debug->dump($this->getInput('m'));
		//$this->Debug->dump(isset($_POST['m']));
	}

	public function isPost(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	public function isGet(){
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	public function isPut(){
		return $_SERVER['REQUEST_METHOD'] == 'PUT';
	}

	public function isDelete(){
		return $_SERVER['REQUEST_METHOD'] == 'DELETE';
	}

	public function isAjax(){
		return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		 && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false;
	}

	public function isMobile(){
		//判断手机发送的客户端标志
		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
			$clientkeywords = array(
		      'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-'
		      ,'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
		      'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini',
		      'operamobi', 'opera mobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
			);
			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if(preg_match("/(".implode('|',$clientkeywords).")/i",$userAgent) 
				&& strpos($userAgent,'ipad') === false){
				return true;
			}
		}
		return false;
	}

	public function geHttpHost(){
		return $_SERVER['HTTP_HOST'];
	}

	public function getHttpUserAgent(){
		return $_SERVER['HTTP_USER_AGENT'];
	}

	/**
	 * 获取客户端请求参数
	 * @param integer $key 需要获取的参数名称
	 * @param string $type 'POST' 'GET' 
	 * @param bool $isRemoveXss 是否进行html转义
	 * @return mixed
	 */
	public function getInput($key,$type = null,$isRemoveXss = true){
		$value = (($type == null || strtolower($type) == 'get') 
		&& isset($_GET[$key])) ? $_GET[$key] : null;
		$value = (($type == null || strtolower($type) == 'post') 
		&& isset($_POST[$key])) ? $_POST[$key] : $value;
		return $isRemoveXss == true ? $this->Security->removeXss($value) : $value;
	}

	/**
	 * 获取客户端IP地址
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @param boolean $adv 是否进行高级模式获取（有可能被伪装） 
	 * @return mixed
	 */
	public function getClientIp($type = 0,$adv=false){
		$type       =  $type ? 1 : 0;
	    static $ip  =   NULL;
	    if ($ip !== NULL) return $ip[$type];
	    if($adv){
	        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	            $pos    =   array_search('unknown',$arr);
	            if(false !== $pos) unset($arr[$pos]);
	            $ip     =   trim($arr[0]);
	        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
	            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
	        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
	            $ip     =   $_SERVER['REMOTE_ADDR'];
	        }
	    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
	        $ip     =   $_SERVER['REMOTE_ADDR'];
	    }
	    // IP地址合法验证
	    $long = sprintf("%u",ip2long($ip));
	    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	    return $ip[$type];
	}
}