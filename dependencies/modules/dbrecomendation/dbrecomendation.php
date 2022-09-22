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

class Dbrecomendation extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        require_once(dirname(__FILE__).'/classes/DbRecommend.php');

        $this->name = 'dbrecomendation';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Recommendation');
        $this->description = $this->l('Recomendacion del experto en el producto');

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
            $this->registerHook('displayFooterProduct') &&
            $this->registerHook('displayAdminProductsMainStepLeftColumnBottom') &&
            $this->registerHook('actionProductSave');
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/dbrecomendation.css');
    }

    public function hookdisplayAdminProductsMainStepLeftColumnBottom($params)
    {
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        if(Module::isEnabled('dbaboutus')) {
            $id_product = (int)$params['id_product'];
            $authors = DbRecommend::getAuthors();
            $recommendation = DbRecommend::getRecommendByProduct($id_product, $id_lang, $id_shop);
            $this->context->smarty->assign('authors', $authors);
            $this->context->smarty->assign('recommendation', $recommendation);
            return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');
        }
    }

    public function hookActionProductSave($params)
    {
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        if(Module::isEnabled('dbaboutus')) {
            $id_product = (int)$params['id_product'];
            $id_author = (int)Tools::getValue('id_author');
            $recommendation = Tools::getValue('recommendation');
            $id_recommendation = (int)DbRecommend::getIdRecommendByProduct($id_product);

            if ($id_product > 0 && $id_author > 0) {
                $recommend = new DbRecommend($id_recommendation, $id_lang, $id_shop);
                $recommend->recomendation = $recommendation;
                $recommend->id_product = $id_product;
                $recommend->id_author = $id_author;
                if($id_recommendation > 0) {
                    $recommend->update();
                } else {
                    $recommend->add();
                }
            }
        }
    }
    public function hookdisplayFooterProduct($params)
    {
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        if(Module::isEnabled('dbaboutus')) {
            $id_product = (int)Tools::getValue('id_product');
            $recommendation = DbRecommend::getRecommend($id_product, $id_lang, $id_shop);
            if(!empty($recommendation['recomendation']) && !empty($recommendation['name_author'])) {
                $this->context->smarty->assign('recommendation', $recommendation);
                return $this->fetch('module:dbrecomendation/views/templates/hook/product.tpl');
            }
        }
    }
}
