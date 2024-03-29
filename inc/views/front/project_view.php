<?php
	$this->view_inc('front/nav.php');
?>
<ul id="task_breadcrumb">
	<li><a href="<?php echo esc_url(add_query_arg('mode', 'projects', tzn_tools::baselink())) ?>"><?php _e('All Projects','tasks') ?></a></li>
	<li><?php echo $this->project->html('name'); ?></li>
</ul>
<?php 
if ($this->project->has('description')) {
	echo '<div id="task_proj_desc">'.$this->project->html('description').'</div>'; // already all in HTML, with <p>
}

// list tasks (with filter links)
$this->view_inc('front/list.php');
