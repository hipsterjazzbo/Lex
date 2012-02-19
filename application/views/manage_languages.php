<table class="table table-striped">
	<?php foreach ($languages as $language): ?>
		<tr>
			<td><?= $language['name'] ?></td>
			<td><a class="close" href="<?= site_url('action/delete_language/' . $language['_id']) ?>" title="Delete this language">&times;</a></td>
		</tr>
	<?php endforeach; ?>
</table>

<script>
$(function() {
	$('a.close').bind('click', function() {
		if ( ! confirm('Are you sure you want to delete this language?')) {
			return false;
		}
	});
});
</script>