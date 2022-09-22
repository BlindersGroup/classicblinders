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

class DbAboutUsHomeModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        parent::init();
    }

    public function initContent()
    {
        $id_lang = Context::getContext()->language->id;

        parent::initContent();

        $slug = Configuration::get('DBABOUTUS_URL', $id_lang);
        $title = Configuration::get('DBABOUTUS_TITLE', $id_lang);
        $short_desc = Configuration::get('DBABOUTUS_SHORT_DESC', $id_lang);
        $large_desc = Configuration::get('DBABOUTUS_LARGE_DESC', $id_lang);

        $authors = DbAboutUsAuthor::getAuthors();

        $this->context->smarty->assign(array(
            'slug'    => $slug,
            'title'    => $title,
            'short_desc'    => $short_desc,
            'large_desc'    => $large_desc,
            'authors'    => $authors,
            'path_img' => _MODULE_DIR_.'dbaboutus/views/img/author/',
        ));

        $this->setTemplate('module:dbaboutus/views/templates/front/home.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        // Base Module
        $id_lang = Context::getContext()->language->id;
        $title_about = Configuration::get('DBABOUTUS_TITLE', $id_lang);
        $rewrite_about = Configuration::get('DBABOUTUS_URL', $id_lang);
        $url_about = Context::getContext()->link->getModuleLink('dbaboutus', 'home', array());

        $breadcrumb['links'][] = [
            'title' => $title_about,
            'url'   => $url_about,
        ];

        return $breadcrumb;
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();

        $id_lang = Context::getContext()->language->id;
        $url_about = Context::getContext()->link->getModuleLink('dbaboutus', 'home', array());
        $meta_title = Configuration::get('DBABOUTUS_METATITLE', $id_lang);
        $meta_desc = Configuration::get('DBABOUTUS_METADESC', $id_lang);

        $page['canonical'] = $url_about;
        $page['meta']['title'] = $meta_title;
        $page['meta']['description'] = $meta_desc;
        $page['meta']['robots'] = 'index';

        return $page;
    }
}