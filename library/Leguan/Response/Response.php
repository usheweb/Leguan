<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\Response;

use \Leguan\Bootstrap\Leguan;

/**
 * HTTP响应类
 */
class Response
{
	/**
	 * 设置http响应字符集
	 *
	 * @param $charset string
	 * @return void
	 */
	public function setCharset($charset)
	{
		header("Content-Type:text/html;charset={$charset}");
	}

	/**
	 * 开启gzip
	 */
	public function gzip()
	{
		if (function_exists('ob_gzhandler')) {
		    ob_start('ob_gzhandler');
		}
	}

	/**
	 * 禁用浏览器缓存
	 *
	 * @link http://www.usheweb.com/a/bowen/20141017/1197.html
	 */
	public function disableCache()
	{
		//设置此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。   
		header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");     
		//设置此页面的最后更新日期(用格林威治时间表示)为当天，可以强制浏览器获取最新资料   
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");     
		//告诉客户端浏览器不使用缓存，HTTP 1.1 协议   
		header("Cache-Control: no-cache, must-revalidate");
		//告诉客户端浏览器不使用缓存，兼容HTTP 1.0 协议   
		header("Pragma: no-cache");   
	}

	/**
	 * URL重定向
	 * @link http://thinkphp.cn
	 *
	 * @param string $url 重定向的URL地址
	 * @param integer $time 重定向的等待时间（秒）
	 * @param bool $isHeader 是否使用header函数跳转
	 * @param string $msg 重定向前的提示信息
	 * @return void
	 */
	public function redirect($url, $time=0, $isHeader=true, $msg='')
	{
		$this->sendHttpStatus(301);

	    //多行URL地址支持
	    $url        = str_replace(array("\n", "\r"), '', $url);
	    if (empty($msg))
	        $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
	    if ($isHeader) {
	        // redirect
	        if (0 === $time) {
	            header('Location: ' . $url);
	        } else {
	            header("refresh:{$time};url={$url}");
	            echo($msg);
	        }
	        exit();
	    } else {
	        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
	        if ($time != 0)
	            $str .= $msg;
	        exit($str);
	    }
	}

	/**
	 * 发送HTTP状态
	 * @link http://thinkphp.cn
	 *
	 * @param integer $code 状态码
	 * @return void
	 */
	public function sendHttpStatus($code)
	{
	    static $_status = array(
	            // Informational 1xx
	            100 => 'Continue',
	            101 => 'Switching Protocols',
	            // Success 2xx
	            200 => 'OK',
	            201 => 'Created',
	            202 => 'Accepted',
	            203 => 'Non-Authoritative Information',
	            204 => 'No Content',
	            205 => 'Reset Content',
	            206 => 'Partial Content',
	            // Redirection 3xx
	            300 => 'Multiple Choices',
	            301 => 'Moved Permanently',
	            302 => 'Moved Temporarily ',  // 1.1
	            303 => 'See Other',
	            304 => 'Not Modified',
	            305 => 'Use Proxy',
	            // 306 is deprecated but reserved
	            307 => 'Temporary Redirect',
	            // Client Error 4xx
	            400 => 'Bad Request',
	            401 => 'Unauthorized',
	            402 => 'Payment Required',
	            403 => 'Forbidden',
	            404 => 'Not Found',
	            405 => 'Method Not Allowed',
	            406 => 'Not Acceptable',
	            407 => 'Proxy Authentication Required',
	            408 => 'Request Timeout',
	            409 => 'Conflict',
	            410 => 'Gone',
	            411 => 'Length Required',
	            412 => 'Precondition Failed',
	            413 => 'Request Entity Too Large',
	            414 => 'Request-URI Too Long',
	            415 => 'Unsupported Media Type',
	            416 => 'Requested Range Not Satisfiable',
	            417 => 'Expectation Failed',
	            // Server Error 5xx
	            500 => 'Internal Server Error',
	            501 => 'Not Implemented',
	            502 => 'Bad Gateway',
	            503 => 'Service Unavailable',
	            504 => 'Gateway Timeout',
	            505 => 'HTTP Version Not Supported',
	            509 => 'Bandwidth Limit Exceeded'
	    );

	    if(isset($_status[$code])) {
	        header('HTTP/1.1 '.$code.' '.$_status[$code]);
	        // 确保FastCGI模式下正常
	        header('Status:'.$code.' '.$_status[$code]);
	    }
	}

	/**
	 * 把数组以json的格式输出到浏览器
	 *
	 * @param $data array 带输出的数组
	 */
	public function ajaxJson($data)
	{
		header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));
	}

}