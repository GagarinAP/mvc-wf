<html>
	<head></head>
	<body>
		<h1><?=$title?></h1>
		<div>
			<?php foreach($names as $sname):?>
				<?php $this->import('tests/intro', ['subname' => $sname])?>
			<?php endforeach;?>
		</div>
	</body>
</html>