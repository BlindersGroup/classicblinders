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
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbproductcomments` (
    `id_dbproductcomments` int(11) NOT NULL AUTO_INCREMENT,
    `id_product` int(11) NOT NULL,
    `id_customer` int(11) NOT NULL,
    `customer_name` varchar(64),
    `title` varchar(64),
    `content` text NOT NULL,
    `grade` float NOT NULL,
    `characteristic1` float NOT NULL,
    `characteristic2` float NOT NULL,
    `characteristic3` float NOT NULL,
    `recommend` tinyint(1) NOT NULL,
    `validate` tinyint(1) NOT NULL,
    `deleted` tinyint(1) NOT NULL,
    `date_add` datetime NOT NULL,
    PRIMARY KEY  (`id_dbproductcomments`, `id_product`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbproductcomments_mails` (
    `id_order` int(11) NOT NULL,
    `send_mail` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    `date_add` datetime,
    PRIMARY KEY  (`id_order`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
