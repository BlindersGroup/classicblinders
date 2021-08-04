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
        $this->version = '1.0.1';
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
        Configuration::updateValue('DBCONTACTINFO_SHOW_ADDRESS', 1);
        Configuration::updateValue('DBCONTACTINFO_SHOW_SCHEDULE', 1);
        Configuration::updateValue('DBCONTACTINFO_SHOW_EMAIL', 1);
        Configuration::updateValue('DBCONTACTINFO_SHOW_PHONE', 1);
        Configuration::updateValue('DBCONTACTINFO_SHOW_WHATSAPP', 1);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayNav1') &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayTopCheckout') &&
            $this->registerHook('displaySidebarContact');
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

        return $helper->generateForm($this->getConfigForm());
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        $forms = [];
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Insertar número de teléfono de la tienda'),
                        'name' => 'DBCONTACTINFO_PHONE',
                        'label' => $this->l('Teléfono'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Número de contacto de WhatsApp'),
                        'name' => 'DBCONTACTINFO_WHATSAPP',
                        'label' => $this->l('WhatsApp'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Insertar email de contacto'),
                        'name' => 'DBCONTACTINFO_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Insertar el horario de tu tienda, ejem(Lunes a Viernes 09 - 14h / 17 - 20h)'),
                        'name' => 'DBCONTACTINFO_OPEN',
                        'label' => $this->l('Horario'),
                    ),
                    array(
                        'col' => 6,
                        'type' => 'textarea',
                        'desc' => $this->l('Insertar el iframe de google maps para mostrar el iframe'),
                        'name' => 'DBCONTACTINFO_MAP',
                        'label' => $this->l('Iframe Google Maps'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración cabecera'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enlace a contacto'),
                        'name' => 'DBCONTACTINFO_DISPLAYTOP',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar enlace al formulario de contacto al lado del buscador?'),
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
                        'type' => 'switch',
                        'label' => $this->l('Teléfono en top'),
                        'name' => 'DBCONTACTINFO_DISPLAYTOP_PHONE',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar teléfono al lado del buscador?'),
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
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración página contacto'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Dirección de la tienda'),
                        'name' => 'DBCONTACTINFO_SHOW_ADDRESS',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar la direccion configurada en PrestaShop?'),
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
                        'type' => 'switch',
                        'label' => $this->l('Horario'),
                        'name' => 'DBCONTACTINFO_SHOW_SCHEDULE',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el horario en la página de contacto?'),
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
                        'type' => 'switch',
                        'label' => $this->l('Email'),
                        'name' => 'DBCONTACTINFO_SHOW_EMAIL',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el email en la página de contacto?'),
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
                        'type' => 'switch',
                        'label' => $this->l('Teléfono'),
                        'name' => 'DBCONTACTINFO_SHOW_PHONE',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el teléfono en la página de contacto?'),
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
                        'type' => 'switch',
                        'label' => $this->l('WhatsApp'),
                        'name' => 'DBCONTACTINFO_SHOW_WHATSAPP',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el botón de WhatsApp en la página de contacto?'),
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
                        'type' => 'switch',
                        'label' => $this->l('Mapa'),
                        'name' => 'DBCONTACTINFO_SHOW_MAP',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el mapa en la página de contacto?'),
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
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        return $forms;
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'DBCONTACTINFO_DISPLAYTOP' => Configuration::get('DBCONTACTINFO_DISPLAYTOP'),
            'DBCONTACTINFO_DISPLAYTOP_PHONE' => Configuration::get('DBCONTACTINFO_DISPLAYTOP_PHONE'),
            'DBCONTACTINFO_PHONE' => Configuration::get('DBCONTACTINFO_PHONE'),
            'DBCONTACTINFO_EMAIL' => Configuration::get('DBCONTACTINFO_EMAIL'),
            'DBCONTACTINFO_OPEN' => Configuration::get('DBCONTACTINFO_OPEN'),
            'DBCONTACTINFO_WHATSAPP' => Configuration::get('DBCONTACTINFO_WHATSAPP'),
            'DBCONTACTINFO_MAP' => Configuration::get('DBCONTACTINFO_MAP'),
            'DBCONTACTINFO_SHOW_ADDRESS' => Configuration::get('DBCONTACTINFO_SHOW_ADDRESS'),
            'DBCONTACTINFO_SHOW_SCHEDULE' => Configuration::get('DBCONTACTINFO_SHOW_SCHEDULE'),
            'DBCONTACTINFO_SHOW_EMAIL' => Configuration::get('DBCONTACTINFO_SHOW_EMAIL'),
            'DBCONTACTINFO_SHOW_PHONE' => Configuration::get('DBCONTACTINFO_SHOW_PHONE'),
            'DBCONTACTINFO_SHOW_WHATSAPP' => Configuration::get('DBCONTACTINFO_SHOW_WHATSAPP'),
            'DBCONTACTINFO_SHOW_MAP' => Configuration::get('DBCONTACTINFO_SHOW_MAP'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            if($key == 'DBCONTACTINFO_MAP'){
                Configuration::updateValue($key, Tools::getValue($key), true);
            } else {
                Configuration::updateValue($key, Tools::getValue($key));
            }
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
        $ofuscador = 0;
        if (Module::isInstalled('dbdatatext') && Module::isEnabled('dbdatatext')) {
            $ofuscador = 1;
        }
        $phone = Configuration::get('DBCONTACTINFO_PHONE');
        $email = Configuration::get('DBCONTACTINFO_EMAIL');
        $horario = Configuration::get('DBCONTACTINFO_OPEN');
        $this->context->smarty->assign('ofuscador', $ofuscador);
        $this->context->smarty->assign('phone', $phone);
        $this->context->smarty->assign('email', $email);
        $this->context->smarty->assign('horario', $horario);
        $this->context->smarty->assign('dir_module', _MODULE_DIR_.'dbcontactinfo/');
        return $this->fetch('module:dbcontactinfo/views/templates/hook/nav.tpl');
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

            $this->context->smarty->assign('ofuscador', $ofuscador);
            $this->context->smarty->assign('displaytop', $displaytop);
            $this->context->smarty->assign('phone_top', Configuration::get('DBCONTACTINFO_DISPLAYTOP_PHONE'));
            return $this->fetch('module:dbcontactinfo/views/templates/hook/displaytop.tpl');
        }
    }

    public function hookdisplayTopCheckout()
    {
        $phone = Configuration::get('DBCONTACTINFO_PHONE');
        $this->context->smarty->assign('phone', $phone);
        return $this->fetch('module:dbcontactinfo/views/templates/hook/displaytopcheckout.tpl');
    }

    public function hookDisplayFooterBefore()
    {
        $phone = Configuration::get('DBCONTACTINFO_PHONE');
        $email = Configuration::get('DBCONTACTINFO_EMAIL');
        $horario = Configuration::get('DBCONTACTINFO_OPEN');
        $this->context->smarty->assign('phone', $phone);
        $this->context->smarty->assign('email', $email);
        $this->context->smarty->assign('horario', $horario);
        return $this->fetch('module:dbcontactinfo/views/templates/hook/footer.tpl');
    }

    public function hookDisplaySidebarContact()
    {
        $ofuscador = 0;
        if (Module::isInstalled('dbdatatext') && Module::isEnabled('dbdatatext')) {
            $ofuscador = 1;
        }
        $phone = Configuration::get('DBCONTACTINFO_PHONE');
        $email = Configuration::get('DBCONTACTINFO_EMAIL');
        $horario = Configuration::get('DBCONTACTINFO_OPEN');
        $whatsapp = 'https://wa.me/'.Configuration::get('DBCONTACTINFO_WHATSAPP');
        $map = Configuration::get('DBCONTACTINFO_MAP');
        $address = $this->context->shop->getAddress();
        $address_format = AddressFormat::generateAddress($address, array(), '<br />');
        $show_address = Configuration::get('DBCONTACTINFO_SHOW_ADDRESS');
        $show_schedule = Configuration::get('DBCONTACTINFO_SHOW_SCHEDULE');
        $show_email = Configuration::get('DBCONTACTINFO_SHOW_EMAIL');
        $show_phone = Configuration::get('DBCONTACTINFO_SHOW_PHONE');
        $show_whatsapp = Configuration::get('DBCONTACTINFO_SHOW_WHATSAPP');
        $show_map = Configuration::get('DBCONTACTINFO_SHOW_MAP');

        $this->context->smarty->assign('ofuscador', $ofuscador);
        $this->context->smarty->assign('phone', $phone);
        $this->context->smarty->assign('email', $email);
        $this->context->smarty->assign('horario', $horario);
        $this->context->smarty->assign('whatsapp', $whatsapp);
        $this->context->smarty->assign('map', $map);
        $this->context->smarty->assign('address', $address);
        $this->context->smarty->assign('address_format', $address_format);
        $this->context->smarty->assign('dir_module', _MODULE_DIR_.'dbcontactinfo/');
        $this->context->smarty->assign('show_address', $show_address);
        $this->context->smarty->assign('show_schedule', $show_schedule);
        $this->context->smarty->assign('show_email', $show_email);
        $this->context->smarty->assign('show_phone', $show_phone);
        $this->context->smarty->assign('show_whatsapp', $show_whatsapp);
        $this->context->smarty->assign('show_map', $show_map);
        return $this->fetch('module:dbcontactinfo/views/templates/hook/sidebar_contact.tpl');
    }
}
