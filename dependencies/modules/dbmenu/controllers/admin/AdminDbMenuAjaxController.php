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
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   Commercial license
 */

if (!defined('_PS_VERSION_'))
    exit;

class AdminDbMenuAjaxController extends ModuleAdminController
{
    public function postProcess()
    {
        parent::postProcess();

        if((int)Tools::getIsset('action') && Tools::getValue('action') == 'import_category') {
            $delete = (int)Tools::getValue('borrar');
            if($this->module->premium == 1){
                DbMenuPremium::deleteCategory($delete);
                DbMenuPremium::importCategory();

                die(json_encode(array(
                    'success' => true,
                )));
            }
            die(json_encode(array(
                'success' => false,
            )));
        }

    }
}