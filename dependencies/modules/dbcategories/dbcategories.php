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

class Dbcategories extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbcategories';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Categories');
        $this->description = $this->l('Categorías seleccionadas en home, y categorías autogeneradas en marcas, productos, etc; pudiendo excluir categorías');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayFooterCategory') &&
            $this->registerHook('displayFooterProduct');
    }

    public function uninstall()
    {
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
        if (((bool)Tools::isSubmit('submitDbcategoriesModule')) == true) {
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
        $helper->submit_action = 'submitDbcategoriesModule';
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
        $selected_categories = explode(',', Configuration::get('DBCATEGORIES_HOME'));
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
                        'name'  => 'DBCATEGORIES_HOME',
                        'tree'  => array(
                            'id' => 'exclude_cats',
                            'use_checkbox' => true,
                            'use_search'  => true,
                            'selected_categories' => $selected_categories,
                        ),
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->l('Categorias excluidas'),
                        'desc' => $this->l('Insertar las ids de las categorias excluidas separadas por comas'),
                        'name'  => 'DBCATEGORIES_EXCLUDE',
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
            'DBCATEGORIES_HOME' => explode(',', Configuration::get('DBCATEGORIES_HOME')),
            'DBCATEGORIES_EXCLUDE' => Configuration::get('DBCATEGORIES_EXCLUDE'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            if($key == 'DBCATEGORIES_HOME') {
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
    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/dbcategories.css');
    }

    public function hookDisplayHome()
    {
        $id_lang = $this->context->language->id;
        $link = new Link();
        $categories = [];

        $exclude_categories  = explode(',', Configuration::get('DBCATEGORIES_EXCLUDE'));
        $selected_categories = trim(Configuration::get('DBCATEGORIES_HOME'));
        if ( !empty($selected_categories) )
            $selected_categories = explode(',',$selected_categories);
        
        if(is_array($selected_categories) && count($selected_categories) > 0) {
            foreach ($selected_categories as $id_category) {
                if(!in_array($id_category, $exclude_categories)) {
                    $category = new Category($id_category, $id_lang);
                    if ($category->active == 1) {
                        $name = $category->name;
                        $url = $link->getCategoryLink($id_category, $category->link_rewrite);
                        $categories[] = array(
                            'name' => $name,
                            'url' => $url,
                        );
                    }
                }
            }
        }

        if(count($categories) > 0) {
            $this->smarty->assign(array(
                'categories' => $categories,
            ));
            return $this->fetch('module:dbcategories/views/templates/hook/home.tpl');
        }
    }

    public function hookDisplayFooterCategory()
    {
        $id_lang = $this->context->language->id;
        $controller = Tools::getValue('controller');
        $link = new Link();
        $exclude_categories = explode(',', Configuration::get('DBCATEGORIES_EXCLUDE'));

        $categories = [];
        if($controller == 'category'){
            $id_category = (int)Tools::getValue('id_category');
            $category = new Category($id_category, $id_lang);
            $id_parent = $category->id_parent;
            array_push($exclude_categories, $id_category);
            $lists = Category::getChildren($id_parent, $id_lang);
            $manufacturers = $this->getManufacturerFromCategories($id_category, $lists);

        } elseif($controller == 'manufacturer'){
            $id_section = (int)Tools::getValue('id_manufacturer');
            $lists = $this->getCategoriesFromManufacturer($id_section);
            $manufacturers = [];
        }

        if(count($lists) > 0) {
            foreach ($lists as $item) {
                $id_cat = $item['id_category'];
                if(!in_array($id_cat, $exclude_categories)) {
                    $category = new Category($id_cat, $id_lang);
                    if ($category->active == 1) {
                        $name = $category->name;
                        $url = $link->getCategoryLink($id_cat, $category->link_rewrite);
                        $categories[] = array(
                            'name' => $name,
                            'url' => $url,
                        );
                    }
                }
            }
        }

        if(count($categories) > 0) {
            $this->smarty->assign(array(
                'categories' => $categories,
                'manufacturers' => $manufacturers,
            ));
            return $this->fetch('module:dbcategories/views/templates/hook/category.tpl');
        }
    }

    public function hookDisplayFooterProduct()
    {
        $id_lang = $this->context->language->id;
        $controller = Tools::getValue('controller');
        $link = new Link();
        $exclude_categories = explode(',', Configuration::get('DBCATEGORIES_EXCLUDE'));
        $root_category = Category::getRootCategory($id_lang);
        array_push($exclude_categories, $root_category->id);
        $id_product = (int)Tools::getValue('id_product');
        $product = new Product($id_product, null, $id_lang);
        $id_category_default = $product->id_category_default;
        $cats = $product->getCategories();
        $categories = [];
        foreach($cats as $id_category){
            if(!in_array($id_category, $exclude_categories) && $id_category != $id_category_default){
                $category = new Category($id_category, $id_lang);
                if ($category->active == 1) {
                    $name = $category->name;
                    $url = $link->getCategoryLink($id_category, $category->link_rewrite);
                    $categories[] = array(
                        'name' => $name,
                        'url' => $url,
                    );
                }
            }
        }

        if(count($categories) > 0) {
            $this->smarty->assign(array(
                'categories' => $categories,
            ));
            return $this->fetch('module:dbcategories/views/templates/hook/product.tpl');
        }
    }

    public function getCategoriesFromManufacturer($id_manufacturer)
    {
        $limit = 20;
        $sql = "SELECT id_category_default as id_category, count(id_category_default) as total
                FROM " . _DB_PREFIX_ . "product
                WHERE id_manufacturer = '$id_manufacturer'
                GROUP BY id_category_default
                ORDER BY total DESC
                LIMIT ".$limit;
        $categories = Db::getInstance()->executeS($sql);

        return $categories;
    }

    public function getManufacturerFromCategories($id_category, $lists)
    {
        $id_lang = $this->context->language->id;
        $link = new Link();

        $cats = [];
        foreach ($lists as $item) {
            $cats[] = $item['id_category'];
        }
        $id_cats = implode(',', $cats);

        $limit = 20;
        $sql = "SELECT id_manufacturer, count(id_manufacturer) as total
                FROM " . _DB_PREFIX_ . "product
                WHERE id_category_default IN (". $id_cats .")
                GROUP BY id_manufacturer
                ORDER BY total DESC
                LIMIT ".$limit;
        $manufacturers = Db::getInstance()->executeS($sql);

        $manus = [];
        if(count($manufacturers) > 0) {
            foreach ($manufacturers as $manu) {
                $id_manufacturer = $manu['id_manufacturer'];
                $manufacturer = new Manufacturer($id_manufacturer, $id_lang);
                if ($manufacturer->active == 1) {
                    $name = $manufacturer->name;
                    $url = $link->getManufacturerLink($manufacturer);
                    $manus[] = array(
                        'name' => $name,
                        'url' => $url,
                    );
                }
            }
        }

        return $manus;
    }
}
