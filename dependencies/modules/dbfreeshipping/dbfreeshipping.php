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

class Dbfreeshipping extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbfreeshipping';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Free Shipping');
        $this->description = $this->l('Mostrar cuanto queda para envio gratuito');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBFREESHIPPING_VALUE', '35');
        Configuration::updateValue('DBFREESHIPPING_LIVE_PRODUCT', true);
        Configuration::updateValue('DBFREESHIPPING_LIVE_CART', true);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayShoppingCart') &&
            $this->registerHook('displayProductAdditionalInfo') &&
            $this->registerHook('displayNav2');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DBFREESHIPPING_VALUE');
        Configuration::deleteByName('DBFREESHIPPING_LIVE_PRODUCT');
        Configuration::deleteByName('DBFREESHIPPING_LIVE_CART');

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
        if (((bool)Tools::isSubmit('submitDbfreeshippingModule')) == true) {
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
        $helper->submit_action = 'submitDbfreeshippingModule';
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
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '€',
                        'name' => 'DBFREESHIPPING_VALUE',
                        'label' => $this->l('Envío gratis'),
                        'desc' => $this->l('Insertar el valor con impuestos incluidos del envío gratis'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar en Producto'),
                        'name' => 'DBFREESHIPPING_LIVE_PRODUCT',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar lo que queda para envio gratis en ficha de producto?'),
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
                        'label' => $this->l('Mostrar en Carrito'),
                        'name' => 'DBFREESHIPPING_LIVE_CART',
                        'is_bool' => true,
                        'desc' => $this->l('¿Mostrar lo que queda para envio gratis en el carrito?'),
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
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'DBFREESHIPPING_VALUE' => Configuration::get('DBFREESHIPPING_VALUE'),
            'DBFREESHIPPING_LIVE_PRODUCT' => Configuration::get('DBFREESHIPPING_LIVE_PRODUCT'),
            'DBFREESHIPPING_LIVE_CART' => Configuration::get('DBFREESHIPPING_LIVE_CART'),
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
        $this->context->controller->addCSS($this->_path.'/views/css/dbfreeshipping.css');
    }

    public function hookDisplayNav2()
    {
        $free = Tools::displayPrice(Configuration::get('DBFREESHIPPING_VALUE'));

        $this->context->smarty->assign('free', $free);
        return $this->display(__FILE__, 'views/templates/hook/nav.tpl');
    }

    public function getFreeShippingTotal()
    {
        $is_free = false;
        $free = Configuration::get('DBFREESHIPPING_VALUE');
        $total_cart = 0;
        if($this->context->cart->id) {
            $total_cart = Cart::getTotalCart($this->context->cart->id, true);
            $total_cart = trim(str_replace('€', '', $total_cart));
        }

        $remains = Tools::displayPrice(round((float)$free - (float)$total_cart, 2));
        $porcent = round((float)$total_cart * 100 / (float)$free, 0);
        if ((float)$total_cart > (float)$free) {
            $is_free = true;
            $porcent = 100;
        }

        return array(
            'is_free' => $is_free,
            'porcent' => $porcent,
            'remains' => $remains,
            'free' => Tools::displayPrice($free),
        );
    }

    public function hookdisplayProductAdditionalInfo()
    {

        $shipping = $this->getFreeShippingTotal();
        $this->context->smarty->assign(array(
            'free' => $shipping['free'],
            'is_free' => $shipping['is_free'],
            'remains' => $shipping['remains'],
            'porcent' => $shipping['porcent'],
        ));
        return $this->display(__FILE__, 'views/templates/hook/product.tpl');
    }

    public function hookdisplayShoppingCart()
    {

        $shipping = $this->getFreeShippingTotal();
        $this->context->smarty->assign(array(
            'free' => $shipping['free'],
            'is_free' => $shipping['is_free'],
            'remains' => $shipping['remains'],
            'porcent' => $shipping['porcent'],
        ));
        return $this->display(__FILE__, 'views/templates/hook/cart.tpl');
    }
}
