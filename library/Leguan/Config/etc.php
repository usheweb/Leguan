<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 return array(
 		//默认时区
 		'timezone' => 'Asia/Shanghai',
 		//默认字符集
 		'charset' => 'utf-8',
 		//开发者模式
 		'isDebug' => false,
 		//路由类型 0 普通、1 patInfo、2 url重写、3 clean
 		'urlType' => 1,
 		//url clean模式下的key
 		'urlCleanKey' => 'l',
 		//表、字段转义 - mysql
 		'dbEscapeMysql' => array('`', '`'),
 		//表、字段转义 - mssql
 		'dbEscapeMssql' => array('[', ']'),
 		//表、字段转义 - sqllite
 		'dbEscapeSqllite' => array('"', '"'),
 		//是否开启session 
 		'sessionStart' => true,
 		//默认模块
 		'defaultModule' => 'Index',
 		//默认控制器
 		'defaultController' => 'Index',
 		//默认方法
 		'defaultAction' => 'Index',
 		//默认模板主题
 		'theme' => 'Default',
 		//模板扩展名
 		'viewExtension' => '.php',
 		//模板分割符
 		'viewLimiter' => array('<!--{','}-->'),
 		//模板输出转义函数
 		'viewEscape' => 'htmlspecialchars',
 		//url扩展
 		'urlExtension' => '.html',
 		//url分割符
 		'urlLimiter' => '/',
 		//缓存类型
 		'cacheType' => 'file',
 		//上传文件扩展名
 		'fileExtension' => array('txt', 'html', 'htm', 'jpg', 'png', 'gif', 'bmp', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar'),
 		//上传文件最大尺寸 1024 * 1024 * 10 = 10M
 		'fileMaxSize' => 1024 * 1024 * 10
 	);