<?php
/**
*异常处理类
**/
class LeguanException extends LeguanBase{

	public function __construct(){
		// 注册AUTOLOAD方法
		spl_autoload_register('LeguanException::autoload');      
		// 设定错误和异常处理
		register_shutdown_function('LeguanException::fatalError');
		set_error_handler('LeguanException::leguanError');
		set_exception_handler('LeguanException::leguanException');
	}

	/**
     * 类库自动加载
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class){
      $leguanException = new LeguanException();
      if(strpos($class, 'Controller')){
        return require $leguanException->Path->appController."/{$class}.php";
      }
    }

    // 致命错误捕获
    public static function fatalError() {
        if ($e = error_get_last()) {
            switch($e['type']){
              case E_ERROR:
              case E_PARSE:
              case E_CORE_ERROR:
              case E_COMPILE_ERROR:
              case E_USER_ERROR:
                #var_dump($e);
                break;
            }
        }
        exit;
    }

    /**
     * 自定义错误处理
     * @access public
     * @param int $errno 错误类型
     * @param string $errstr 错误信息
     * @param string $errfile 错误文件
     * @param int $errline 错误行数
     * @return void
     */
    public static function leguanError($errno, $errstr, $errfile, $errline) {
      // switch ($errno) {
      //     case E_ERROR:
      //     case E_PARSE:
      //     case E_CORE_ERROR:
      //     case E_COMPILE_ERROR:
      //     case E_USER_ERROR:
      //       ob_end_clean();
      //       $errorStr = "$errstr ".$errfile." 第 $errline 行.";
      //       if(C('LOG_RECORD')) Log::write("[$errno] ".$errorStr,Log::ERR);
      //       self::halt($errorStr);
      //       break;
      //     default:
      //       $errorStr = "[$errno] $errstr ".$errfile." 第 $errline 行.";
      //       self::trace($errorStr,'','NOTIC');
      //       break;
      // }
      echo " {$errstr}<br>{$errfile}<br>line {$errline}";
      exit;
    }

    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    public static function leguanException($e) {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        // 发送404信息
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        #var_dump($error);
        exit;
    }


}