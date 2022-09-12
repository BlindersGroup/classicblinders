<?php
/**
* 2007-2022 PrestaShop
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
*  @copyright 2007-2022 PrestaShop SA
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

class Dbwishlist extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbwishlist';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Wishlist');
        $this->description = $this->l('Productos favoritos y guardados para mas tarde');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayProductActions') &&
            $this->registerHook('displayProductListReviews') &&
            $this->registerHook('displayTop') &&
            $this->registerHook('displayCustomerAccount');

    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

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
        if (((bool)Tools::isSubmit('submitDbwishlistModule')) == true) {
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
        $helper->submit_action = 'submitDbwishlistModule';
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
                        'type' => 'color',
                        'desc' => $this->l('Indicar el color del corazón cuando esta activo'),
                        'name' => 'DBWISHLIST_COLOR',
                        'label' => $this->l('Color corazon'),
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
            'DBWISHLIST_COLOR' => Configuration::get('DBWISHLIST_COLOR'),
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
        $this->context->controller->addJS($this->_path.'/views/js/dbwishlist.js');
        $this->context->controller->addCSS($this->_path.'/views/css/dbwishlist.css');

        Media::addJsDef(array(
            'dbwishlist_ajax' => Context::getContext()->link->getModuleLink('dbwishlist', 'ajax', array()),
        ));
    }

    public function hookDisplayProductActions($params)
    {
        $id_customer = (int) $this->context->customer->id;
        /*if($id_customer == 0){
            return;
        }*/

        $id_product = (int) $params['product']->id;
        if($id_product == 0){
            return;
        }

        $active = 0;
        $color = Configuration::get('DBWISHLIST_COLOR');
        $sql = "SELECT id_dbwishlist 
                FROM "._DB_PREFIX_."dbwishlist 
                WHERE id_customer = '$id_customer' AND id_product = '$id_product'";
        $id_wishlist = (int) Db::getInstance()->getValue($sql);
        if($id_wishlist > 0) {
            $active = 1;
        }

        $this->smarty->assign(array(
          'active' => $active,
          'color' => $color,
        ));
        return $this->fetch('module:dbwishlist/views/templates/hook/dbwishlist_product.tpl');
    }

    public function hookdisplayProductListReviews($params)
    {
        $id_customer = (int) $this->context->customer->id;
        /*if($id_customer == 0){
            return;
        }*/

        $id_product = (int) $params['product']->id;
        if($id_product == 0){
            return;
        }

        $active = 0;
        $color = Configuration::get('DBWISHLIST_COLOR');
        $sql = "SELECT id_dbwishlist FROM "._DB_PREFIX_."dbwishlist WHERE id_customer = '$id_customer' AND id_product = '$id_product'";
        $id_wishlist = (int) Db::getInstance()->getValue($sql);
        if($id_wishlist > 0) {
            $active = 1;
        }

        $this->smarty->assign(array(
                                  'id_product' => $id_product,
                                  'active' => $active,
                                  'color' => $color,
                              ));
        return $this->fetch('module:dbwishlist/views/templates/hook/dbwishlist_product_hearth.tpl');
    }

    public function hookdisplayTop()
    {
        $url = Context::getContext()->link->getModuleLink($this->name, 'wishlist', [], true);
        $this->context->smarty->assign([
            'url' => $url,
        ]);

        return $this->fetch('module:dbwishlist/views/templates/hook/displayTop.tpl');
    }

    public function hookDisplayCustomerAccount()
    {

        $url = Context::getContext()->link->getModuleLink($this->name, 'wishlist', [], true);

        $this->context->smarty->assign([
            'url' => $url,
        ]);

        return $this->fetch('module:dbwishlist/views/templates/hook/customerAccount.tpl');
    }

    public function renderGenericModal($action)
    {
        if($action == 'login'){
            $text = $this->l('Debe de estar logueado para poder añadir a favoritos');
        } elseif($action == 'save_wishlist'){
            $text = $this->l('Se ha añadido correctamente a favoritos');
        }

        $this->smarty->assign(array(
            'text' => $text,
        ));

        return $this->fetch('module:dbwishlist/views/templates/hook/modal_generic.tpl');
    }

    public function renderWishlistModal($id_product, $id_customer, $active)
    {
        if($active == 'false' || $active == 0) {
            $sql = "DELETE FROM "._DB_PREFIX_."dbwishlist WHERE id_customer = '$id_customer' AND id_product = '$id_product'";
        } elseif($active == 'true' || $active == 1) {
            $sql = "INSERT INTO "._DB_PREFIX_."dbwishlist (id_customer, id_product) VALUES ('$id_customer', '$id_product')";
        }

        Db::getInstance()->execute($sql);

        return $this->renderGenericModal('save_wishlist');
    }

    public function removeWishlist($id_product, $id_customer)
    {
        $sql = "DELETE FROM "._DB_PREFIX_."dbwishlist WHERE id_customer = '$id_customer' AND id_product = '$id_product'";
        Db::getInstance()->execute($sql);

        return;
        //return $this->renderGenericModal('save_wishlist');
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
