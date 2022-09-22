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

use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class Dbnewproducts extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbnewproducts';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB New Products');
        $this->description = $this->l('Listado de productos nuevos en diferentes secciones');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBNEWPRODUCTS_CATEGORY', 12);

        return parent::install() &&
            $this->registerHook('displayFooterCategory');
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
        if (((bool)Tools::isSubmit('submitDbnewproductsModule')) == true) {
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
        $helper->submit_action = 'submitDbnewproductsModule';
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
                        'desc' => $this->l('Number of new products in categories and brands'),
                        'name' => 'DBNEWPRODUCTS_CATEGORY',
                        'label' => $this->l('Products'),
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
            'DBNEWPRODUCTS_CATEGORY' => Configuration::get('DBNEWPRODUCTS_CATEGORY'),
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

    public function hookDisplayFooterCategory()
    {
        $id_lang = $this->context->language->id;
        $controller = Tools::getValue('controller');
        $novedad = (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT');
        $limit = (int)Configuration::get('DBNEWPRODUCTS_CATEGORY');
        $templateFile = 'module:dbnewproducts/views/templates/hook/category.tpl';

        if($controller == 'category') {
            $id_category = Tools::getValue('id_category');

            if (!$this->isCached($templateFile, $this->getCacheId('dbnewproducts_'.$id_category))) {
                $category = new Category($id_category, $id_lang);
                $products = $this->getNewProducts($novedad, $limit, $id_category);
                if (is_array($products) && count($products) > 0) {
                    $products = $this->prepareBlocksProducts($products);

                    $this->smarty->assign(array(
                        'products' => $products,
                        'name_category' => $category->name,
                    ));
                    return $this->fetch($templateFile, $this->getCacheId('dbnewproducts_'.$id_category));
                }
            } else {
                return $this->fetch($templateFile, $this->getCacheId('dbnewproducts_'.$id_category));
            }

        } elseif ($controller == 'manufacturer'){
            $id_manufacturer = (int)Tools::getValue('id_manufacturer');

            if (!$this->isCached($templateFile, $this->getCacheId('dbnewproducts_manufacturer_'.$id_manufacturer))) {
                $manufacturer = new Manufacturer($id_manufacturer, $id_lang);
                $products = $this->getNewProductsBrand($novedad, $limit, $id_manufacturer);
                if (is_array($products) && count($products) > 0) {
                    $products = $this->prepareBlocksProducts($products);

                    $this->smarty->assign(array(
                        'products' => $products,
                        'name_category' => $manufacturer->name,
                    ));
                    return $this->fetch($templateFile, $this->getCacheId('dbnewproducts_manufacturer_'.$id_manufacturer));
                }
            } else {
                return $this->fetch($templateFile, $this->getCacheId('dbnewproducts_manufacturer_'.$id_manufacturer));
            }
        }
    }

    public function getNewProducts($novedad = 30, $limit = 20, $id_category = null, $active = true)
    {
        $sql = 'SELECT p.id_product, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity,
					product_shop.price AS orderprice,
                    DATEDIFF(product_shop.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
					INTERVAL ' . (int) $novedad . ' DAY)) > 0 AS new
				FROM `' . _DB_PREFIX_ . 'category_product` cp
				LEFT JOIN `' . _DB_PREFIX_ . 'product` p
					ON p.`id_product` = cp.`id_product`
				' . Shop::addSqlAssociation('product', 'p')
            . Product::sqlStock('p', 0) . '
				LEFT JOIN `' . _DB_PREFIX_ . 'order_detail` od
				    ON p.`id_product` = od.`product_id`
				WHERE product_shop.`id_shop` = ' . (int) $this->context->shop->id
            . ($active ? ' AND product_shop.`active` = 1' : '')
            . ' AND product_shop.`visibility` IN ("both", "catalog")
                    AND (stock.out_of_stock = 1 OR stock.quantity > 0)';
        if($id_category > 0){
            $categories = implode(',', $this->getAllChildrens([], $id_category, $this->context->language->id));
            $sql .= ' AND cp.id_category IN ('.$categories.')';
        }
        $sql .= ' GROUP BY p.id_product
                ORDER BY p.date_add DESC 
                LIMIT '.$limit;

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, true);
    }

    public function getNewProductsBrand($novedad = 30, $limit = 20, $id_manufacturer = null, $active = true)
    {
        $sql = 'SELECT p.id_product, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity,
					product_shop.price AS orderprice,
                    DATEDIFF(product_shop.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
					INTERVAL ' . (int) $novedad . ' DAY)) > 0 AS new
				FROM `' . _DB_PREFIX_ . 'product` p
				' . Shop::addSqlAssociation('product', 'p')
                . Product::sqlStock('p', 0) . '
				LEFT JOIN `' . _DB_PREFIX_ . 'order_detail` od
				    ON p.`id_product` = od.`product_id`
				WHERE product_shop.`id_shop` = ' . (int) $this->context->shop->id
            . ($active ? ' AND product_shop.`active` = 1' : '')
            . ' AND product_shop.`visibility` IN ("both", "catalog")
                    AND (stock.out_of_stock = 1 OR stock.quantity > 0)';
        if($id_manufacturer > 0){
            $sql .= ' AND p.id_manufacturer = '.$id_manufacturer;
        }
        $sql .= ' GROUP BY p.id_product
                ORDER BY p.date_add DESC 
                LIMIT '.$limit;

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, true);
    }

    public function prepareBlocksProducts($products)
    {
        if ($products != false)
        {
            $products_for_template = [];
            $assembler = new ProductAssembler($this->context);
            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(new ImageRetriever($this->context->link), $this->context->link, new PriceFormatter(), new ProductColorsRetriever(), $this->context->getTranslator());
            $products_for_template = [];
            foreach ($products as $rawProduct)
            {
                $products_for_template[] = $presenter->present($presentationSettings, $assembler->assembleProduct($rawProduct), $this->context->language);
            }

            return $products_for_template;
        }
        else
        {
            return false;
        }
    }

    public function getAllChildrens(array $categories, $id_parent, $id_lang)
    {
        $categories[$id_parent] = $id_parent;
        $parent_childrens = Category::getChildren($id_parent, $id_lang);
        if($parent_childrens) {
            foreach ($parent_childrens as $p_children) {
                $id = $p_children['id_category'];
                if($id > 0) {
                    $categories[$id] = $id;
                    $subchildrens = $this->getAllChildrens($categories, $id, $id_lang);
                    $categories = array_merge($categories, $subchildrens);
                }
            }
        }
        return array_unique($categories);
    }
}
