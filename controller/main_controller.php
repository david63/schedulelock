<?php
/**
 *
 * @package Schedule Topic Lock Extension
 * @copyright (c) 2021 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\schedulelock\controller;

/**
 * @ignore
 */
use phpbb\config\config;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use david63\schedulelock\core\functions;

/**
 * Main controller
 */
class main_controller
{
	/** @var config */
	protected $config;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var driver_interface */
	protected $db;

	/** @var language */
	protected $language;

	/** @var functions */
	protected $functions;

	/** @var array phpBB tables */
	protected $tables;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor for listener
	 *
	 * @param config				$config         Config object
	 * @param request				$request		Request object
	 * @param template				$template       Template object
	 * @param user					$user           User object
	 * @param driver_interface		$db             The db connection
	 * @param language				$language       Language object
	 * @param functions				$functions      Functions for the extension
	 * @param array					$tables         phpBB db tables
	 *
	 * @access public
	 */
	public function __construct(config $config, request $request, template $template, user $user, driver_interface $db, language $language, functions $functions, array $tables)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->db			= $db;
		$this->language		= $language;
		$this->functions	= $functions;
		$this->tables		= $tables;
	}

	/**
	 * Controller for schedulelock
	 *
	 * @param string     $name
	 * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	 */
	public function scheduled_lock($event)
	{
		$topic_data 	= $event['topic_data'];
		$scheduled_time	= $topic_data['topic_schedule_lock_time'];

		// Do we need to lock this topic?
		if ($scheduled_time > 0 && time() > $scheduled_time)
		{
			// Add the language file
			$this->language->add_lang('common', $this->functions->get_ext_namespace());

			$sql = 'UPDATE ' . $this->tables['topics'] . '
				SET topic_status = ' . ITEM_LOCKED . '
                WHERE topic_id = ' . (int) $topic_data['topic_id'] . '
                AND topic_moved_id = 0';

			$this->db->sql_query($sql);

			// Set output vars for display in the template
			$this->template->assign_vars([
				'S_MESSAGE_BOTTOM' 	=> $this->config['schedulelock_message_bottom'],
				'S_MESSAGE_TOP' 	=> $this->config['schedulelock_message_top'],
				'S_SCHEDULE_LOCK' 	=> true,
				'SCHEDULE_LOCK'		=> $this->language->lang('SCHEDULE_LOCK', $this->user->format_date($scheduled_time)),
			]);
		}
	}
}
