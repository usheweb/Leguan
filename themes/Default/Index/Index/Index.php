<?php 
!defined('LEGUAN_VERSION') && die('permission denied'); ?>
<!-- {extends parent} -->

<!-- {area body} -->
<h1>
	Hi , Leguan for <!-- {=$author} -->
</h1>
<!-- {#dump($article)} -->
<ol>
	<!-- {foreach($article as $v)} -->
		<li>(<!-- {=$v['id']} -->)<!-- {=$v['title']} --></li>
	<!-- {/foreach} -->
</ol>
<p>
	<!-- {if($age<10)} -->
		<!-- {!10} -->
	<!-- {else if($age==20)} -->
		<!-- {=$age} -->
	<!-- {/if} -->
</p>
<ul>
	<!-- {$i = 0} -->
	<!-- {while($i<count($list))} -->
		<!-- {if($i!=1)} -->
			<li><!-- {=$list[$i]} --></li>
		<!-- {/if} -->
		<!-- {$i++} -->
	<!-- {/while} -->
</ul>
<p><!-- {=$script} --></p>
<!-- {/area} -->
<!-- {area test} -->
test
<!-- {/area} -->
<!-- {include test} -->