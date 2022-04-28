<?php
/**
*
* @package phpBB Extension - Spamsecure from 69bruno
* @copyright (c) 2021 (cruiser-lounge.de)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bruno\spamsecure\controller;

class acp_controller
{
	protected $extension_manager;
	protected $path_helper;
	protected $config;
	protected $language;
	protected $request;
	protected $template;
	protected $user;
	protected $root_path;
	protected $php_ext;
	protected $u_action;

	public function __construct(
		\phpbb\extension\manager $ext_manager,
		\phpbb\path_helper $path_helper,
		\phpbb\config\config $config,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$root_path,
		$php_ext
	)
	{
		$this->md_manager 			= $ext_manager->create_extension_metadata_manager('bruno/spamsecure');
		$this->admin_path 			= $path_helper->get_phpbb_root_path() . $path_helper->get_adm_relative_path();
		$this->config				= $config;
		$this->language				= $language;
		$this->request				= $request;
		$this->template				= $template;
		$this->user					= $user;
		$this->php_ext				= $php_ext;
		$this->root_path			= $root_path;
	}

	public function display_options()
	{
		$ext_display_ver 			= $this->md_manager->get_metadata('version');
		$ext_lang_min_ver 			= $this->md_manager->get_metadata()['extra']['lang-min-ver'];
		$ext_display_name 			= $this->md_manager->get_metadata('display-name');
		$ext_display_ver 			= $this->md_manager->get_metadata('version');
		$lang_ver 					= ($this->language->lang('SPSE_LANG_EXT_VER') !== 'SPSE_LANG_EXT_VER') ? $this->language->lang('SPSE_LANG_EXT_VER') : '0.0.0';
		$this->language->add_lang('acp_spamsecure', 'bruno/spamsecure');
		$notes 						= '';
		add_form_key('bruno_spamsecure_acp');
		$errors = [];

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('bruno_spamsecure_acp'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			if (empty($errors))
			{
				$this->config->set('spamsecure_invalid_chars', $this->request->variable('spamsecure_invalid_chars', '', true));
				$this->config->set('spamsecure_invalid_regex', $this->request->variable('spamsecure_invalid_regex', '', true));
				trigger_error($this->language->lang('SPSE_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		if (!phpbb_version_compare($lang_ver, $ext_lang_min_ver, '>='))
		{
			$this->add_note($notes, $this->language->lang('SPSE_LANGUAGEPACK_OUTDATED'));
		}
		$this->template->assign_vars([
			'SPSE_S_ERROR'								=> $s_errors,
			'SPSE_ERROR_MSG'							=> $s_errors ? implode('<br />', $errors) : '',
			'SPSE_NOTES'								=> $notes,
			'SPSE_EXT_NAME'								=> $ext_display_name,
			'SPSE_EXT_VER'								=> $ext_display_ver,
			'SPSE_INVALID_CHARS'						=> $this->config['spamsecure_invalid_chars'],
			'SPSE_INVALID_REGEX'						=> $this->config['spamsecure_invalid_regex'],
			'U_USER_PERMISSIONS'						=> append_sid("{$this->admin_path}index.$this->php_ext" ,'i=permissions&amp;mode=setting_user_global'),
			'U_GROUP_PERMISSIONS'						=> append_sid("{$this->admin_path}index.$this->php_ext" ,'i=permissions&amp;mode=setting_group_global'),
			'U_ACTION'									=> $this->u_action,
		]);
	}

	private function add_note(string &$notes, $msg)
	{
		$notes .= (($notes != '') ? "\n" : "") . sprintf('<p>%s</p>', $msg);

	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
