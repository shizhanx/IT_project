<?php if (empty($artifacts)): ?>
	<h1>No result</h1>
<?php else: ?>
	<?php foreach ($artifacts as $a): ?>
		<header><?php echo $a['name'] ?></header> <br />
		<h1><?php echo $a['description'] ?></h1> <br />
	<?php endforeach; ?>
<?php endif; ?>
