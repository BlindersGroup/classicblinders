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
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   Commercial license
 */

class AdminDbMenuConfigController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->lang = true;

        parent::__construct();

    }

    public function initProcess()
    {

        if(Tools::getIsset('submitDbmenuModule')){
            $this->saveData();
        }

        return parent::initProcess();
    }

    public function renderList()
    {
        $this->context->smarty->assign('name_module', $this->module->name);
        $this->context->smarty->assign('premium', $this->module->premium);
        $iframe = $import = $this->module->display(_PS_MODULE_DIR_.$this->module->name, '/views/templates/admin/iframe.tpl');
        $list = parent::renderList();
        $import = $this->module->display(_PS_MODULE_DIR_.$this->module->name, '/views/templates/admin/configure.tpl');
        $iframe_bottom = $this->module->display(_PS_MODULE_DIR_.$this->module->name, '/views/templates/admin/iframe_bottom.tpl');

        return $iframe.$list.$this->renderForm().$import.$iframe_bottom;
    }

    public function renderForm()
    {
        $fields_form_0 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Bloque mi cuenta'),
                        'name' => 'DBMENU_ACCOUNT',
                        'is_bool' => true,
                        'disabled' => false,
                        'desc' => $this->l('¿Mostrar bloque con enlaces a las secciones de mi cuenta?'),
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
                        'label' => $this->l('Bloque contacto'),
                        'name' => 'DBMENU_CONTACT_SHOW',
                        'is_bool' => true,
                        'disabled' => true,
                        'desc' => $this->l('Mostrar el bloque de contacto'),
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
                        'label' => $this->l('Bloque redes sociales'),
                        'name' => 'DBMENU_RRSS_SHOW',
                        'is_bool' => true,
                        'disabled' => true,
                        'desc' => $this->l('Mostrar el bloque de redes sociales'),
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
                        'label' => $this->l('Bloque opiniones'),
                        'name' => 'DBMENU_OPINIONS',
                        'is_bool' => true,
                        'disabled' => true,
                        'desc' => $this->l('¿Mostrar el resumen de las opiniones de los productos? solo se mostrará si está activo el módulo de opiniones de PrestaShop'),
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
                        'type' => 'color',
                        'label' => $this->l('Color fuente'),
                        'desc' => $this->l('Color por defecto del texto del menú'),
                        'name' => 'DBMENU_COLOR_FONT',
                        'class' => 'disabled',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color hover'),
                        'desc' => $this->l('Color del hover por defecto de los elementos del menú'),
                        'name' => 'DBMENU_COLOR_HOVER',
                        'class' => 'disabled',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            )
        );
        if($this->module->premium == 1){
            $fields_form_0 = DbMenuPremium::renderHelperFormPremium($fields_form_0);
        }

        $fields_form_1 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Redes sociales'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Url Facebook'),
                        'name' => 'DBMENU_FACEBOOK',
                        'label' => $this->l('Facebook'),
                        'lang' => true,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Url Twitter'),
                        'name' => 'DBMENU_TWITTER',
                        'label' => $this->l('Twitter'),
                        'lang' => true,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Url Linkedin'),
                        'name' => 'DBMENU_LINKEDIN',
                        'label' => $this->l('Linkedin'),
                        'lang' => true,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Url Instagram'),
                        'name' => 'DBMENU_INSTAGRAM',
                        'label' => $this->l('Instagram'),
                        'lang' => true,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Url YouTube'),
                        'name' => 'DBMENU_YOUTUBE',
                        'label' => $this->l('YouTube'),
                        'lang' => true,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            )
        );
        if($this->module->premium == 1){
            $fields_form_1 = DbMenuPremium::renderHelperFormPremium($fields_form_1);
        }

        $fields_form_2 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Bloque contacto'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar teléfono'),
                        'name' => 'DBMENU_PHONE_SHOW',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el bloque de teléfono?'),
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
                        'disabled' => true,
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Prefijo del país, por ejemplo: +34'),
                        'name' => 'DBMENU_PREFIX',
                        'label' => $this->l('Prefijo'),
                        'lang' => false,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Teléfono de contacto'),
                        'name' => 'DBMENU_PHONE',
                        'label' => $this->l('Teléfono'),
                        'lang' => false,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar email'),
                        'name' => 'DBMENU_EMAIL_SHOW',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar el email en el bloque de contacto'),
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
                        'disabled' => true,
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Email de contacto'),
                        'name' => 'DBMENU_EMAIL',
                        'label' => $this->l('Email'),
                        'lang' => false,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar horario'),
                        'name' => 'DBMENU_SCHEDULE_SHOW',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar el horario en el bloque de contacto'),
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
                        'disabled' => true,
                    ),
                    array(
                        'col' => 6,
                        'type' => 'text',
                        'desc' => $this->l('Horario de apertura; ejem: L-V de 09 - 14h / 16 - 19h'),
                        'name' => 'DBMENU_SCHEDULE',
                        'label' => $this->l('Horario'),
                        'lang' => false,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar WhatsApp'),
                        'name' => 'DBMENU_WHATSAPP_SHOW',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar el botón de WhatsApp?'),
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
                        'disabled' => true,
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Número de WhatsApp con prefijo del país, ejem: +34666666666'),
                        'name' => 'DBMENU_WHATSAPP',
                        'label' => $this->l('WhatsApp'),
                        'lang' => false,
                        'disabled' => true,
                        'class' => 'disabled',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            )
        );
        if($this->module->premium == 1){
            $fields_form_2 = DbMenuPremium::renderHelperFormPremium($fields_form_2);
        }

        $helper = new HelperForm();
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int) Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $helper->submit_action = 'submitDbmenuModule';
        $helper->token = Tools::getAdminTokenLite('AdminDbMenuConfig');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form_0, $fields_form_1, $fields_form_2));
    }

    protected function getConfigFormValues()
    {
        $languages = Language::getLanguages(false);
        $values = array();

        foreach ($languages as $lang){
            $values['DBMENU_FACEBOOK'][$lang['id_lang']] = Configuration::get('DBMENU_FACEBOOK', $lang['id_lang']);
            $values['DBMENU_TWITTER'][$lang['id_lang']] = Configuration::get('DBMENU_TWITTER', $lang['id_lang']);
            $values['DBMENU_LINKEDIN'][$lang['id_lang']] = Configuration::get('DBMENU_LINKEDIN', $lang['id_lang']);
            $values['DBMENU_INSTAGRAM'][$lang['id_lang']] = Configuration::get('DBMENU_INSTAGRAM', $lang['id_lang']);
            $values['DBMENU_YOUTUBE'][$lang['id_lang']] = Configuration::get('DBMENU_YOUTUBE', $lang['id_lang']);
        }

        $values['DBMENU_ACCOUNT'] = Configuration::get('DBMENU_ACCOUNT');
        $values['DBMENU_OPINIONS'] = Configuration::get('DBMENU_OPINIONS');
        $values['DBMENU_RRSS_SHOW'] = Configuration::get('DBMENU_RRSS_SHOW');
        $values['DBMENU_CONTACT_SHOW'] = Configuration::get('DBMENU_CONTACT_SHOW');
        $values['DBMENU_PHONE_SHOW'] = Configuration::get('DBMENU_PHONE_SHOW');
        $values['DBMENU_PREFIX'] = Configuration::get('DBMENU_PREFIX');
        $values['DBMENU_PHONE'] = Configuration::get('DBMENU_PHONE');
        $values['DBMENU_EMAIL_SHOW'] = Configuration::get('DBMENU_EMAIL_SHOW');
        $values['DBMENU_EMAIL'] = Configuration::get('DBMENU_EMAIL');
        $values['DBMENU_SCHEDULE_SHOW'] = Configuration::get('DBMENU_SCHEDULE_SHOW');
        $values['DBMENU_SCHEDULE'] = Configuration::get('DBMENU_SCHEDULE');
        $values['DBMENU_WHATSAPP_SHOW'] = Configuration::get('DBMENU_WHATSAPP_SHOW');
        $values['DBMENU_WHATSAPP'] = Configuration::get('DBMENU_WHATSAPP');
        $values['DBMENU_COLOR_FONT'] = Configuration::get('DBMENU_COLOR_FONT');
        $values['DBMENU_COLOR_HOVER'] = Configuration::get('DBMENU_COLOR_HOVER');

        return $values;
    }

    protected function saveData()
    {
        $form_values = $this->getConfigFormValues();
        $languages = Language::getLanguages(false);
        $id_shop_group = (int)Context::getContext()->shop->id_shop_group;
        $id_shop = (int)Context::getContext()->shop->id;

        foreach ($form_values as $name => $key) {
            if(is_array($key)){
                $values = array();
                foreach ($languages as $lang){
                    $values[$lang['id_lang']] = Tools::getValue($name . '_'.(int)$lang['id_lang']);
                }
                Configuration::updateValue($name, $values, true, $id_shop_group, $id_shop);
            } else {
                Configuration::updateValue($name, Tools::getValue($name), true, $id_shop_group, $id_shop);
            }
        }
    }

}