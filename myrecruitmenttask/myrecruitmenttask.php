<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

 

 if (!defined('_PS_VERSION_')) {
    exit;
}

class MyRecruitmentTask extends Module
{
    public function __construct()
    {
        $this->name = 'myrecruitmenttask';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Patryk Ruta';
        $this->need_instance = 0;$this->ps_versions_compliancy = [
            'min' => '1.7.0',
            'max' => '1.7.9',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My Recruitment Task');
        $this->description = $this->l('Module to add content using WYSIWYG editor.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }


    public function hookDisplayHome($params)
    {
        $taskContent = Configuration::get('MYRECRUITMENTTASK_CONTENT');

        $this->context->smarty->assign(array(
            'taskContent' => html_entity_decode($taskContent)
        ));

        $this->context->controller->addCSS($this->_path . '/views/css/myrecruitmenttask.css', 'all');

        return $this->display(__FILE__, '/myrecruitmenttask.tpl');
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit_myrecruitmenttask')) {
            $taskContent = Tools::getValue('taskContent');

            Configuration::updateValue('MYRECRUITMENTTASK_CONTENT', htmlentities($taskContent));

            $output .= $this->displayConfirmation($this->l('Multimedia content updated successfully.'));
        }

        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Task Content Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Task Content'),
                        'name' => 'taskContent',
                        'autoload_rte' => true,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit_myrecruitmenttask';
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

        $helper->fields_value['taskContent'] = html_entity_decode(Configuration::get('MYRECRUITMENTTASK_CONTENT'));

        return $helper->generateForm(array($fields_form));
    }
}