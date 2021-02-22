<?php
/**
 *
 * @package Schedule Topic Lock Extension
 * @copyright (c) 2021 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\schedulelock\migrations;

class version_3_3_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [
			['config.add', ['schedulelock_all_forums', '0']],
			['config.add', ['schedulelock_message_bottom', '0']],
			['config.add', ['schedulelock_message_top', '0']],

			// Add the new permission
			['permission.add', ['u_schedule_topic_lock', true]],

			// Add the ACP module
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'SCHEDULE_TOPIC_LOCK']],

			['module.add', [
				'acp', 'SCHEDULE_TOPIC_LOCK', [
					'module_basename' => '\david63\schedulelock\acp\schedulelock_module',
					'modes' => ['main'],
				],
			]],
		];
	}

	/**
 	* @return array Array update data
 	* @access public
 	*/
	public function update_schema()
	{
		// Add new column to topics table
		return [
			'add_columns' => [
				$this->table_prefix . 'topics' => [
					'topic_schedule_lock_time' => ['INT:', 0],
				],

				$this->table_prefix . 'forums' => [
					'schedule_topic_lock' => ['BOOL', 0],
				],
			],
		];
	}

	/**
 	* Drop the schemas from the database
 	*
 	* @return array Array of table schema
 	* @access public
 	*/
	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'topics' => [
					'topic_schedule_lock_time',
				],

				$this->table_prefix . 'forums' => [
					'schedule_topic_lock',
				],
			],
		];
	}
}
