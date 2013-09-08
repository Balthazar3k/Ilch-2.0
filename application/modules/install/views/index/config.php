<?php
$errors = $this->get('errors');
?>
<div class="control-group">
	<label for="type" class="control-label">
		<?php echo $this->trans('cmsType'); ?>:
	</label>
	<div class="controls">
		<select name="cmsType">
			<option value="private">Private</option>
			<option value="clan">Clan</option>
		</select>
	</div>
</div>
<hr />
<div class="control-group <?php if(!empty($errors['adminName'])){ echo 'error'; }; ?>">
	<label for="adminName" class="control-label">
		<?php echo $this->trans('adminName'); ?>:
	</label>
	<div class="controls">
		<input value="<?php if($this->get('adminName') != ''){ echo $this->get('adminName'); } ?>"
			   type="text"
			   name="adminName"
			   id="adminName" />
		<?php
			if(!empty($errors['adminName']))
			{
				echo '<span class="help-inline">'.$this->trans($errors['adminName']).'</span>';
			}
		?>
	</div>
</div>
<div class="control-group <?php if(!empty($errors['adminPassword'])){ echo 'error'; }; ?>">
	<label for="adminPassword" class="control-label">
		<?php echo $this->trans('adminPassword'); ?>:
	</label>
	<div class="controls">
		<input value="<?php if($this->get('adminPassword') != ''){ echo $this->get('adminPassword'); } ?>"
			   type="password"
			   name="adminPassword"
			   id="adminPassword" />
		<?php
			if(!empty($errors['adminPassword']))
			{
				echo '<span class="help-inline">'.$this->trans($errors['adminPassword']).'</span>';
			}
		?>
	</div>
</div>
<div class="control-group <?php if(!empty($errors['adminPassword2'])){ echo 'error'; }; ?>">
	<label for="adminPassword2" class="control-label">
		<?php echo $this->trans('adminPassword2'); ?>:
	</label>
	<div class="controls">
		<input value="<?php if($this->get('adminPassword2') != ''){ echo $this->get('adminPassword2'); } ?>"
			   type="password"
			   name="adminPassword2"
			   id="adminPassword2" />
		<?php
			if(!empty($errors['adminPassword2']))
			{
				echo '<span class="help-inline">'.$this->trans($errors['adminPassword2']).'</span>';
			}
		?>
	</div>
</div>
<div class="control-group <?php if(!empty($errors['adminEmail'])){ echo 'error'; }; ?>">
	<label for="adminEmail" class="control-label">
		<?php echo $this->trans('adminEmail'); ?>:
	</label>
	<div class="controls">
		<input value="<?php if($this->get('adminEmail') != ''){ echo $this->get('adminEmail'); } ?>"
			   type="text"
			   name="adminEmail"
			   id="adminEmail" />
		<?php
			if(!empty($errors['adminEmail']))
			{
				echo '<span class="help-inline">'.$this->trans($errors['adminEmail']).'</span>';
			}
		?>
	</div>
</div>