<form class="form-horizontal" method="POST" action="">
	<legend>
	<?php
		if($this->get('page') != '')
		{
			echo $this->trans('editPage'); 
		}
		else
		{
			echo $this->trans('addPage'); 
		}
	?>
	</legend>
	<div class="control-group">
		<label for="pageTitleInput" class="control-label">
			<?php echo $this->trans('pageTitle'); ?>:
		</label>
		<div class="controls">
			<input type="text"
				   name="pageTitle"
				   id="pageTitleInput"
				   value="<?php if($this->get('page') != ''){ echo $this->get('page')->getTitle(); } ?>" />
		</div>
	</div>
	<div class="control-group">
		<textarea name="pageContent"><?php if($this->get('page') != ''){ echo $this->get('page')->getContent(); } ?></textarea>
	</div>
	<div class="control-group">
		<label for="pageLanguageInput" class="control-label">
			<?php echo $this->trans('pageLanguage'); ?>:
		</label>
		<div class="controls">
			<select name="pageLanguage" id="pageLanguageInput">
				<?php
				foreach($this->get('languages') as $key => $value)
				{
					$selected = '';

					if($this->getRequest()->getParam('locale') != '')
					{
						if($this->getRequest()->getParam('locale') == $key)
						{
							$selected = 'selected="selected"';
						}
					}
					elseif($this->getTranslator()->getLocale() == $key)
					{
						$selected = 'selected="selected"';
					}

					echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="control-group">
		<label for="pagePerma" class="control-label">
			<?php echo $this->trans('permaLink'); ?>:
		</label>
		<div class="controls">
			<?php echo $this->url(); ?>/index.php/<input type="text"
				   name="pagePerma"
				   id="pagePerma"
				   value="<?php if($this->get('page') != ''){ echo $this->get('page')->getPerma(); } ?>" />
		</div>
	</div>
	<div class="content_savebox">
		<button type="submit" name="save" class="btn">
			<?php
			if($this->get('page') != '')
			{
				echo $this->trans('editButton');
			}
			else
			{
				echo $this->trans('addButton');
			}
			?>
		</button>
	</div>
</form>
<script type="text/javascript" src="<?php echo $this->staticUrl('js/tinymce/tinymce.min.js') ?>"></script>
<script>
<?php
$pageID = '';

if($this->get('page') != '')
{
	$pageID = $this->get('page')->getId();
}
?>
$('#pageTitleInput').change
(
	function()
	{
		$('#pagePerma').val
		(
			$(this).val()
			.toLowerCase()
			.replace(/ /g,'-')+'.html'
		);
	}
);	

$('#pageLanguageInput').change
(
	this,
	function()
	{
		top.location.href = '<?php echo $this->url(array('id' => $pageID)); ?>/locale/'+$(this).val();
	}
);

tinymce.init
(
	{
		height: 400,
		selector: "textarea"
	}
);
</script>