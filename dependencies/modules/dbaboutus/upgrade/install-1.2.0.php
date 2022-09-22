<?php
/*
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/osl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2017 PrestaShop SA
*  @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Upgrade the Ps_Customtext module to V3.0.0
 *
 * @param Ps_Customtext $module
 * @return bool
 */
function upgrade_module_1_2_0($module)
{
    $id_shop = (int)Context::getContext()->shop->id;
    $return = true;

    // Multishop author
    $return &= Db::getInstance()->execute(
        'ALTER TABLE `' . _DB_PREFIX_ . 'dbaboutus_author_lang` 
        ADD `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT('.$id_shop.')
        AFTER `id_lang`;
    ');

    // Multishop speciality
    $return &= Db::getInstance()->execute(
        'ALTER TABLE `' . _DB_PREFIX_ . 'dbaboutus_speciality_lang` 
        ADD `id_shop` INT(11) UNSIGNED NOT NULL DEFAULT('.$id_shop.')
        AFTER `id_lang`;
    ');

    // Multishop tag
    $return &= Db::getInstance()->execute(
        'ALTER TABLE `' . _DB_PREFIX_ . 'dbaboutus_tag_lang` 
        ADD `id_shop` INT(11) UNSIGNED NOT NULL DEFAULT('.$id_shop.')
        AFTER `id_lang`;
    ');

    return $return;
}
