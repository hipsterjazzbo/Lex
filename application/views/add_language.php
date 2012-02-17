<form method="post" action="<?= site_url('action/add_language') ?>">
	<fieldset>
		<legend>Add a Language</legend>

		<label>Name</label>
		<input type="text" class="input-xlarge" name="name" placeholder="English" autofocus>

		<label>Phoneme order</label>
		<input type="text" class="input-xlarge" name="phoneme_order" placeholder="a,b,c,d,e,f,g...">

		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Save language</button>
		</div>
	</fieldset>
</form>