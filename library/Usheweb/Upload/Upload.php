<?php
/**
 * leguan Framework
 *
 * @link      http://github.com/usheweb/leguan
 * @copyright Copyright (c) 2014 ushe (http://leguan.usheweb.com/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

 namespace Usheweb\Upload;

 use \Leguan\Bootstrap\Leguan;

 /**
  * 文件上传类
  */
 class Upload
 {
 	//上传文件的表单名称
 	private $_formName = 'file';
 	//上传文件存放目录
 	private $_fileDir;
 	//上传文件最大尺寸 1024 * 1024 * 10 = 10M
 	private $_fileSize = 10485760;
 	//上传文件类型 array_key_exists
 	private $_fileExtension = array();

 	public function __construct()
 	{
 		$config = Leguan::get('config');
 		$this->_fileSize = $config->fileMaxSize;
 		$this->_fileExtension = $config->fileExtension;

 		$path = Leguan::get('path');
 		$this->_fileDir = $path->upload;
 	}

 	/**
 	 * 设置上传文件表单name
 	 *
 	 * @param $name string
 	 * @return void
 	 */
 	public function setFormName($name)
 	{
 		$this->_formName = $name;
 	}

 	/**
 	 * 设置上传文件大小
 	 *
 	 * @param $size int
 	 * @return void
 	 */
 	public function setFileSize($size)
 	{
 		$this->_fileSize = $size;
 	}

 	/**
 	 * 设置上传文件所在目录
 	 *
 	 * @param $fileDir string
 	 * @return void
 	 */
 	public function setFileDir($fileDir)
 	{
 		$this->_fileDir = $fileDir;
 	}

 	/**
 	 * 设置上传文件允许扩展名
 	 *
 	 * @param $fileExtention array
 	 * @return void
 	 */
 	public function setFileExtention($fileExtention)
 	{
 		$this->_fileExtention = $fileExtention;
 	}

 	public function run()
 	{
 		//新上传文件所在路径
 		$filePath = array();

 		if(!isset($_FILES[$this->_formName])){
 			return "上传文件失败,1.表单上传name是否为{$this->_formName} 2.文件不能大于". $this->_fileSize / 1024 / 1024 .'MB';
 		}

        //多文件上传
        if (is_array($_FILES[$this->_formName]['error'])) {
            foreach ($_FILES[$this->_formName]['error'] as $key => $error) {
                if (empty($_FILES[$this->_formName]['name'][$key])) {
                        continue;
                    }

                if ($_FILES[$this->_formName]['error'][$key] == UPLOAD_ERR_OK) {

                    $file = $_FILES[$this->_formName];
                    $result = $this->_exec($file['name'][$key], $file['type'][$key], $file['tmp_name'][$key], $file['error'][$key], $file['size'][$key]);
                    if (!is_array($result)) {
                        return $result;
                    }

                    array_push($filePath, array_pop($result));
                } else {
                    return '文件上传失败';
                }
            }
        } else {
        //单文件上传
            $file = $_FILES[$this->_formName];
            $result = $this->_exec($file['name'], $file['type'], $file['tmp_name'], $file['error'], $file['size']);
            if(is_array($result)){
                array_push($filePath, array_pop($result));
            } else {
                return $result;
            }
        }

		return $filePath;
 	}

 	/**
 	 * 表单处理
 	 */
 	private function _exec($name, $type, $tmp_name, $error, $size)
 	{
 		if ($size > $this->_fileSize) {
    		return '上传文件失败,文件不能大于' . $this->_fileSize / 1024 / 1024 .'MB';
    	}

    	$extension = Leguan::get('path')->getExtension($name);

    	if (empty($extension)) {
    		return '文件扩展名不能为空';
    	}

    	if (!in_array($extension, $this->_fileExtension)) {
    		return "上传文件失败,文件类型不允许为扩展{$extension}";
    	}

        $path = Leguan::get('path');
        $dirName = date('Ym') . $path->ds . date('d');
        $realPath = array($this->_fileDir, $dirName);
        $realPath = implode($path->ds, $realPath);
        //判断目录是否存在
        if (!file_exists($realPath)) {
        	mkdir($realPath, 0777, true);
        }

        $fileName = md5_file($tmp_name).".{$extension}";
        $filePath = array();
        array_push($filePath, $dirName . $path->ds . $fileName);
        move_uploaded_file($tmp_name, "{$realPath}{$path->ds}{$fileName}");

        return $filePath;
 	}

 	/**
 	 * 获取表单最大文件上传尺寸隐藏字段
 	 */
 	public function getFormMaxSize()
 	{
 		return "<input type='hidden' name='MAX_FLIE_SIZE' value='{$this->_fileSize}' />";
 	}

 }