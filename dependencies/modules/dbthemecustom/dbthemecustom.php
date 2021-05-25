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

class Dbthemecustom extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbthemecustom';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Theme Custom');
        $this->description = $this->l('Customizar el theme Blinders');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBTHEMECUSTOM_SUBCATEGORIES', false);
        Configuration::updateValue('DBTHEMECUSTOM_PRODUCTIMG', 0);

        return parent::install() &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DBTHEMECUSTOM_SUBCATEGORIES');
        Configuration::deleteByName('DBTHEMECUSTOM_PRODUCTIMG');

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
        if (((bool)Tools::isSubmit('submitDbthemecustomModule')) == true) {
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
        $helper->submit_action = 'submitDbthemecustomModule';
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
        $options = array(
            array(
                'id_option' => 0,
                'name' => $this->l('Sin miniaturas')
            ),
            array(
                'id_option' => 1,
                'name' => $this->l('Abajo')
            ),
            array(
                'id_option' => 2,
                'name' => $this->l('Lateral')
            ),
        );

        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar subcategorias'),
                        'name' => 'DBTHEMECUSTOM_SUBCATEGORIES',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar las subcategorias con sus imágenes en la ficha de categoria?'),
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
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Miniaturas productos'),
                        'name' => 'DBTHEMECUSTOM_PRODUCTIMG',
                        'desc' => $this->l('Mostrar las miniaturas de las imágenes de productos en la ficha de producto'),
                        'options' => array(
                            'query' => $options,
                            'id' => 'id_option',
                            'name' => 'name'
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
            'DBTHEMECUSTOM_SUBCATEGORIES' => Configuration::get('DBTHEMECUSTOM_SUBCATEGORIES'),
            'DBTHEMECUSTOM_PRODUCTIMG' => Configuration::get('DBTHEMECUSTOM_PRODUCTIMG'),
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
    public function hookDisplayHeader()
    {
        $controller = Tools::getValue('controller');
        if($controller == 'category') {
            $db_subcategories = Configuration::get('DBTHEMECUSTOM_SUBCATEGORIES');
            $this->context->smarty->assign(array(
                'db_subcategories' => $db_subcategories,
            ));
        }

        if($controller == 'product') {
            $show_product_imgs = Configuration::get('DBTHEMECUSTOM_PRODUCTIMG');
            $this->context->smarty->assign(array(
                'show_product_imgs' => $show_product_imgs,
            ));
            Media::addJsDef([
                'show_product_imgs' => $show_product_imgs,
            ]);
        }
    }
}
