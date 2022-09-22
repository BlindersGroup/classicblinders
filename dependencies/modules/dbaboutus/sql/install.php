<?php
/**
 * 2007-2020 PrestaShop
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
 *  @copyright 2007-2020 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbaboutus_author` (
    `id_dbaboutus_author` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(128) NOT NULL,
    `number` varchar(128) NOT NULL,
    `specialties` varchar(255) NOT NULL,
    `id_tag` int(11) NOT NULL,
    `twitter` varchar(255) NOT NULL,
    `facebook` varchar(255) NOT NULL,
    `linkedin` varchar(255) NOT NULL,
    `youtube` varchar(255) NOT NULL,
    `instagram` varchar(255) NOT NULL,
    `web` varchar(255) NOT NULL,
    `position` int(11) NOT NULL,
    `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    PRIMARY KEY  (`id_dbaboutus_author`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbaboutus_author_lang` (
    `id_dbaboutus_author` int(11) NOT NULL AUTO_INCREMENT,
    `id_lang` int(11) NOT NULL,
    `id_shop` int(11) NOT NULL,
    `name` varchar(128) NOT NULL,
    `profession` varchar(128) NOT NULL,
    `short_desc` varchar(512) NOT NULL,
    `large_desc` text NOT NULL,
    `views` text NOT NULL,
    `metatitle` varchar(256) NOT NULL,
    `metadescription` varchar(256) NOT NULL,
    `link_rewrite` varchar(128) NOT NULL,
    PRIMARY KEY  (`id_dbaboutus_author`, `id_lang`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbaboutus_speciality` (
    `id_dbaboutus_speciality` int(11) NOT NULL AUTO_INCREMENT,
    `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    PRIMARY KEY  (`id_dbaboutus_speciality`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbaboutus_speciality_lang` (
    `id_dbaboutus_speciality` int(11) NOT NULL AUTO_INCREMENT,
    `id_lang` int(11) NOT NULL,
    `id_shop` int(11) NOT NULL,
    `name` varchar(128) NOT NULL,
    PRIMARY KEY  (`id_dbaboutus_speciality`, `id_lang`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbaboutus_tag` (
    `id_dbaboutus_tag` int(11) NOT NULL AUTO_INCREMENT,
    `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
    PRIMARY KEY  (`id_dbaboutus_tag`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbaboutus_tag_lang` (
    `id_dbaboutus_tag` int(11) NOT NULL AUTO_INCREMENT,
    `id_lang` int(11) NOT NULL,
    `id_shop` int(11) NOT NULL,
    `name` varchar(128) NOT NULL,
    PRIMARY KEY  (`id_dbaboutus_tag`, `id_lang`, `id_shop`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

// Creamos la especialidad
$id_shop = (int)Context::getContext()->shop->id;
$sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_speciality VALUES (1, 1)";
$sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_speciality VALUES (2, 1)";
$sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_speciality VALUES (3, 1)";
foreach (Language::getLanguages(true) as $lang){
    $sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_speciality_lang (`id_dbaboutus_speciality`, `id_lang`, `id_shop`, `name`) 
        VALUES (1, '".$lang['id_lang']."', '$id_shop', 'Especialidad 1')";
    $sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_speciality_lang (`id_dbaboutus_speciality`, `id_lang`, `id_shop`, `name`) 
        VALUES (2, '".$lang['id_lang']."', '$id_shop', 'Especialidad 2')";
    $sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_speciality_lang (`id_dbaboutus_speciality`, `id_lang`, `id_shop`, `name`) 
        VALUES (3, '".$lang['id_lang']."', '$id_shop', 'Especialidad 3')";
}

// Creamos la etiqueta
$sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_tag VALUES (1, 1)";
foreach (Language::getLanguages(true) as $lang){
    $sql[] = "INSERT INTO ". _DB_PREFIX_ ."dbaboutus_tag_lang (`id_dbaboutus_tag`, `id_lang`, `id_shop`, `name`) 
        VALUES (1, '".$lang['id_lang']."', '$id_shop', 'Ejemplo de experto')";
}

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
