<?php
/**
 *
 * @package Schedule Topic Lock Extension
 * @copyright (c) 2021 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\schedulelock\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\auth\auth;
use phpbb\language\language;
use david63\schedulelock\controller\main_controller;
use david63\schedulelock\core\functions;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var request */
	protected $request;

	/** @var auth */
	protected $auth;

	/** @var language */
	protected $language;

	/** @var main_controller */
	protected $main_controller;

	/** @var functions */
	protected $functions;

	/** @var array phpBB tables */
	protected $tables;

	/**
	 * Constructor for listener
	 *
	 * @param config         	$config             Config object
	 * @param request			$request			Request object
	 * @param auth 				$auth				Auth object
	 * @param language			$language			Language object
	 * @param main_controller 	$main_controller    Main controller
	 * @param functions			$functions			Functions for the extension
	 * @param array				$tables				phpBB db tables
	 *
	 * @access public
	 */
	public function __construct(config $config, request $request, auth $auth, language $language, main_controller $main_controller, functions $functions, array $tables)
	{
		$this->config			= $config;
		$this->request			= $request;
		$this->auth				= $auth;
		$this->language			= $language;
		$this->main_controller	= $main_controller;
		$this->functions		= $functions;
		$this->tables			= $tables;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.permissions' 							=> 'add_permissions',
			'core.acp_manage_forums_display_form'		=> 'acp_display_forum_form',
			'core.acp_manage_forums_initialise_data'	=> 'initialise_forum_data',
			'core.acp_manage_forums_request_data'		=> 'manage_forum_request',
			'core.posting_modify_template_vars'			=> 'posting_template',
			'core.posting_modify_submit_post_before'	=> 'submit_post',
			'core.posting_modify_message_text'			=> 'modify_post_message',
			'core.submit_post_modify_sql_data'			=> 'modify_sql_data',
			'core.viewtopic_modify_page_title'			=> 'scheduled_lock',
		];
	}

	/**
	 * Add the new permissions
	 *
	 * @param object $event The event object
	 *
	 * @return &event
	 * @access public
	 */
	public function add_permissions($event)
	{
		$permissions							= $event['permissions'];
		$permissions['u_schedule_topic_lock']	= ['lang' => 'ACL_U_SCHEDULE_TOPIC_LOCK', 'cat' => 'post'];
		$event['permissions']					= $permissions;
	}

	/**
	 * Modify the manage forums pages in the ACP by adding additional template data
	 *
	 * @return	$event
	 * @access	public
	 */
	public function acp_display_forum_form($event)
	{
		$this->language->add_lang('forum_schedulelock', $this->functions->get_ext_namespace());

		$row 							= $event['row'];
		$template_data					= $event['template_data'];
		$template_data['SCHEDULE_LOCK']	= ($row['schedule_topic_lock']) ? true : false;
		$event['template_data'] 		= $template_data;
	}

	/**
	 * Initialise the forum data
	 *
	 * @return	$event
	 * @access	public
	 */
	public function initialise_forum_data($event)
	{
		$forum_data 						= $event['forum_data'];
		$forum_data['schedule_topic_lock']	= 0;
		$event['forum_data'] 				= $forum_data;
	}

	/**
	 * Update the form request
	 *
	 * @return	$event
	 * @access	public
	 */
	public function manage_forum_request($event)
	{
		$forum_data 						= $event['forum_data'];
		$forum_data['schedule_topic_lock']	= $this->request->variable('schedule_topic_lock', 0);
		$event['forum_data'] 				= $forum_data;
	}

	/**
	 * Add the required variables to the posting template
	 *
	 * @param object $event The event object
	 * @return $event
	 * @access public
	 */
	public function posting_template($event)
	{
		$post_data	= $event['post_data'];
		$mode		= $event['mode'];

		// Do we have the credentials for this forum/topic
		if (($mode == 'post' || ($mode == 'edit' && $event['post_id'] == $post_data['topic_first_post_id'])) && ($this->config['schedulelock_all_forums'] || $post_data['schedule_topic_lock']) && $this->auth->acl_get('u_schedule_topic_lock'))
		{
			$page_data = $event['page_data'];

			// Add the language file
			$this->language->add_lang('posting_common', $this->functions->get_ext_namespace());

			if ($mode == 'edit' && $post_data['topic_schedule_lock_time'] > 0)
			{
				$lock_checked	= ' checked="checked"';
				$lock_time		= date('d-m-Y H:i', $post_data['topic_schedule_lock_time']);
			}
			else
			{
				$lock_checked	= '';
				$lock_time		= date('d-m-Y H:i', time());
			}

			$page_data['S_SCHEDULE_LOCK'] 		= true;
			$page_data['SCHEDULE_LOCK_CHECKED']	= $lock_checked;
			$page_data['SCHEDULE_LOCK_TIME'] 	= $lock_time;
			$page_data['SL_NAMESPACE'] 			= $this->functions->get_ext_namespace('twig');
			$page_data['RTL_LANGUAGE']			= ($this->language->lang('DIRECTION') == 'rtl') ? true : false;

			$event['page_data'] = $page_data;
		}
	}

	/**
	 * Update the submit post with the scheduled time
	 *
	 * @param object $event The event object
	 * @return $event
	 * @access public
	 */
	public function submit_post($event)
	{
		$data 								= $event['data'];
		$post_data							= $event['post_data'];
		$data['topic_schedule_lock_time']	= $post_data['schedule_lock_time'];
		$event['data'] 						= $data;
	}

	/**
	 * Add the scheduled time to the post message
	 *
	 * @param object $event The event object
	 * @return $event
	 * @access public
	 */
	public function modify_post_message($event)
	{
		$post_data 							= $event['post_data'];
		$post_data['schedule_lock_time']	= (isset($_POST['schedule_lock'])) ? strtotime($this->request->variable('schedule_lock_time', '')) : 0;
		$event['post_data'] 				= $post_data;
	}

	/**
	 * Add the scheduled time to the sql for database update
	 *
	 * @param object $event The event object
	 * @return $event
	 * @access public
	 */
	public function modify_sql_data($event)
	{
		$data 																	= $event['data'];
		$sql_data																= $event['sql_data'];
		$sql_data[$this->tables['topics']]['sql']['topic_schedule_lock_time']	= $data['topic_schedule_lock_time'];
		$event['sql_data'] 														= $sql_data;
	}

	/**
	 * Process the Schedule Lock Message
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function scheduled_lock($event)
	{
		$this->main_controller->scheduled_lock($event);
	}
}
