<?php

class Security{

	/**
	 * html转义
	 * @param mixed $expression 需要处理的字符串或数组
	 * @return mixed
	 */
	public function removeXss($expression){
		if($expression == null){
			return $expression;
		}
		if(is_array($expression)){
			foreach ($expression as $key => $value) {
				$expression[$key] = $this->removeXss($value);
			}
		}else{
			return htmlentities($expression);
		}
		return $expression;
	}
}