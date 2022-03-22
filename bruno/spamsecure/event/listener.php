<?php
/**
*
* @package phpBB Extension - Spamsecure from 69bruno
* @copyright (c) 2021 (cruiser-lounge.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bruno\spamsecure\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $user;
	protected $language;
	protected $config;
	protected $auth;

	public function __construct(
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\config\config $config,
		\phpbb\auth\auth $auth
	)
	{
		$this->user 	=	$user;
		$this->language =	$language;
		$this->config   =	$config;
		$this->auth 	=	$auth;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'							=>	'load_language_on_setup',
			'core.permissions'							=>	'permissions',
			'core.message_parser_check_message'			=>	'show_spamsecure',
		];
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'   => 'bruno/spamsecure',
			'lang_set'   => 'spamsecure',
		];

		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_view_spamsecure'] = ['lang' => 'ACL_U_VIEW_SPAMSECURE', 'cat' => 'misc'];
		$event['permissions'] = $permissions;
	}

	public function show_spamsecure($event)
	{
		if ($this->auth->acl_get('u_view_spamsecure'))
		{
			$searchchars = $this->config['spamsecure_invalid_chars'];
			$searchstrg = '/(?:' . $this->config['spamsecure_invalid_regex'] . ')/i';
			$warn_msg = [];
			$message = $event['message'];

			if (strpbrk($message, $searchchars))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING'));
			}
			if (preg_match($searchstrg, $message))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_REGEX_WARNING'));
			}
			if (count($warn_msg))
			{
				$event['warn_msg'] = $warn_msg;
			}
		}
	}
}
