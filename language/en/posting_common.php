<?php
/**
 *
 * @package Schedule Topic Lock Extension
 * @copyright (c) 2021 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'CLICK_SELECT'					=> 'Click in textbox to select ',
	'CURRENT_TEXT_DATE'				=> 'Today',

	'HOUR_TEXT'						=> 'Hour',

	'MINUTE_TEXT'					=> 'Minute',

	'NEXT_TEXT'						=> 'Next>',

	'PREV_TEXT'						=> '<Prev',

	'SCHEDULE_LOCK'					=> 'Schedule lock',
	'SCHEDULE_LOCK_EXPLAIN'			=> 'Select if topic is to have a scheduled lock, descelect to remove scheduled lock time.',
	'SCHEDULE_LOCK_TIME'			=> 'Schedule lock time',
	'SCHEDULE_LOCK_TIME_EXPLAIN'	=> 'Use the date picker to select the date and time that this topic is to be locked.',

	'TIME_TEXT'						=> 'Time',

	// Translators note: retain the format of [" "] as they are creating JSON compatible arrays
	'DAY_NAMES_MIN'					=> '["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]',
	'MONTH_NAMES' 					=> '["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]',
]);
