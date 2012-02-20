<?php

$phonemes = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$current_language = $this->session->userdata('current_language');

?>

<?php $message = $this->session->flashdata('message'); if ($message): ?>
	<div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<div id="sort-buttons" class="btn-group">
	<a href="#alphabetical-sort" class="btn active">Sort alphabetically (English)</a>
	<a href="#phonetic-sort" class="btn">Sort phonetically (Native)</a>
</div>

<?php //var_dump($words); ?>

<div class="word-list" id="alphabetical-sort">
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			<?php foreach ($phonemes as $i => $phoneme): ?>
				<li<?php echo ($i == 0) ? ' class="active"' : ''; ?>>
					<a href="#a<?= $i ?>" data-toggle="tab"><?= $phoneme ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		
		<div class="tab-content">
			<?php foreach ($phonemes as $i => $phoneme): ?>
				<div class="tab-pane<?php echo ($i == 0) ? ' active' : ''; ?>" id="a<?= $i ?>">
					<h1><?= $phoneme ?></h1>

					<?php foreach ($words['alphabetical'][$phoneme] as $word): ?>
						<article class="word-details">
							<h3>
								<span class="word-english"><?= ucfirst($word['english']) ?></span> – 
								<span class="native"><?= $word['native'] ?></span> 
								<span class="word-pronunciation">|<?= $word['phonetic'] ?>|</span>
							</h3>
							
							<ol class="definitions">
								<?php foreach ($word['definitions'] as $definition): ?>
									<?php if ( ! empty($definition['definition'])): ?>
										<li>
											<span class="part-of-speech"><?= $definition['part_of_speech'] ?></span>

											<?= $definition['definition'] ?>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ol>

							<a class="close" href="<?= site_url('page/edit_word/' . $word['_id']) ?>"><i class="icon-pencil"></i></a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="word-list" id="phonetic-sort" style="display: none;">
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			<?php foreach ($current_language['phoneme_order'] as $i => $phoneme): ?>
				<li<?php echo ($i == 0) ? ' class="active"' : ''; ?>>
					<a href="#b<?= $i ?>" data-toggle="tab"><?= $phoneme ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		
		<div class="tab-content">
			<?php foreach ($current_language['phoneme_order'] as $i => $phoneme): ?>
				<div class="tab-pane<?php echo ($i == 0) ? ' active' : ''; ?>" id="b<?= $i ?>">
					<h1><?= $phoneme ?></h1>

					<?php foreach ($words['phonetic'][$phoneme] as $word): ?>
						<article class="word-details">
							<h3>
								<span class="native"><?= $word['native'] ?></span> 
								<span class="word-pronunciation">|<?= $word['phonetic'] ?>|</span> – 
								<span class="word-english"><?= ucfirst($word['english']) ?></span>
							</h3>

							<ol class="definitions">
								<?php foreach ($word['definitions'] as $definition): ?>
									<?php if ( ! empty($definition['definition'])): ?>
										<li>
											<span class="part-of-speech"><?= $definition['part_of_speech'] ?></span>

											<?= $definition['definition'] ?>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ol>

							<a class="close" href="<?= site_url('page/edit_word/' . $word['_id']) ?>"><i class="icon-pencil"></i></a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<script>
$(function() {
	$('#sort-buttons a').bind('click', function() {
		$('#sort-buttons a').removeClass('active');
		$('.word-list').hide();

		$(this).addClass('active');
		$($(this).attr('href')).show();

		return false;
	});
});
</script>