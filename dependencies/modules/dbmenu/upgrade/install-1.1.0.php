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

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Upgrade the DbMenu module to V1.1.0
 *
 * @param DbMenu $module
 * @return bool
 */
function upgrade_module_1_1_0($module)
{
    // volvemos a crear las tabs
    $module = Module::getInstanceByName('dbmenu');
    $module->deleteTabs();
    $module->createTabs();

    // Valores default
    Configuration::updateValue('DBMENU_ACCOUNT', 1);
    Configuration::updateValue('DBMENU_CONTACT_SHOW', 1);
    Configuration::updateValue('DBMENU_RRSS_SHOW', 1);
    Configuration::updateValue('DBMENU_OPINIONS', 1);
    Configuration::updateValue('DBMENU_COLOR_FONT', '#232323');
    Configuration::updateValue('DBMENU_COLOR_HOVER', '#2fb5d2');
    Configuration::updateValue('DBMENU_PHONE_SHOW', 1);

    // Hook dentro del menu
    $module->registerHook('displayMenuInside');

    $return = true;

    // Alt enlaces
    $return &= Db::getInstance()->execute(
        'ALTER TABLE `' . _DB_PREFIX_ . 'dbmenu_list_lang` 
        ADD `alt` varchar(512) NOT NULL
        AFTER `title`;
    ');

    // Strong and color
    $return &= Db::getInstance()->execute(
        'ALTER TABLE `' . _DB_PREFIX_ . 'dbmenu_list` 
        ADD COLUMN `strong` tinyint(1) NOT NULL DEFAULT \'0\' AFTER `id_item`,
        ADD COLUMN `color` varchar(10) NOT NULL AFTER `strong`;
    ');

    return $return;
}
