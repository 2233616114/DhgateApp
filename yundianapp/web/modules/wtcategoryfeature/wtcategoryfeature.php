<?php
/**
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;
class WtCategoryFeature extends Module
{

	private $html;
	private $config;
	private $settings_default;
	private $selected_category;
	protected static $cache_filter_categories;
	private $wt_cat_feature_config;
	public function __construct()
	{
		$this->name = 'wtcategoryfeature';
		$this->tab = 'front_office_features';
		$this->version = '1.1.0';
		$this->author = 'waterthemes';
		$this->need_instance = 0;
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->l('WT Category Feature');
		$this->description = $this->l('Show category feature');
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->wt_cat_feature_config = 'WT_CONFIG_CATEGORY_FEATURE';
		$this->settings_default = array(
			'used_slider' => 1,
			'showimg' => 1,
			'showsub' => 1,
			'numbersub' => 5,
			'category' => array(3,4,5,6,8)
		);
		$this->getInitSettings();
	}
	public function getInitSettings()
	{
		$this->config = (array)Tools::jsonDecode(Configuration::get($this->wt_cat_feature_config));
		$this->config = (object)array_merge((array)$this->settings_default, $this->config);
		$this->selected_category = $this->config->category;
	}
	public function install()
	{
		$this->_clearCache('wtcategoryfeature.tpl');
		if (!parent::install() || !$this->registerHook('displayHeader') || !$this->registerHook('categoryUpdate') || !$this->registerHook('displayHome'))
			return false;
		if (!Configuration::hasKey($this->wt_cat_feature_config))
			Configuration::updateValue($this->wt_cat_feature_config, '');
		return true;
	}
	public function uninstall()
	{
		$this->_clearCache('wtcategoryfeature.tpl');
		if (parent::uninstall() == false || !Configuration::deleteByName($this->wt_cat_feature_config))
			return false;
		return true;
	}
	
	public function getContent()
	{
		$this->postProcess();
		$this->initForm().$this->_displayHelp().$this->_displayAdvertising();
		return $this->html;
	}
		
private function _displayHelp()
{
		$this->html .= '
		<br/>
	 	<fieldset>
			<legend><img src="'.$this->_path.'views/img/help.png" alt="" title="" /> '.$this->l('Help').'</legend>		
			For customizations or assistance, please contact: <strong><a   target="_blank" href="http://waterthemes.com/contact-us">http://waterthemes.com/contact-us</a></strong>
			<br>
			<a href="http://waterthemes.com/" alt="waterthemes" title="waterthemes" target="_blank">http://waterthemes.com/</a>
		</fieldset>';
		return $this->html;
}
public function _displayAdvertising()
{
		$this->html .= '
		<br/>
		<fieldset>
			<legend><img src="'.$this->_path.'views/img/more.png" alt="" title="" /> '.$this->l('More Themes & Modules').'</legend>	
			<iframe src="http://waterthemes.com/advertising/prestashop_advertising.html" width="100%" height="420px;" border="0" style="border:none;"></iframe>
			</fieldset>';
		return $this->html;
}
	public function checkValidate()
	{
		$configs = Tools::getValue('config');
		$errors = array();
		foreach ($configs as $key_option => $value_option)
		{
			$pos = strpos($key_option, 'number_');
			if ($pos !== false)
				if (isset($value_option) && (!$value_option || $value_option <= 0 || !Validate::isInt($value_option)))
					$errors[] = $this->l('An invalid '.$key_option.' has been specified.');
		}
		return $errors;
	}
	public function postProcess()
	{
		if (Tools::isSubmit('saveConfig'))
		{
			$errors = $this->checkValidate();
			if (isset($errors) && count($errors))
				$this->html .= $this->displayError(implode('<br />', $errors));
			else
			{
				$config = Tools::jsonEncode(Tools::getValue('config'));
				if ($config)
				{
					Configuration::updateValue($this->wt_cat_feature_config, $config);
					$this->_clearCache('wtcategoryfeature.tpl');
					Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&successConfirmation');
				}
			}
		}
		else if (Tools::isSubmit('successConfirmation'))
			$this->html .= $this->displayConfirmation($this->l('Your settings have been updated.'));
	}
	public function initForm()
	{
		$fields_form = array();
		include(dirname(__FILE__).'/class/settings.php');
		$this->fields_form[0]['form'] = $fields_form;
		$helper = new HelperForm();
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->identifier = $this->identifier;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		foreach (Language::getLanguages(false) as $lang)
			$helper->languages[] = array(
				'id_lang' => $lang['id_lang'],
				'iso_code' => $lang['iso_code'],
				'name' => $lang['name'],
				'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
			);
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name;
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->toolbar_scroll = true;
		$helper->title = $this->displayName;
		$helper->submit_action = 'saveConfig';
		if (Tools::getIsset('config'))
			$this->config = (object)array_merge(Tools::getValue('config'), (array)$this->config);
		foreach ($this->fields_form[0]['form']['input'] as $field)
		{
			$option = str_replace('config[', '', $field['name']);
			$option = str_replace(']', '', $option);
			$helper->fields_value[''.$field['name'].''] = (isset($this->config->$option) ? $this->config->$option : '');
		}
		$this->html .= $helper->generateForm($this->fields_form);
	}
	public function callGetCategoryList($id_lang)
	{
		if (!isset($this->config->category) || empty($this->config->category))
			return;
		$categories = array();
		foreach ($this->config->category as $key => $id_cat)
		{
			$category = new Category($id_cat, $id_lang);
			$categories[$key]['category'] = $category;
			$categories[$key]['sub_cat'] = $category->getSubCategories($id_lang);
		}
		return $categories;
	}
	public function hookDisplayHeader()
	{
		
		if ($this->context->smarty->tpl_vars['page_name']->value == 'index')
		{
			$this->context->controller->addCSS(($this->_path).'views/css/'.$this->name.'.css', 'all');
			$this->context->controller->addJs($this->_path.'views/js/jquery.carouFredSel-6.1.0.js');
			$this->context->controller->addCss($this->_path.'views/css/jquery.carouFredSel-6.1.0-packed.css');
			$this->context->controller->addJs($this->_path.'views/js/jquery-ui-tabs.min.js');
			$this->context->controller->addJs($this->_path.'views/js/getwidthbrowser.js');
		}
	}
	
	public function hookDisplayHome()
	{
		if (!$this->isCached('wtcategoryfeature.tpl', $this->getCacheId('wtcategoryfeature')))
		{
			$id_lang = (int)$this->context->language->id;
			$categories = $this->callGetCategoryList($id_lang);
			$this->context->smarty->assign(array(
				'wt_categories' => $categories,
				'wtconfig' => $this->config
			));
		}
		return $this->display(__FILE__, 'wtcategoryfeature.tpl', $this->getCacheId('wtcategoryfeature'));
	}
	public function hookDisplayTopHome()
	{
		return $this->hookDisplayHome();
	}
	public function hookDisplayBottomHome()
	{
		return $this->hookDisplayHome();
	}
	public function hookCategoryUpdate()
	{
		$this->_clearCache('wtcategoryfeature.tpl');
	}
}