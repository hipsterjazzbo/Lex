<?php

$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

?>

<div id="sort-buttons" class="btn-group">
	<button class="btn active">Sort phonetically</button>
	<button class="btn">Sort by english equivalent</button>
</div>

<div id="sort-b">
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			<?php foreach ($letters as $i => $letter): ?>
				<li<?php echo ($i == 0) ? ' class="active"' : ''; ?>>
					<a href="#<?= $i ?>" data-toggle="tab"><?= $letter ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		
		<div class="tab-content">
			<?php foreach ($letters as $i => $letter): ?>
				<div class="tab-pane<?php echo ($i == 0) ? ' active' : ''; ?>" id="<?= $i ?>">
					<h1><?= $letter ?></h1>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>