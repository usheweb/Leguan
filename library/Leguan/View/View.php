<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Leguan\View;

use \Leguan\LeguanLoder\LeguanLoder;

/**
 * 模板解析类
 */
class View extends LeguanLoder
{
	private $_data = array();
	private $_lLimiter = '{';
	private $_rLimiter = '}';
	private $_escape = 'htmlspecialchars';

	public function __construct()
	{
		$config = $this->config;
		$viewLimiter = $config->viewLimiter;

		$this->_lLimiter = $viewLimiter[0];
		$this->_rLimiter = $viewLimiter[1];
		$this->_escape = $config->viewEscape;
	}

	/**
	 *	加载模板
	 */
	public function display($path = '')
	{
		$config = $this->config;
		$cache = $this->_cache($path);
		// $this->debug->dumpText($this->getContent($path));
		// exit;

		if($config->isDebug || !file_exists($cache)){
			$cacheDir = dirname($cache);

			if(!file_exists($cacheDir) && 
			   !mkdir($cacheDir, 0, true)){
				    die('创建目录失败 {$cacheDir}');
			}

			file_put_contents($cache, $this->getContent($path));
		}

		extract($this->_data);
		require $cache;
	}

	/**
	 * 模板渲染输出
	 * 
	 * @param $path string
	 */
	public function getContent($path = '')
	{
		$view = $this->_view($path);

		if(!file_exists($view)){
			return "{$view}不存在";
		}

		$content = file_get_contents($view);
		return $this->_compile($content);
	}

	/**
	 * 获取view路径
	 */
	private function _view($path)
	{
		return $this->_filename($path);
	}

	/**
	 * 获取view 缓存路径
	 */
	private function _cache($path)
	{
		return $this->_filename($path, true);
	}

	/**
	 * 获取模板路径
	 *
	 * @param $path string
	 * @param $isCache bool
	 * @return string
	 */
	private function _filename($path = '',$isCache = false)
	{
		$path = ltrim($path,'/');

		if (empty($path)) {
			$path = array();
		} elseif(strpos($path, '/') === false) {
			$path = array($path);
		} else {
			$path = explode('/', $path);
		}
		
		$url = $this->url;
		count($path) == 0 && array_unshift($path, $url->a);
		count($path) == 1 && array_unshift($path, $url->c);
		count($path) == 2 && array_unshift($path, $url->m);

		$a = ucwords(array_pop($path));
		$c = ucwords(array_pop($path));
		$m = ucwords(array_pop($path));

		$path = $this->path;
		$config = $this->config;

		if ($isCache) {
			$filename = array($path->view, $config->theme, 'Cache', $m, $c, $a . $config->viewExtension);
		} else {
			$filename = array($path->view, $config->theme, $m, $c, $a . $config->viewExtension);
		}
		
		$filename = implode($path->ds, $filename);

		return $filename;
	}

	/**
	 * 获取js css 文件目录
	 */
	public function skin()
	{
		$path = $this->path;
		$config = $this->config;

		return $path->view. $path->ds . $config->theme . $path->ds . 'Skin';
	}

	/**
	 * 给模板分配变量
	 */
	public function assign($name, $value)
	{
		$this->_data[$name] = $value;
	}

	public function __set($name, $value)
	{
		$this->assign($name, $value);
	}

	/**
	 * 解析模板内容
	 */
	private function _compile($content)
	{
		$content = $this->_extends($content);
		$content = $this->_removeArea($content);

		$content = $this->_securityOutput($content);
		$content = $this->_normalOutput($content);
		$content = $this->_include($content);
		$content = $this->_foreach($content);
		$content = $this->_while($content);
		$content = $this->_if($content);
	
		$content = $this->_dump($content);
	
		$content = $this->_php($content);
		return $content;
	}

	/**
	 * 模板解析 - 模板继承
	 */
	private function _extends($content)
	{
		//获取继承的目标path
		$matches = array();
		$pattern = "/{$this->_lLimiter}extends (.*?){$this->_rLimiter}/";
		preg_match($pattern, $content, $matches);
		if(!isset($matches[1])){
			return $content;
		}

		$parentView = $this->_view($matches[1]);
		if(!file_exists($parentView)){
			return "{$parentView}不存在";
		}

		$parentContent = file_get_contents($parentView);
		//找出子模板中的 area
		$pattern = "|{$this->_lLimiter}area (.*?){$this->_rLimiter}(.*?){$this->_lLimiter}/area{$this->_rLimiter}|s";
		preg_match_all($pattern, $content, $matches);
		if(!isset($matches[1])){
			return $parentContent;
		}

		//把子模板中的area替换掉在父模板中对应的area
		foreach ($matches[1] as $key => $value) {
			$pattern = "|{$this->_lLimiter}area {$value}{$this->_rLimiter}(.*?){$this->_lLimiter}/area{$this->_rLimiter}|s";
			$replacement = "{$this->_lLimiter}area {$value}{$this->_rLimiter}
							{$matches[2][$key]}
						{$this->_lLimiter}/area{$this->_rLimiter}";
			$parentContent = preg_replace($pattern, $replacement, $parentContent);
		}

		//如果还有上级继承 就递归
		$pattern = "/{$this->_lLimiter}extends (.*?){$this->_rLimiter}/";
		if(preg_match($pattern, $parentContent)){
			return $this->_extends($parentContent);
		}
		return $parentContent;
	}

