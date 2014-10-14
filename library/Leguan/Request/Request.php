<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Request;

class Request
{
	/**
	 * 是否为post请求
	 */
	public function isPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	/**
	 * 是否为get请求
	 */
	public function isGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	/**
	 * 是否为put请求
	 */
	public function isPut()
	{
		return $_SERVER['REQUEST_METHOD'] == 'PUT';
	}

	/**
	 * 是否为delete请求
	 */
	public function isDelete()
	{
		return $_SERVER['REQUEST_METHOD'] == 'DELETE';
	}

	/**
	 * 是否为ajax请求
	 */
	public function isAjax()
	{
		return isset($this->_data['HTTP_X_REQUESTED_WITH'])
		 && strtolower($this->_data['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false;
	}

	/**
	 * 是否为手机客户端
	 */
	public function isMobile()
	{
		//判断手机发送的客户端标志
		if(isset($this->_data['HTTP_USER_AGENT'])) {
			$userAgent = strtolower($this->_data['HTTP_USER_AGENT']);
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

	/**
	 * 获取客户端IP地址
	 *
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @param boolean $adv 是否进行高级模式获取（有可能被伪装） 
	 * @return mixed
	 */
	public function getClientIp($type = 0,$adv=false)
	{
		$type       =  $type ? 1 : 0;
	    static $ip  =   NULL;
	    if ($ip !== NULL) return $ip[$type];
	    if($adv){
	        if (isset($this->_data['HTTP_X_FORWARDED_FOR'])) {
	            $arr    =   explode(',', $this->_data['HTTP_X_FORWARDED_FOR']);
	            $pos    =   array_search('unknown',$arr);
	            if(false !== $pos) unset($arr[$pos]);
	            $ip     =   trim($arr[0]);
	        }elseif (isset($this->_data['HTTP_CLIENT_IP'])) {
	            $ip     =   $this->_data['HTTP_CLIENT_IP'];
	        }elseif (isset($this->_data['REMOTE_ADDR'])) {
	            $ip     =   $this->_data['REMOTE_ADDR'];
	        }
	    }elseif (isset($this->_data['REMOTE_ADDR'])) {
	        $ip     =   $this->_data['REMOTE_ADDR'];
	    }
	    // IP地址合法验证
	    $long = sprintf("%u",ip2long($ip));
	    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	    return $ip[$type];
	}

	/**
	 * 获取当前域名
	 */
	public function getDomain($hasBaseUrl = true)
	{
		$httpType = $this->getHttpType();
		$domain = "{$httpType}{$_SERVER['SERVER_NAME']}";

		if ($_SERVER["SERVER_PORT"] != 80) {
			$domain = "{$domain}:{$_SERVER["SERVER_PORT"]}";
		}
		
		if ($hasBaseUrl) {
			$baseUrl = dirname($_SERVER['SCRIPT_NAME']);
			$baseUrl = str_replace('\\','/', $baseUrl);
			$baseUrl = ltrim($baseUrl, '/');
			$domain = "{$domain}/{$baseUrl}";
		}

		return $domain;
	}

	/**
	 * 获取http类型
	 */
	public function getHttpType()
	{
		return $this->isSsl() ? "https://" : "http://";
	}

	/**
	 * 判断是否SSL协议
	 * @return boolean
	 */
	function isSsl() 
	{
	    if (isset($_SERVER['HTTPS']) && 
	    	('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
	        return true;
	    } elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
	        return true;
	    }
	    return false;
	}
}