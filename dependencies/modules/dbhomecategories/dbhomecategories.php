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

class Dbhomecategories extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbhomecategories';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Home Categories');
        $this->description = $this->l('Mostrar las categorias seleccionadas en la pagina de inicio');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->templateFile = 'module:dbhomecategories/views/templates/hook/dbhomecategories.tpl';
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBHOMECATEGORIES', '3,4,5,6,9');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DBHOMECATEGORIES');

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
        if (((bool)Tools::isSubmit('submitDbhomecategoriesModule')) == true) {
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
        $helper->submit_action = 'submitDbhomecategoriesModule';
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
        $selected_categories = explode(',', Configuration::get('DBHOMECATEGORIES'));
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type'  => 'categories',
                        'label' => $this->l('Categorias en Home'),
                        'name'  => 'DBHOMECATEGORIES',
                        'tree'  => array(
                            'id' => 'exclude_cats',
                            'use_checkbox' => true,
                            'use_search'  => true,
                            'selected_categories' => $selected_categories,
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
            'DBHOMECATEGORIES' => explode(',', Configuration::get('DBHOMECATEGORIES')),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            if($key == 'DBHOMECATEGORIES') {
                $categories = implode(',', Tools::getValue($key));
                Configuration::updateValue($key, $categories);
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
        if(Tools::getValue('controller') == 'index') {
            $this->context->controller->addCSS($this->_path . '/views/css/dbhomecategories.css');
        }
    }

    public function hookDisplayHome()
    {
        if(empty(Configuration::get('DBHOMECATEGORIES'))){
            return false;
        }

        $selected_categories = explode(',', Configuration::get('DBHOMECATEGORIES'));
        if (!$this->isCached($this->templateFile, $this->getCacheIdKey($selected_categories))) {
            $categories = $this->getWidgetVariables();
            $this->smarty->assign(array(
                'categories' => $categories,
            ));
        }
        return $this->fetch($this->templateFile, $this->getCacheIdKey($selected_categories));
    }

    public function getWidgetVariables()
    {
        $id_lang = $this->context->language->id;
        $link = new Link();
        $categories = [];

        $selected_categories = explode(',', Configuration::get('DBHOMECATEGORIES'));
        if(count($selected_categories) > 0) {
            foreach ($selected_categories as $id_category) {
                $category = new Category($id_category, $id_lang);
                if ($category->active == 1) {
                    $name = $category->name;
                    $url = $link->getCategoryLink($id_category, $category->link_rewrite);
                    if ((int)$category->id_image > 0) {
                        $img = '//'.$link->getCatImageLink($category->link_rewrite, $category->id_image, 'category_default');
                    } else {
                        $img = '/img/c/en-default-small_default.jpg';
                    }
                    $categories[] = array(
                        'name' => $name,
                        'url' => $url,
                        'img' => $img,
                    );
                }
            }
            return $categories;
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

    public function getCacheIdKey($selected_categories)
    {
        return parent::getCacheId('dbhomecategories|' . implode('|', $selected_categories));
    }
}
