<?php
    if(! isset($title)) $title = 'Page';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>
        <style>
            body{
                padding:0;
                margin:0;
            }
        .menu>a{
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #888;
            text-decoration: none;
            padding: 0 2px 0 2px;
            margin: 5px;
        }
        </style>
</head>
<body>
    <div class="menu">
        <a href="/login">Login</a>
        <a href="/login/register">Register</a>
        <a href="/article">Articles</a>
        <a href="/test">Test</a>
    </div>
    <h3><?=$title?></h3>
	<?php if(isset($content)):?>
	<div>
		<?=$content?>
	</div>
	<?php endif?>
</body>
</html>
