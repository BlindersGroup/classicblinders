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

class Dbbrandproducts extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbbrandproducts';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Brand Products');
        $this->description = $this->l('Listado de productos de una marca específica en el footer de la ficha de producto');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBBRANDPRODUCTS_NUMBEROFPRODUCTS', 12);
        Configuration::updateValue('DBBRANDPRODUCTS_ORDERTYPE', 'desc');

        return parent::install() &&
            $this->registerHook('displayFooterProduct');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
        if (((bool)Tools::isSubmit('submitDbbrandproductsModule')) == true) {
            $this->postProcess();
        }

        $iframe = $this->context->smarty->fetch($this->local_path.'views/templates/admin/iframe.tpl');
        $iframe_bottom = $this->context->smarty->fetch($this->local_path.'views/templates/admin/iframe_bottom.tpl');

        return $iframe.$this->renderForm().$iframe_bottom;
    }

    public function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitDbbrandproductsModule';
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

    protected function getConfigForm()
    {
        $order_way = array(
            array(
                'id_option' => 'ASC',
                'name' => 'Ascendente'
            ),
            array(
                'id_option' => 'DESC',
                'name' => 'Descendente'
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
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Tipo de orden'),
                        'name' => 'DBBRANDPRODUCTS_ORDERTYPE',
                        'desc' => $this->l('Ordenar por productos de la marca más vendidos'),
                        'options' => array(
                            'query' => $order_way,
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                        'required' => true,
                    ),
                    array(
                        'label' => $this->l('Número de productos'),
                        'col' => 3,
                        'type' => 'text',
                        'desc' => $this->l('Número de productos más vendidos de cada marca'),
                        'name' => 'DBBRANDPRODUCTS_NUMBEROFPRODUCTS',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    public function getConfigFormValues()
    {
        return array(
            'DBBRANDPRODUCTS_NUMBEROFPRODUCTS' => Configuration::get('DBBRANDPRODUCTS_NUMBEROFPRODUCTS'),
            'DBBRANDPRODUCTS_ORDERTYPE' => Configuration::get('DBBRANDPRODUCTS_ORDERTYPE'),
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

    public function hookDisplayFooterProduct()
    {
        $id_lang = $this->context->language->id;
        $id_product = (int)Tools::getValue('id_product');
        $producto = new Product($id_product);
        $id_manufacturer = $producto->id_manufacturer;
        $limit = Configuration::get('DBBRANDPRODUCTS_NUMBEROFPRODUCTS');
        $order_way = Configuration::get('DBBRANDPRODUCTS_ORDERTYPE');
        $templateFile = 'module:dbbrandproducts/views/templates/hook/footerproduct.tpl';

        if($id_manufacturer > 0){
            if (!$this->isCached($templateFile, $this->getCacheId('dbbrandproducts_'.$id_manufacturer.rand()))) {
                $manufacturer = new Manufacturer($id_manufacturer);
                $products = $this->getBestSellerBrand($id_product, $limit, $id_manufacturer, $order_way, $active = true);
                if (count($products) > 0) {
                    $products = $this->prepareBlocksProducts($products);

                    $this->context->smarty->assign(array(
                        'products' => $products,
                        'name_brand' => $manufacturer->name,
                    ));
                    return $this->fetch($templateFile, $this->getCacheId('dbbrandproducts_'.$id_manufacturer));
                }
            } else {
                return $this->fetch($templateFile, $this->getCacheId('dbbrandproducts_'.$id_manufacturer));
            }
        }
    }

    public function getBestSellerBrand($id_product, $limit, $id_manufacturer, $order_way, $active = true)
    {
        $sql = 'SELECT p.id_product, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity,
					product_shop.price AS orderprice,
					SUM(od.product_quantity) as sellers
				FROM `' . _DB_PREFIX_ . 'product` p
				' . Shop::addSqlAssociation('product', 'p')
            . Product::sqlStock('p', 0) . '
				LEFT JOIN `' . _DB_PREFIX_ . 'order_detail` od
				    ON p.`id_product` = od.`product_id`
				WHERE product_shop.`id_shop` = ' . (int) $this->context->shop->id
            . ($active ? ' AND product_shop.`active` = 1' : '')
            . ' AND product_shop.`visibility` IN ("both", "catalog")
                    AND (stock.out_of_stock = 1 OR stock.quantity > 0)
                    AND p.id_product <> '.$id_product;
        if($id_manufacturer > 0){
            $sql .= ' AND p.id_manufacturer = '.$id_manufacturer;
        }
        $sql .= ' GROUP BY p.id_product
                ORDER BY sellers ' . $order_way .
                ' LIMIT '.$limit;

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

}