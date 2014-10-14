<!doctype html>
<html>
<head>
<title><?php echo $this->get('articleTitle');?></title>
</head>
<body>
	<ul>
		<?php foreach($this->get('articleList') as $key=>$value){ ?>
			<li><?php echo $key;?> <?php echo $value['title']; ?></li>
		<?php } ?>
	</ul>
</body>
</html>