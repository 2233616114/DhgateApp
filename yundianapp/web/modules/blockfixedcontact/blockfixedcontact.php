<?php
if (!defined('_PS_VERSION_'))
  exit;
  
class Blockfixedcontact extends Module
{
	public function __construct()
	{
		$this->name = 'blockfixedcontact';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Jacky Chen';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Fixed Contact information block');
		$this->description = $this->l('This module will allow you to display your contact information in a customizable block.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		if (!Configuration::get('BLOCKFIXEDCONTACT_EMAIL'))
		  $this->warning = $this->l('No email information provided');
        if (!Configuration::get('BLOCKFIXEDCONTACT_SKYPE'))
            $this->warning = $this->l('No skype information provided');
	}

   
	public function getContent()
	{
		$output = null;
	 
		if (Tools::isSubmit('submit'.$this->name))
		{
//			$block_fixedcontact_skype = strval(Tools::getValue('BLOCKFIXEDCONTACT_SKYPE'));
//			if (!$block_fixedcontact_skype
//			  || empty($block_fixedcontact_skype)
//			  || !Validate::isGenericName($block_fixedcontact_skype))
//				$output .= $this->displayError($this->l('Invalid skype address'));
//			else
//			{
//				Configuration::updateValue('BLOCKFIXEDCONTACT_SKYPE', $block_fixedcontact_skype);
//				$output .= $this->displayConfirmation($this->l('Settings updated'));
//			}
            Configuration::updateValue('BLOCKFIXEDCONTACT_EMAIL', strval(Tools::getValue('BLOCKFIXEDCONTACT_EMAIL')));
            Configuration::updateValue('BLOCKFIXEDCONTACT_SKYPE', strval(Tools::getValue('BLOCKFIXEDCONTACT_SKYPE')));
            $output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}
	
	
	public function displayForm()
	{
		// Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		 
		// Init Fields form array
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Settings'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Email'),
					'name' => 'BLOCKFIXEDCONTACT_EMAIL',
					'size' => 128
//					'required' => true
				),
                array(
                    'type' => 'text',
                    'label' => $this->l('Skype'),
                    'name' => 'BLOCKFIXEDCONTACT_SKYPE',
                    'size' => 64
                )
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'btn btn-default pull-right'
			)
		);
		 
		$helper = new HelperForm();
		 
		// Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		 
		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		 
		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;        // false -> remove toolbar
		$helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
		$helper->submit_action = 'submit'.$this->name;
		$helper->toolbar_btn = array(
			'save' =>
			array(
				'desc' => $this->l('Save'),
				'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
				'&token='.Tools::getAdminTokenLite('AdminModules'),
			),
			'back' => array(
				'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
				'desc' => $this->l('Back to list')
			)
		);
		 
		// Load current value
        $helper->fields_value['BLOCKFIXEDCONTACT_EMAIL'] = Configuration::get('BLOCKFIXEDCONTACT_EMAIL');
		$helper->fields_value['BLOCKFIXEDCONTACT_SKYPE'] = Configuration::get('BLOCKFIXEDCONTACT_SKYPE');
		 
		return $helper->generateForm($fields_form);
	}
	
	
	public function install()
	{
		if (Shop::isFeatureActive())
			Shop::setContext(Shop::CONTEXT_ALL);

		return parent::install() &&
			$this->registerHook('footer') &&
			$this->registerHook('header') &&
        Configuration::updateValue('BLOCKFIXEDCONTACT_EMAIL', '') &&
			Configuration::updateValue('BLOCKFIXEDCONTACT_SKYPE', '');
	}
	

	   
	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS($this->_path.'css/blockfixedcontact.css', 'all');
	}  


	public function hookDisplayFooter()
	{		
		$this->context->smarty->assign(
		  array(
              'block_fixedcontact_email' => Configuration::get('BLOCKFIXEDCONTACT_EMAIL'),
			  'block_fixedcontact_skype' => Configuration::get('BLOCKFIXEDCONTACT_SKYPE')
		  )
		);
		return $this->display(__FILE__, 'blockfixedcontact.tpl');
	}  
}
