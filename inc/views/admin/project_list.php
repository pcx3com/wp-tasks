<div class="wrap">
	<?php // screen_icon('edit-pages'); ?>
	<img src="<?php echo plugins_url('/img/logo.32.png', TASK_ROOT_FILE); ?>" class="icon32" style="background:none"/>
	<h2>
		<?php
		_e('Projects','tasks'); 
		if ($this->is_manager) {	
			?>
			<a href="<?php echo esc_url(add_query_arg('id','new',$this->linkadmin)); ?>" class="add-new-h2">
				<?php _e('Add New', 'tasks'); ?>
			</a>
			<?php
		}
		?>
	</h2>
	<ul class="task_subsubsub">
		<li class="all">
			<a href="<?php echo esc_url(add_query_arg('filter','all',$this->linkadmin)); ?>"<?php if ($this->filter == 'all') echo ' class="current"'; ?>>
				<?php _ex('All', 'projects', 'tasks'); ?>
			</a>
		</li>
		<?php
		if ($this->is_manager) {
			?>
			<li class="draft">
				<a href="<?php echo esc_url(add_query_arg('filter','draft',$this->linkadmin)); ?>"<?php if ($this->filter == 'draft') echo ' class="current"'; ?>>
					<?php _ex('Draft', 'many projects', 'tasks'); ?>
				</a>
			</li>
			<?php
		}
		?>
		<li class="opened">
			<a href="<?php echo esc_url(add_query_arg('filter','20',$this->linkadmin)); ?>"<?php if ($this->filter == '20') echo ' class="current"'; ?>>
				<?php _ex('In Progress', 'many projects', 'tasks'); ?>
			</a>
		</li>
		<li class="suspended">
			<a href="<?php echo esc_url(add_query_arg('filter','30',$this->linkadmin)); ?>"<?php if ($this->filter == '30') echo ' class="current"'; ?>>
				<?php _ex('Suspended', 'many projects', 'tasks'); ?>
			</a>
		</li>
		<li class="closed">
			<a href="<?php echo esc_url(add_query_arg('filter','60',$this->linkadmin)); ?>"<?php if ($this->filter == '60') echo ' class="current"'; ?>>
				<?php _ex('Closed', 'many projects', 'tasks'); ?>
			</a>
		</li>
		<?php
		if ($this->is_manager) {
			?>
			<li class="archive">
				<a href="<?php echo esc_url(add_query_arg('filter','trash',$this->linkadmin)); ?>"<?php if ($this->filter == 'trash') echo ' class="current"'; ?>>
					<?php _e('Trash', 'tasks'); ?>
				</a>
			</li>
			<?php
		}
		?>
	</ul>	
	<table class="widefat">
		<thead>
			<tr>
				<th style="width:6%">ID</th>
				<th style="width:64%"><?php _e('Name', 'tasks'); ?></th>
				<th style="width:30%"><?php _e('Status', 'tasks'); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th><?php _e('Name', 'tasks'); ?></th>
				<th><?php _e('Status', 'tasks'); ?></th>
			</tr>
		</tfoot>
		<tbody>
		<?php
		if ($this->data->count()) {
			
			while ($this->data->next()) {
			
				$pid = $this->data->get_uid();
				
				$lnkfrt = add_query_arg(array(
					'mode'		=> 'projects',
					'proj'		=> $pid
				), $this->linkfront);
				
				$lnkadm = add_query_arg(array(
					'id' 		=> $pid, 
					'noheader'	=> 'true'
				), $this->linkadmin);
				
				echo '<tr>';
				echo '<td>'.$pid.'</td>';
				echo '<td>';
				if ($this->is_manager) {
					// editor and admin can edit and delete projects
					if ($this->filter == 'trash') {
						// project is in trash
						echo '<strong>'.$this->data->get('name').'</strong>';
						echo '<div class="row-actions">'
							.'<span class="untrash"><a title="'.__('Restore this item from the Trash', 'tasks').'" '
								.'href="'.wp_nonce_url(add_query_arg('action','restore',$lnkadm),'task_project_restore').'">'.__('Restore', 'tasks').'</a> | </span>'
							.'<span class="delete"><a class="submitdelete" title="'.__('Delete this item permanently', 'tasks').'" '
								.'href="'.wp_nonce_url(add_query_arg('action','delete',$lnkadm),'task_project_delete').'" '
								.'onclick="return confirm(\''.esc_attr(__('Really delete this item?', 'tasks')).'\')">'.__('Delete Permanently', 'tasks').'</a></span></div>';
					} else {
						// project is alive
						echo '<a href="'.$lnkadm.'"><strong>'.$this->data->get('name').'</strong></a>';
						echo '<div class="row-actions">'
							.'<span class="edit"><a href="'.esc_url($lnkadm).'" title="'.esc_attr(__('Edit this item', 'tasks')).'">'.__('Edit', 'tasks').'</a> | </span>'
							.'<span class="view"><a href="'.esc_url($lnkfrt).'" title="'.esc_attr(__('View', 'tasks')).'" rel="permalink">'.__('View', 'tasks').'</a></span>'
							.'</div>';
					}
				} else {
					// contributors can list and view projects they are associated with
					echo '<a href="'.$lnkfrt.'"><strong>'.$this->data->get('name').'</strong></a>';
					echo '<div class="row-actions">'
							// .'<span class="edit"><a href="'.$lnkadm.'" title="'.esc_attr(__('Project details', 'tasks')).'">'.__('Project details', 'tasks').'</a> | </span>'
							.'<span class="view"><a href="'.$lnkfrt.'" title="'.esc_attr(__('View', 'tasks')).'" rel="permalink">'.__('View', 'tasks').'</a></span>'
							.'</div>';
				}
				echo '</td>';
				echo '<td>'._x($this->data->get('project_status')->get_status(), 'one project', 'tasks').'</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="3">No project found</td></tr>';
		}
		?>
		</tbody>
	</table>
	<?php
	echo $this->data->pagination_wp_links('admin.php?page=tasks_projects');
	?>
</div>