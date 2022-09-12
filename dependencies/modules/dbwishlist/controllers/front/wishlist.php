<?php
/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

class dbwishlistwishlistModuleFrontController extends ModuleFrontController
{
    /**
     * @var Psgdpr
     */
    public $module;

    /**
     * @throws PrestaShopException
     */
    public function initContent()
    {
        $context = Context::getContext();
        $id_customer = $context->customer->id;
        if (empty($id_customer)) {
            Tools::redirect('index.php');
        }

        parent::initContent();

        $sql = "SELECT id_product 
                FROM "._DB_PREFIX_."dbwishlist 
                WHERE id_customer = '$id_customer'";
        $id_products = Db::getInstance()->executeS($sql);
        $products = $this->module->prepareBlocksProducts($id_products);

        $this->context->smarty->assign([
           'products' => $products,
        ]);

        $this->setTemplate('module:dbwishlist/views/templates/front/customerWishlist.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->l('Mis favoritos'),
            'url' => '',
        ];

        return $breadcrumb;
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();

        $id_lang = Context::getContext()->language->id;
        $meta_title = 'Productos favoritos';
        $meta_desc = 'Listado de productos favoritos';

        $page['meta']['title'] = $meta_title;
        $page['meta']['description'] = $meta_desc;

        return $page;
    }

    public function setMedia()
    {
        parent::setMedia();
    }

}
