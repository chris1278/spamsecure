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
	'SPSE_SPAMSECURE_INFO'						=> 'The extension examines contributions and topics created by guests for unauthorized characters and expressions before publication. It can, for example, prevent the use of Cyrillic or Chinese characters or prevent the use of links by entering appropriate expressions. If the test result is negative, the user receives an error message and can revise his posting.',
	'SPSE_SET_TITLE'							=> 'Settings for Spamsecure',
	'SPSE_PERM_TITLE'							=> 'Einstellen der Berechtigungen:',
	'SPSE_PERMISSION_BEFORE'					=> 'With <b>phpbb´s own authorization system</b>, you can use the settings for  ',
	'SPSE_USERS_PERMISSIONS'					=> 'User rights',
	'SPSE_ANDOR'								=> ' and / or ',
	'SPSE_GROUPS_PERMISSIONS'					=> ' group rights ',
	'SPSE_PERMISSION_AFTER'						=> ' under <b>miscellaneous</b> to whom the settings of the <b>„%1$s“</b> extension should be applied.',
	'SPSE_INVALID_CHARS'						=> 'Not allowed characters',
	'SPSE_INVALID_CHARS_EXPLAIN'				=> 'List of all characters that are not wanted. <br> <br> eg. Chinese or Cyrillic characters. <br> <br> The characters are to be entered one after the other, paying attention to upper and lower case.',
	'SPSE_INVALID_REGEX'						=> 'Expressions or strings that are not allowed',
	'SPSE_INVALID_REGEX_EXPLAIN'				=> 'List of prohibited expressions separated by “|”. Upper and lower case is ignored. <br> <br> The input format of the expressions follows the rules of the RegEx reference and must be treated with special care. It is advisable to use the reference to RegEx (en). <br> <br> As an example, if you want to prevent links of any kind from being posted, here is a <br> example: <b> http | ftp | www </b> <br> <br> This prevents links from being written. It is not possible to write http://xxx.de or https://xxx.de or similar combinations as a guest.',
]);
