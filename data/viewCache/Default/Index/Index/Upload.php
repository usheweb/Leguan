<?php
!defined('LEGUAN_VERSION') && die('permission denied'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>文件上传测试</title>	
</head>
<body>
	<form action="<?php echo htmlspecialchars($this->url->getUrl('index/index/doUpload')); ?>" method="post" enctype ="multipart/form-data">
		<?php echo $upload->getFormMaxSize(); ?>
		<input name="file" type="file" /> <br>
		<!-- <input name="file[]" type="file" /> <br>
		<input name="file[]" type="file" /> <br>
		<input name="file[]" type="file" /> <br>
		<input name="file[]" type="file" /> <br> -->
		<input type="submit" name="Button1" value="上传" />
	</form>	
</body>	
</html>