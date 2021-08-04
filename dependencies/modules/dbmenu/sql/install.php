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
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbmenu_list` (
    `id_dbmenu_list` int(11) NOT NULL AUTO_INCREMENT,
    `id_parent` int(11) NOT NULL DEFAULT \'0\',
    `type` varchar(55) NOT NULL,
    `id_item` int(11) NOT NULL DEFAULT \'0\',
    `strong` tinyint(1) NOT NULL DEFAULT \'0\',
    `color` varchar(10) NOT NULL,
    `ofuscate` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    `additional` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    `featured` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    `position` int(11) NOT NULL,
    `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    PRIMARY KEY  (`id_dbmenu_list`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbmenu_list_lang` (
    `id_dbmenu_list` int(11) NOT NULL AUTO_INCREMENT,
    `id_lang` int(11) NOT NULL,
    `id_shop` int(11) NOT NULL,
    `title` varchar(255) NOT NULL,
    `alt` varchar(512) NOT NULL,
    `url` text NOT NULL,
    PRIMARY KEY  (`id_dbmenu_list`, `id_lang`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
