<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Usheweb\Upload;

/**
 * 文件MIME类型类
 * 
 * @link http://www.usheweb.com/a/bowen/20141012/1170.html
 * @link http://www.usheweb.com/a/bowen/20141012/1171.html
 */
 class Mime
 {
 	private static $_data = array(
 				'zip' => 'application/zip',
 				'rar' => 'application/x-rar-compressed',
 				'tar' => 'application/x-tar',
 				'gz' => 'application/x-gzip',
 				'jpg' => 'image/jpeg',
 				'jpeg' => 'image/jpeg',
 				'jpe' => 'image/jpeg',
 				'jpz' => 'image/jpeg',
 				'gif' => 'image/gif',
 				'ifm' => 'image/gif',
 				'bmp' => 'application/x-MS-bmp',
 				'png' => 'image/png',
 				'mp3' => 'audio/x-mpeg',
 				'mp4' => 'video/mp4',
 				'mpe' => 'video/mpeg',
 				'mpeg' => 'video/mpeg',
 				'mpg' => 'video/mpeg',
 				'mpg4' => 'video/mp4',
 				'rmvb' => 'audio/x-pn-realaudio',
 				'doc' => 'application/msword',
 				'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
 				'xls' => 'application/vnd.ms-excel',
 				'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
 				'ppt' => 'application/vnd.ms-powerpoint',
 				'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
 				'htm' => 'text/html',
 				'html' => 'text/html',
 				'txt' => 'text/plain',
 			);
 	/**
 	 * 获取文件扩展
 	 */
 	public static function getExtension($mime)
 	{
 		$data = array_flip(self::$_data);
 		if (isset($data[$mime])) {
 			return $data[$mime];
 		}

 		return null;
 	}

 	/**
 	 * 获取文件Mime
 	 */
 	public static function getMime($extension)
 	{
 		$data = self::$_data;
 		if (isset($data[$extension])) {
 			return $data[$extension];
 		}

 		return null;
 	}
 }