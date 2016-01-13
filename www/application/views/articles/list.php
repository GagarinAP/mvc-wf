<style type="text/css">
	a.edit{
		font-size: 10px;
		color: #88f;
		text-decoration: none;
	}
</style>
<table style="border: 1px solid purple;">	
<?php foreach($list as $art):?>
	<tr>
		<td>
			<a href="/article/view/<?=$art->id?>"><?=$art->title?></a> 
			<a href="/article/edit/<?=$art->id?>" class="edit">[Edit]</a>
		</td>
	</tr>
<?php endforeach; ?>
</table>