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

class Dbbrandslider extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbbrandslider';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Brand Slider');
        $this->description = $this->l('Slide con los iconos de las marcas');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->templateFile = 'module:dbbrandslider/views/templates/hook/dbbrandslide.tpl';
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBBRANDSLIDER_IDS', '1,2');

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DBBRANDSLIDER_IDS');

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
        if (((bool)Tools::isSubmit('submitDbbrandsliderModule')) == true) {
            $this->postProcess();
        }
        
        $iframe = $this->context->smarty->fetch($this->local_path.'views/templates/admin/iframe.tpl');
        $iframe_bottom = $this->context->smarty->fetch($this->local_path.'views/templates/admin/iframe_bottom.tpl');

        return $iframe.$this->renderForm().$iframe_bottom;
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
        $helper->submit_action = 'submitDbbrandsliderModule';
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
                        'desc' => $this->l('Insertar las ids de las marcas separadas por comas'),
                        'name' => 'DBBRANDSLIDER_IDS',
                        'label' => $this->l('Marcas'),
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
            'DBBRANDSLIDER_IDS' => Configuration::get('DBBRANDSLIDER_IDS'),
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
        $this->context->controller->addCSS($this->_path.'/views/css/dbbrandslider.css');
    }

    public function hookDisplayHome()
    {
        $selected_brands = explode(',', Configuration::get('DBBRANDSLIDER_IDS'));
        if(count($selected_brands) > 1) {
            if (!$this->isCached($this->templateFile, $this->getCacheIdKey($selected_brands))) {
                $brands = $this->getWidgetVariables();
                $this->smarty->assign(array(
                    'brands' => $brands,
                ));
            }
            return $this->fetch($this->templateFile, $this->getCacheIdKey($selected_brands));
        }
    }

    public function getWidgetVariables()
    {
        $id_lang = $this->context->language->id;
        $link = new Link();
        $brands = [];

        $selected_brands = explode(',', Configuration::get('DBBRANDSLIDER_IDS'));
        if(count($selected_brands) > 0) {
            foreach ($selected_brands as $id_manufacturer) {
                $manufacturer = new Manufacturer($id_manufacturer, $id_lang);
                if ($manufacturer->active == 1) {
                    $name = $manufacturer->name;
                    $url = $link->getManufacturerLink($id_manufacturer, $manufacturer->link_rewrite);
                    $img = $link->getManufacturerImageLink($id_manufacturer, 'brand_home');
                    $brands[] = array(
                        'name' => $name,
                        'url' => $url,
                        'img' => $img,
                    );
                }
            }
            return $brands;
        } else {
            return false;
        }

        $productIds = $this->getProductIds($hookName, $configuration);
        if (!empty($productIds)) {
            $products = $this->getOrderProducts($productIds);

            if (!empty($products)) {
                return array(
                    'products' => $products,
                );
            }
        }
        return false;
    }

    public function getCacheIdKey($selected_brands)
    {
        return parent::getCacheId('dbbrandslider|' . implode('|', $selected_brands));
    }
}
