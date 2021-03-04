<?php
/**
* 2007-2021 PrestaShop
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
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dbcontactinfo extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbcontactinfo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Contact Info');
        $this->description = $this->l('Información y enlace de contacto');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBCONTACTINFO_DISPLAYTOP', true);
        Configuration::updateValue('DBCONTACTINFO_PHONE', '666 666 666');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayNav1') &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayTopCheckout');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DBCONTACTINFO_DISPLAYTOP');
        Configuration::deleteByName('DBCONTACTINFO_PHONE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitDbcontactinfoModule')) == true) {
            $this->postProcess();
        }

        return $this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitDbcontactinfoModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Display Top'),
                        'name' => 'DBCONTACTINFO_DISPLAYTOP',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar enlace a formulario de contacto en la posición displaytop?'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Insertar número de teléfono que aparecerá en el topnav'),
                        'name' => 'DBCONTACTINFO_PHONE',
                        'label' => $this->l('Teléfono'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'DBCONTACTINFO_DISPLAYTOP' => Configuration::get('DBCONTACTINFO_DISPLAYTOP'),
            'DBCONTACTINFO_PHONE' => Configuration::get('DBCONTACTINFO_PHONE'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/dbcontactinfo.css');
    }

    public function hookDisplayNav1()
    {
        $phone = Configuration::get('DBCONTACTINFO_PHONE');
        $this->context->smarty->assign('phone', $phone);
        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/nav.tpl');
    }

    public function hookDisplayNav2()
    {
        $this->hookDisplayNav1();
    }

    public function hookDisplayNavCenter()
    {
        $this->hookDisplayNav1();
    }

    public function hookDisplayTop()
    {
        if(!Context::getContext()->isMobile()) {
            $displaytop = Configuration::get('DBCONTACTINFO_DISPLAYTOP');
            $ofuscador = 0;
            if (Module::isInstalled('dbdatatext') && Module::isEnabled('dbdatatext')) {
                $ofuscador = 1;
            }

            if ($displaytop) {
                $this->context->smarty->assign('ofuscador', $ofuscador);
                return $this->context->smarty->fetch($this->local_path . 'views/templates/hook/displaytop.tpl');
            }
        }
    }

    public function hookdisplayTopCheckout()
    {
        $phone = Configuration::get('DBCONTACTINFO_PHONE');
        $this->context->smarty->assign('phone', $phone);
        return $this->context->smarty->fetch($this->local_path . 'views/templates/hook/displaytopcheckout.tpl');
    }
}
