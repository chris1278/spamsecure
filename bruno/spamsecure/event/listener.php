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
			'core.user_setup'									=>	'load_language_on_setup',
			'core.permissions'									=>	'permissions',
			'core.message_parser_check_message'					=>	'show_spamsecure_message',
			'core.message_admin_form_submit_before'				=>  'show_spamsecure_original_phpbb_contact_form',
			'rmcgirr83.contactadmin.modify_data_and_error' 		=>  'show_spamsecure_rmcgirr83_contactadmin_contact_form',
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
		$permissions['u_view_spamsecure_invalid_chars'] = ['lang' => 'ACL_U_VIEW_SPAMSECURE_INVALID_CHARS', 'cat' => 'misc'];
		$permissions['u_view_spamsecure_invalid_regex'] = ['lang' => 'ACL_U_VIEW_SPAMSECURE_INVALID_REGEX', 'cat' => 'misc'];
		$event['permissions'] = $permissions;
	}

	public function show_spamsecure_message($event)
	{
		$searchchars = $this->config['spamsecure_invalid_chars'];
		$searchstrg = '/(?:' . $this->config['spamsecure_invalid_regex'] . ')/i';
		$warn_msg = [];
		$message = $event['message'];

		if ($this->auth->acl_get('u_view_spamsecure_invalid_chars'))
		{
			if (strpbrk($message, $searchchars))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING'));
			}
		}

		if ($this->auth->acl_get('u_view_spamsecure_invalid_regex'))
		{
			if (preg_match($searchstrg, $message))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_REGEX_WARNING'));
			}
		}

		if (count($warn_msg))
		{
			$event['warn_msg'] = $warn_msg;
		}

	}

	public function show_spamsecure_original_phpbb_contact_form($event)
	{
		$searchchars = $this->config['spamsecure_invalid_chars'];
		$searchstrg = '/(?:' . $this->config['spamsecure_invalid_regex'] . ')/i';
		$warn_msg = [];
		$message = $event['body'];

		if ($this->auth->acl_get('u_view_spamsecure_invalid_chars'))
		{
			if (strpbrk($message, $searchchars))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING'));
			}
		}

		if ($this->auth->acl_get('u_view_spamsecure_invalid_regex'))
		{
			if (preg_match($searchstrg, $message))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_REGEX_WARNING'));
			}
		}

		if (count($warn_msg))
		{
			$event['errors'] = $warn_msg;
		}

	}

	public function show_spamsecure_rmcgirr83_contactadmin_contact_form($event)
	{
		$searchchars = $this->config['spamsecure_invalid_chars'];
		$searchstrg = '/(?:' . $this->config['spamsecure_invalid_regex'] . ')/i';
		$warn_msg = [];
		$message = $event['data']['contact_message'];

		if ($this->auth->acl_get('u_view_spamsecure_invalid_chars'))
		{
			if (strpbrk($message, $searchchars))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING'));
			}
		}

		if ($this->auth->acl_get('u_view_spamsecure_invalid_regex'))
		{
			if (preg_match($searchstrg, $message))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_REGEX_WARNING'));
			}
		}

		if (count($warn_msg))
		{
			$event['error'] = $warn_msg;
		}

	}
}
