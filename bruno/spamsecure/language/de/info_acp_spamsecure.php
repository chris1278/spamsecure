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
	'SPSE_LANG_DESC'						=> 'Deutsch (Du) ',
	'SPSE_LANG_EXT_VER' 					=> '1.0.0',
	'SPSE_LANG_AUTHOR' 						=> '69bruno',
	'SPSE_CONFIG_DESC' 						=> 'Hier können die Einstellungen für die Erweiterung „%1$s“ (v%2$s) geändert werden.',
	'SPSE_TITLE'							=> 'Spamsecure',
	'SPSE_SETTINGS'							=> 'Einstellungen',
	'SPSE_LANGUAGEPACK_OUTDATED'			=> 'Hinweis: Das Sprachpaket dieser Erweiterung ist nicht mehr aktuell.',
	'SPSE_UPDATE'							=> 'Die einstellungen wurden erfolgreich übernommen!',
]);
