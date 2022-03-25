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
	'SPSE_SPAMSECURE_INFO'							=> 'Die Extension untersucht von Gästen erstellte Beiträge und Themen vor Veröffentlichung auf unerlaubte Zeichen und Ausdrücke. Sie kann z.B. die Verwendung kyrillischer oder chinesischer Schriftzeichen unterbinden oder durch Eingabe entsprechender Ausdrücke die Verwendung von Links unterbinden. Der Benutzer bekommt bei negativem Prüfergebnis eine Fehlermeldung und kann sein Posting überarbeiten.',
	'SPSE_SET_TITLE'								=> 'Einstellungen für Spamsecure',
	'SPSE_PERM_TITLE'								=> 'Einstellen der Berechtigungen:',
	'SPSE_PERMISSION_BEFORE'						=> 'Mit dem <b>phpbb eigenem Berechtigungssystem</b> kann über die Einstellungen der  ',
	'SPSE_USERS_PERMISSIONS'						=> 'Benutzerrechte',
	'SPSE_ANDOR'									=> ' und bzw. oder den ',
	'SPSE_GROUPS_PERMISSIONS'						=> ' Gruppenrechten ',
	'SPSE_PERMISSION_AFTER'							=> ' unter <b>Diverses</b> eingestellt werden, bei wem die Einstellungen der Extension <b>„%1$s“</b> angewendet werden soll.',
	'SPSE_INVALID_CHARS'							=> 'Nicht erlaubte Zeichen',
	'SPSE_INVALID_CHARS_EXPLAIN'					=> 'Liste aller Zeichen die nicht erwünscht sind.<br><br>zb. Chinesische oder Kyrillische Zeichen.<br><br>Die Zeichen sind unter beachtung von Groß und kleinschreibung direkt hintereinander anzugeben. ',
	'SPSE_INVALID_REGEX'							=> 'Nicht erlaubte Ausdrücke bzw. Strings',
	'SPSE_INVALID_REGEX_EXPLAIN'					=> 'Liste unerlaubter Ausdrücke mit Trennzeichen “|”. Groß- und Kleinschreibung wird ignoriert.<br><br>Das Eingabeformat der Ausdrücke folgt den Regeln der RegEx-Referenz und ist mit besonderer Vorsicht zu behandeln. Es empfielt sich, die Referenz zu RegEx(en) zur Hand zu nehmen.<br><br>Als Beispiel wenn man verhindern will das Links irgendwelcher Art gepostet werden sollen dann hier ein <br>Beispiel:  <b>http|ftp|www</b><br><br>Dies verhindert das links geschrieben werden. Es ist damit nicht möglich als Gast http://xxx.de oder https://xxx.de  oder ähnliche Kombinationen zu schreiben.',
]);
