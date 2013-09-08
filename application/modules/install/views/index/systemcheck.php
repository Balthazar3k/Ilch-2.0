<table class="table table-hover">
	<thead>
		<tr>
			<th></th>
			<th><?php echo $this->trans('required'); ?></th>
			<th><?php echo $this->trans('available'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo $this->trans('phpVersion'); ?></td>
			<td class="text-success">>= 5.3</td>
			<td><?php echo $this->get('phpVersion'); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->trans('writable').' "config.php"' ?></td>
			<td class="text-success">writable</td>
			<td>
				<?php
					if(is_writable(CONFIG_PATH.'/config.php'))
					{
						echo '<span class="text-success">writable</span>';
					}
					else
					{
						echo '<span class="text-error">not writable</span>';
					}
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->trans('writable').' ".htaccess"' ?></td>
			<td class="text-success">writable</td>
			<td>
				<?php
					if(is_writable(APPLICATION_PATH.'/../.htaccess'))
					{
						echo '<span class="text-success">writable</span>';
					}
					else
					{
						echo '<span class="text-error">not writable</span>';
					}
				?>
			</td>
		</tr>
	</tbody>
</table>