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
function upgrade_module_1_0_1($module)
{
    // Valores default
    Configuration::updateValue('DBCONTACTINFO_SHOW_ADDRESS', 1);
    Configuration::updateValue('DBCONTACTINFO_SHOW_SCHEDULE', 1);
    Configuration::updateValue('DBCONTACTINFO_SHOW_EMAIL', 1);
    Configuration::updateValue('DBCONTACTINFO_SHOW_PHONE', 1);
    Configuration::updateValue('DBCONTACTINFO_SHOW_WHATSAPP', 1);

    // Hook dentro del menu
    $module->registerHook('displaySidebarContact');

    return true;
}
