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
		$this->kyrill	=	'а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,ь,э,ю,я,';
		$this->chinese	=	'阿,玻,疵,的,鹅,佛,哥,哈,衣,基,科,勒,摸,呢,喔,坡,七,日,丝,特,乌,维,西,一,资,迂,';
		$this->hindi	=	'अ,आ,इ,ई,उ,ऊ,ए,ऐ,ओ,औ,अं,अः,ऋ,ॠा,ि,ी,ु,ू,ृ,ॄ,ॅ,ॆ,े,ै,ॉ,ॊ,ो,ौ,क,ख,ग,घ,ङ,च,छ,ज,झ,ञ,ट,ठ,ड,ढ,ण,त,थ,द,ध,न,प,फ,ब,भ,म,य,र,ल,व,श,ष,स,ह,क्ष,त्र,ज्ञ,०,१,२,३,४,५,६,७,८,९,';
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
		$lang_set_ext 	= $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name'  => 'bruno/spamsecure',
			'lang_set'  => 'spamsecure',
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
		$warn_msg = [];
		$message = $event['message'];

		if ($this->auth->acl_get('u_view_spamsecure_invalid_chars'))
		{
			$searchchars = ($this->config['spamsecure_invalid_chars_lang_kyrill'] 	== 1 ? $this->kyrill : '')
						 . ($this->config['spamsecure_invalid_chars_lang_chinese'] 	== 1 ? $this->chinese : '' )
						 . ($this->config['spamsecure_invalid_chars_lang_hindi'] 	== 1 ? $this->hindi : '')
						 . ($this->config['spamsecure_invalid_chars_lang_custom'] 	== 1 ? $this->config['spamsecure_invalid_chars_input_custom'] : '');
			$counter = 0;
			$checkarray = explode(",",$searchchars);
			$acp_counter = $this->config['spamsecure_invalid_chars_counter'];
			$matches = [];

			foreach ($checkarray as $checkchar)
			{
				if (!empty($this->config['spamsecure_invalid_chars_input_custom']) && strpos($message, $checkchar, 0) !== false)
				{
					$counter++;
					$matches[] = $checkchar;
				}
			}
			if ($counter <= $acp_counter && $counter  >= 1)
			{
				if ($this->config['spamsecure_invalid_chars_counter_switch'] == 1)
				{
					$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter . $this->language->lang('SPAMSECURE_INVALID_CHARS_INFO') . implode(",",$matches));
				}
				else
				{
					$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter);
				}
			}
			else if ($counter > $acp_counter)
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter);
			}
		}

		if ($this->auth->acl_get('u_view_spamsecure_invalid_regex'))
		{
			$searchstrg = $this->config['spamsecure_invalid_regex'];

			if (!empty($this->config['spamsecure_invalid_regex']) && preg_match($searchstrg, $message))
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_REGEX_WARNING'));
			}
		}

		if ($warn_msg)
		{
			$event['warn_msg'] = $warn_msg;
		}

	}


	public function show_spamsecure_original_phpbb_contact_form($event)
	{
		$warn_msg = [];
		$message = $event['body'];

		if ($this->auth->acl_get('u_view_spamsecure_invalid_chars'))
		{

			$searchchars = ($this->config['spamsecure_invalid_chars_lang_kyrill'] 	== 1 ? $this->kyrill : '')
						 . ($this->config['spamsecure_invalid_chars_lang_chinese'] 	== 1 ? $this->chinese : '' )
						 . ($this->config['spamsecure_invalid_chars_lang_hindi'] 	== 1 ? $this->hindi : '')
						 . ($this->config['spamsecure_invalid_chars_lang_custom'] 	== 1 ? $this->config['spamsecure_invalid_chars_input_custom'] : '');
			$counter = 0;
			$checkarray = explode(",",$searchchars);
			$acp_counter = $this->config['spamsecure_invalid_chars_counter'];
			$matches = [];

			foreach ($checkarray as $checkchar)
			{
				if (!empty($this->config['spamsecure_invalid_chars_input_custom']) && strpos($message, $checkchar, 0) !== false)
				{
					$counter++;
					$matches[] = $checkchar;
				}
			}

			if ($counter <= $acp_counter && $counter  >= 1)
			{
				if ($this->config['spamsecure_invalid_chars_counter_switch'] == 1)
				{
					$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter . $this->language->lang('SPAMSECURE_INVALID_CHARS_INFO') . implode(",",$matches));
				}
				else
				{
					$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter);
				}
			}
			else if ($counter > $acp_counter)
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter);
			}
		}

		if ($this->auth->acl_get('u_view_spamsecure_invalid_regex'))
		{
			$searchstrg = $this->config['spamsecure_invalid_regex'];

			if (!empty($this->config['spamsecure_invalid_regex']) && preg_match($searchstrg, $message))
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
		$warn_msg = [];
		$message = $event['data']['contact_message'];

		if ($this->auth->acl_get('u_view_spamsecure_invalid_chars'))
		{

			$searchchars = ($this->config['spamsecure_invalid_chars_lang_kyrill'] 	== 1 ? $this->kyrill : '')
						 . ($this->config['spamsecure_invalid_chars_lang_chinese'] 	== 1 ? $this->chinese : '' )
						 . ($this->config['spamsecure_invalid_chars_lang_hindi'] 	== 1 ? $this->hindi : '')
						 . ($this->config['spamsecure_invalid_chars_lang_custom'] 	== 1 ? $this->config['spamsecure_invalid_chars_input_custom'] : '');
			$counter = 0;
			$checkarray = explode(",",$searchchars);
			$acp_counter = $this->config['spamsecure_invalid_chars_counter'];
			$matches = [];

			foreach ($checkarray as $checkchar)
			{
				if (!empty($this->config['spamsecure_invalid_chars_input_custom']) && strpos($message, $checkchar, 0) !== false)
				{
					$counter++;
					$matches[] = $checkchar;
				}
			}

			if ($counter <= $acp_counter && $counter  >= 1)
			{
				if ($this->config['spamsecure_invalid_chars_counter_switch'] == 1)
				{
					$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter . $this->language->lang('SPAMSECURE_INVALID_CHARS_INFO') . implode(",",$matches));
				}
				else
				{
					$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter);
				}
			}
			else if ($counter > $acp_counter)
			{
				$warn_msg[] = ($this->language->lang('SPAMSECURE_INVALID_CHARS_WARNING') . $counter);
			}
		}

		if ($this->auth->acl_get('u_view_spamsecure_invalid_regex'))
		{
			$searchstrg = $this->config['spamsecure_invalid_regex'];

			if (!empty($this->config['spamsecure_invalid_regex']) && preg_match($searchstrg, $message))
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