	/**
	 * 模板解析 - 移除area包裹
	 */
	private function _removeArea($content)
	{
		$pattern = "|{$this->_lLimiter}area (.*?){$this->_rLimiter}(.*?){$this->_lLimiter}/area{$this->_rLimiter}|s";
		return preg_replace_callback($pattern, function($matches){
			return $matches[2];
		}, $content);
	}

	/**
	 * 模板解析 - 安全输出
	 * {=$script} == <?php echo htmlspecialchars($script); ?>
	 */
	private function _securityOutput($content)
	{
		$pattern = "/{$this->_lLimiter}=(.*?){$this->_rLimiter}/";
		$replacement = "<?php echo {$this->_escape}($1); ?>";
		return preg_replace($pattern, $replacement, $content);
	}

	/**
	 * 模板解析 - 正常输出
	 * {!$script} == <?php echo $script; ?>
	 */
	private function _normalOutput($content)
	{
		$pattern = "/{$this->_lLimiter}!(.*?){$this->_rLimiter}/";
		$replacement = "<?php echo $1; ?>";
		return preg_replace($pattern, $replacement, $content);
	}

	/**
	 * 模板解析 - 加载模板
	 */
	private function _include($content)
	{
		$pattern = "/{$this->_lLimiter}include (.*?){$this->_rLimiter}/";
		$_this = $this;
		$content = preg_replace_callback($pattern, function($matches) use($_this){
			return $_this->getContent($matches[1]);
		}, $content);

		return $content;
	}

	/**
	 * 模板解析 - foreach
	 */
	private function _foreach($content)
	{
		$pattern = "/{$this->_lLimiter}(foreach.*?){$this->_rLimiter}/";
		$replacement = "<?php $1{ ?>";
		$content = preg_replace($pattern, $replacement, $content);
		$pattern = "|{$this->_lLimiter}/foreach{$this->_rLimiter}|";
		$replacement = "<?php } ?>";
		return preg_replace($pattern, $replacement, $content);
	}

	/**
	 * 模板解析 - while
	 */
	private function _while($content)
	{
		$pattern = "/{$this->_lLimiter}(while.*?){$this->_rLimiter}/";
		$replacement = "<?php $1{ ?>";
		$content = preg_replace($pattern, $replacement, $content);
		$pattern = "|{$this->_lLimiter}/while{$this->_rLimiter}|";
		$replacement = "<?php } ?>";
		return preg_replace($pattern, $replacement, $content);
	}

	/**
	 * 模板解析 - if
	 */
	private function _if($content)
	{
		$pattern = "/{$this->_lLimiter}(if.*?){$this->_rLimiter}/";
		$replacement = "<?php $1{ ?>";
		$content = preg_replace($pattern, $replacement, $content);
		$pattern = "|{$this->_lLimiter}else{$this->_rLimiter}|";
		$replacement = "<?php }else{ ?>";
		$content = preg_replace($pattern, $replacement, $content);
		$pattern = "/{$this->_lLimiter}(elseif|else if)(.*?){$this->_rLimiter}/";
		$replacement = "<?php }else if$2{ ?>";
		$content = preg_replace($pattern, $replacement, $content);
		$pattern = "|{$this->_lLimiter}/if{$this->_rLimiter}|";
		$replacement = "<?php } ?>";
		return preg_replace($pattern, $replacement, $content);
	}

	/**
	 * 模板解析 - php
	 */
	private function _php($content)
	{
		$pattern = "/{$this->_lLimiter}(.*?){$this->_rLimiter}/";
		$replacement = "<?php $1; ?>";
		return preg_replace($pattern, $replacement, $content);
	}

	/**
	 * 变量调试
	 */
	private function _dump($content)
	{
		$pattern = "/{$this->_lLimiter}dump\((.*?)\){$this->_rLimiter}/";
		$replacement = "<?php \$this->debug->dump($1); ?>";
		return preg_replace($pattern, $replacement, $content);
	}

}
