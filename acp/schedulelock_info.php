<?php
/**
 *
 * @package Schedule Topic Lock Extension
 * @copyright (c) 2021 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\schedulelock\acp;

class schedulelock_info
{
	public function module()
	{
		return [
			'filename' => '\david63\schedulelock\acp\schedulelock_module',
			'title' => 'SCHEDULE_TOPIC_LOCK',
			'modes' => [
				'main' => ['title' => 'SCHEDULE_TOPIC_LOCK', 'auth' => 'ext_david63/schedulelock && acl_a_board', 'cat' => ['ACP_CAT_USERS']],
			],
		];
	}
}
