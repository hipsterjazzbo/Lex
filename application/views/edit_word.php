<?php $current_language = $this->session->userdata('current_language'); ?>

<?php $message = $this->session->flashdata('message'); if ($message): ?>
	<div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<form id="edit-word-form" class="form-inline" method="post" action="<?= site_url('action/edit_word/' . $word['_id']) ?>">
	<fieldset>
		<legend>Edit word</legend>
		
		<input type="hidden" name="language" value="<?= $word['language'] ?>">

		<input value="<?= $word['native'] ?>" required type="text" class="input-thirds native" name="native" placeholder="Native word" autofocus>

		<input value="<?= $word['phonetic'] ?>" required type="text" class="input-thirds" name="phonetic" placeholder="Phonetic pronunciation">
				
		<input value="<?= $word['english'] ?>" required type="text" class="input-thirds" name="english" placeholder="English equivalent">
		
		<h3>Definitions</h3>
		<div id="definitions">
			<?php if (empty($word['definitions'][0]['definition'])): ?>
				<div class="well definition first">
					<label>1.</label>
					<input type="text" class="input-xlarge" name="definitions[0][part_of_speech]" placeholder="Part of speech" data-provide="typeahead">
					<textarea class="input-xlarge wysiwyg" rows="3" name="definitions[0][definition]" placeholder="Definition"></textarea>
				</div>
			<?php else: ?>
				<?php foreach ($word['definitions'] as $key => $definition): ?>
					<div class="well definition first">
						<label><?= $key + 1 ?>.</label>
						<input value="<?= $definition['part_of_speech'] ?>" type="text" class="input-xlarge" name="definitions[<?= $key ?>][part_of_speech]" placeholder="Part of speech" data-provide="typeahead">
						<textarea class="input-xlarge wysiwyg" rows="3" name="definitions[<?= $key ?>][definition]" placeholder="Definition"><?= $definition['definition'] ?></textarea>
						<?php if ($key > 0): ?>
							<a class="close" title="Delete this definition">&times;</a>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		
		<div class="form-actions">
			<a class="btn btn-success" id="add-definition" href="#"><i class="icon-plus icon-white"></i> Add another definition</a>
			<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save word</button>
		</div>
	</fieldset>
</form>

<script type="text/javascript">
$(function() {
	var i = 1;

	$('#add-definition').bind('click', function() {
		var div = $('<div>');

		div.addClass('well definition generated')
		   .append('<label>' + (i + 1) + '.</label>')
		   .append('<input type="text" class="input-xlarge" name="definitions[' + i + '][part_of_speech]" placeholder="Part of speech" data-provide="typeahead">')
		   .append('<textarea class="input-xlarge wysiwyg" rows="3" name="definitions[' + i + '][definition]" placeholder="Definition"></textarea>')
		   .append('<a class="close" title="Delete this definition">&times;</a>');
		  
		div.appendTo('#definitions');

		$(".wysiwyg").cleditor({
            controls: "bold italic underline | bullets numbering | alignleft center alignright",
        });

		i++;
		return false;
	});

	$('.definition .close').live('click', function() {
		i = 2;

		$(this).parent().remove();

		$('.definition.generated').each(function() {
			var div = $('<div>');

			div.addClass('well definition generated')
			   .append('<label>' + i + '.</label>')
			   .append('<input value="' + $(this).find('input').val() + '" type="text" class="input-xlarge" name="definitions[' + i + '][part_of_speech]" placeholder="Part of speech" data-provide="typeahead">')
			   .append('<textarea class="input-xlarge wysiwyg" rows="3" name="definitions[' + i + '][definition]" placeholder="Definition">' + $(this).find('textarea').val() + '</textarea>')
			   .append('<a class="close" title="Delete this definition">&times;</a>');

			$(this).remove();
			div.appendTo('#definitions');

			$(".wysiwyg").cleditor({
		        controls: "bold italic underline | bullets numbering | alignleft center alignright",
		    });

			i++;
		});

		return false;
	});
});
</script>