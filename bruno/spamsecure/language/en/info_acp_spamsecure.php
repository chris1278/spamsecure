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
	// Information For Versionscheck Metadaten
	'SPSE_LANG_DESC'						=> 'English (GB) ',
	'SPSE_LANG_EXT_VER' 					=> '1.0.0',
	'SPSE_LANG_AUTHOR' 						=> '69bruno',
	'SPSE_CONFIG_DESC' 						=> 'Here you can change the settings for the <b>„%1$s“ (v%2$s)</b> extension.',
	'SPSE_TITLE'							=> 'Spamsecure',
	'SPSE_SETTINGS'							=> 'Settings',
	'SPSE_LANGUAGEPACK_OUTDATED'			=> 'Note: The language pack of this extension is out of date.',
	'SPSE_SETTING_SAVED'					=> 'The settings have been successfully adopted!'
]);
