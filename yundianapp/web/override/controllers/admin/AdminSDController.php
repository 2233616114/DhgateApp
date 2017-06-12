<?php

/**
 * Created by PhpStorm.
 * User: chenjunhua
 * Date: 2017/2/23
 * Time: 18:06
 */
abstract class AdminSDControllerCore extends AdminController
{
    public $controller = 'AdminModules';

    public function __construct()
    {
        parent::__construct();
    }
    public function postProcess() {
        // Parent Post Process
        parent::postProcess();
        $the_token = Tools::getAdminToken($this->controller.(int)Tab::getIdFromClassName($this->controller).(int)$this->context->employee->id);
        Tools::redirectAdmin('index.php?controller='.$this->controller.'&configure='.$this->getModuleName().'&token='.$the_token.'&module_name='.$this->getModuleName());

    }

    abstract public function getModuleName();
}