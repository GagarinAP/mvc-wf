<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>
</head>
<body>
	<h1><?=$title?></h1>
	<?=$msg?>
	<?if(isset($userName)):?>
	<div>Hello, user <?=$userName?></div>
	<?endif;?>
</body>
</html>