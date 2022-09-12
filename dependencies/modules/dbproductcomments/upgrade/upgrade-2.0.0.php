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

/**
 * This function updates your module from previous versions to the version 1.1,
 * usefull when you modify your database, or register a new hook ...
 * Don't forget to create one file per version.
 */
function upgrade_module_2_0_0($module)
{
    include(dirname(__FILE__).'/../sql/install.php');
    $module->createTabs();

    if($module->premium == 1) {
        Configuration::updateValue('DBPRODUCTCOMMENTS_CHARACTERISTIC1', 'Calidad');
        Configuration::updateValue('DBPRODUCTCOMMENTS_CHARACTERISTIC2', 'Precio');
        Configuration::updateValue('DBPRODUCTCOMMENTS_CHARACTERISTIC3', 'Rendimiento');
        Configuration::updateValue('DBPRODUCTCOMMENTS_DAYS', 20);
        Configuration::updateValue('DBPRODUCTCOMMENTS_SUBJECT', '');
    }

    $module->registerHook('displayHeader');
    $module->registerHook('displayProductListReviews');
    $module->registerHook('displayFooterProduct');
    $module->registerHook('displayFooterCategory');
    $module->registerHook('actionOrderStatusPostUpdate');
    $module->registerHook('ModuleRoutes');

    if(Module::isInstalled('productcomments')) {
        $sql = "SELECT * FROM "._DB_PREFIX_."product_comment";
        $comments = Db::getInstance()->executeS($sql);
        foreach($comments as $cm) {
            $values_array = array(
                'id_product' => $cm['id_product'],
                'id_customer' => $cm['id_customer'],
                'customer_name' => $cm['customer_name'],
                'title' => $cm['title'],
                'content' => $cm['content'],
                'grade' => $cm['grade'],
                'characteristic1' => 5,
                'characteristic2' => 5,
                'characteristic3' => 5,
                'recommend' => 1,
                'validate' => $cm['validate'],
                'deleted' => $cm['deleted'],
                'date_add' => $cm['date_add'],
            );
            Db::getInstance()->insert("dbproductcomments", $values_array);
        }
        Module::disableAllByName('productcomments');
    }

    return true;
}
