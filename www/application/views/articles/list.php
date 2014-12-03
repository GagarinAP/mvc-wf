<table style="border: 1px solid purple;">
<?php foreach($list as $art):?>
	<tr><td><a href="/article/view/<?=$art->id?>"><?=$art->title?></a></td></tr>
<?php endforeach; ?>
</table>