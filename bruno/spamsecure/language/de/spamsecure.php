<?php
/**
*
* @package phpBB Extension - Spamsecure from 69bruno
* @copyright (c) 2021 (cruiser-lounge.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'SPAMSECURE_INVALID_CHARS_WARNING'				=> 'Die Nachricht enthält unerlaubte Zeichen!',
	'SPAMSECURE_INVALID_REGEX_WARNING'				=> 'In der Nachricht sind keine Links erlaubt!',
]);
