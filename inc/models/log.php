<?php

/*
@package Tasks
@since 0.1
@version 1.0

*/

class task_log extends tzn_model
{

	function __construct() {
		
		parent::__construct(
			'log',
			array(
				'log_date'			=> 'DTM',
				'user'				=> 'OBJ',
				'action_code'		=> 'STR',
				'item_id'	 		=> 'NUM',
				'project_id'		=> 'NUM',
				'comment_id'		=> 'NUM',
				'info'				=> 'STR',
				'hidden'			=> 'BOL'
			), array(
				'log_date','user_id'
			)
		);
	}

	public function check() {
		if (empty($this->data['log_date'])) {
			$this->set('log_date','NOW');
		}
		return (strlen($this->data['action_code']) > 0 && !empty($this->data['user']->id))?true:false;
	}
	
	public function get_info() {
		$info_raw = preg_split('/,/', $this->data['info']);
		$info_cooked = array(
				'user_id' 		=> __('assignee', 'tasks'),
				'description' 	=> __('description', 'tasks'),
				'deadline' 		=> __('deadline', 'tasks'),
				'priority' 		=> __('priority', 'tasks'),
				'title' 		=> __('title', 'tasks'),
				'project' 		=> __('project', 'tasks'),
		);
		$info = array();
		foreach ($info_raw as $key) {
			if (preg_match('/(\d+) file\(s\)/', $key, $match)) {
				$info[] = sprintf(_n('1 file', '%d files', $match[1], 'tasks'), $match[1]);  
			} else {
				$info[] = isset($info_cooked[$key]) ? $info_cooked[$key] : "[$key]";					
			}
		}
		return implode(', ', $info);
	}
	
	/**
	 * list options for filters
	 */
	public static function get_option_list() {
		return array(
    		'tasks' 	=> __('Tasks', 'tasks'),
    		'projects'	=> __('Projects', 'tasks'),
    		'comments' 	=> __('Comments', 'tasks')
    	);
	}
	
	/**
	 * filter select
	 */
	public static function list_select($name, $selected='', $xtra='class="tzn_option_select"') {
		return tzn_tools::form_select($name, self::get_option_list(), $selected, $xtra);
    }
    
    /**
     * filter links
     */
    public static function list_links($url, $name, $current) {
	    return  tzn_tools::form_links($url, $name, array('all' => _x('All', 'updates', 'tasks')), $current)
	    		.tzn_tools::form_links($url, $name, self::get_option_list(), $current);
    }	
}