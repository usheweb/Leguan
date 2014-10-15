<h1>TOP</h1>

							
							
<h1>
	Hi , Leguan for <?php echo htmlspecialchars($author); ?>
</h1>
<?php #dump($article); ?>
<ol>
	<?php foreach($article as $v){ ?>
		<li>(<?php echo htmlspecialchars($v['id']); ?>)<?php echo htmlspecialchars($v['title']); ?></li>
	<?php } ?>
</ol>
<p>
	<?php if($age<10){ ?>
		<?php echo 10; ?>
	<?php }else if($age==20){ ?>
		<?php echo htmlspecialchars($age); ?>
	<?php } ?>
</p>
<ul>
	<?php $i = 0; ?>
	<?php while($i<count($list)){ ?>
		<?php if($i!=1){ ?>
			<li><?php echo htmlspecialchars($list[$i]); ?></li>
		<?php } ?>
		<?php $i++; ?>
	<?php } ?>
</ul>
<p><?php echo htmlspecialchars($script); ?></p>

						
						