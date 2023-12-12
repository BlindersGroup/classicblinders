<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

class DbJointPurchaseAjaxModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        $this->ajax = true;
        parent::initContent();
    }


    public function displayAjax()
    {
        $action = Tools::getValue('action');
        if ($action === 'show_products') {
            $id_product = (int)Tools::getValue('id_product');
            //$id_category = (int)Tools::getValue('id_category');
            $key = (int)Tools::getValue('key');
            $best_product = (int)Tools::getValue('best_product');
            $products = $this->module->getTopSellerByCategory($id_product);
            $modal = $this->module->renderJointModal($products, $key, $best_product, $id_product);
            die(json_encode(array('modal' => $modal)));
        }

        if ($action === 'change_product') {
            $id_product = (int)Tools::getValue('id_product');
            $key = (int)Tools::getValue('key');
            $product = $this->module->renderJointProduct($id_product, $key);
            die(json_encode(array('product' => $product)));
        }
    }
}
