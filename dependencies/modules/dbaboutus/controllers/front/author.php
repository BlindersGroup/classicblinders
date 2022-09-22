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

class DbAboutUsAuthorModuleFrontController extends ModuleFrontController
{
    public function init()
    {
        parent::init();
    }

    public function initContent()
    {
        $id_lang = Context::getContext()->language->id;

        parent::initContent();

        $rewrite = Tools::getValue('rewrite');
        $author = DbAboutUsAuthor::getAuthor($rewrite);

        // Redireccionamos a 404 si no encuentra el autor
        if((int)$author['id_dbaboutus_author'] == 0 || $author['active'] == 0){
            Tools::redirect('index.php?controller=404');
        }

        $specialities = DbAboutUsSpeciality::getSpecialitiesByAuthor($author['id_dbaboutus_author']);
        $tag = DbAboutUsTag::getTagByAuthor($author['id_dbaboutus_author']);
        $url_author = Context::getContext()->link->getModuleLink('dbaboutus', 'author', array('rewrite' => $rewrite));
        $title_about = Configuration::get('DBABOUTUS_TITLE', $id_lang);

        $posts = [];
        $posts_more_read = [];
        $total_opiniones = 0;
        $media_opiniones = 0.0;
        $c_active = 0;
        $opiniones = [];
        if($this->module->premium == 1) {
            $datos_blog = DbPremium::connectBlog($author, $id_lang);
            $posts = $datos_blog['posts'];
            $posts_more_read = $datos_blog['posts_more_read'];
            $total_opiniones = $datos_blog['total_opiniones'];
            $media_opiniones = $datos_blog['media_opiniones'];
            $c_active = $datos_blog['c_active'];
            $opiniones = $datos_blog['opiniones'];
        }

        $this->context->smarty->assign(array(
            'author'            => $author,
            'path_img'          => _MODULE_DIR_.'dbaboutus/views/img/author/',
            'specialities'      => $specialities,
            'tag'               => $tag,
            'url_author'        => $url_author,
            'title_about'       => $title_about,
            'posts'             => $posts,
            'posts_more_read'   => $posts_more_read,
            'total_opiniones'   => $total_opiniones,
            'media_opiniones'   => $media_opiniones,
            'opiniones'         => $opiniones,
            'c_active'          => $c_active,
            'premium'           => $this->module->premium,
        ));

        $this->setTemplate('module:dbaboutus/views/templates/front/author.tpl');
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

        // Breadcrumb author
        $rewrite = Tools::getValue('rewrite');
        $author = DbAboutUsAuthor::getAuthor($rewrite);
        $url_author = Context::getContext()->link->getModuleLink('dbaboutus', 'author', array('rewrite' => $rewrite));

        $breadcrumb['links'][] = [
            'title' => $author['name'],
            'url'   => $url_author,
        ];

        return $breadcrumb;
    }

    public function getTemplateVarPage()
    {
        $page = parent::getTemplateVarPage();

        $rewrite = Tools::getValue('rewrite');
        $author = DbAboutUsAuthor::getAuthor($rewrite);
        $url_author = Context::getContext()->link->getModuleLink('dbaboutus', 'author', array('rewrite' => $rewrite));

        $page['canonical'] = $url_author;
        $page['meta']['title'] = $author['metatitle'];
        $page['meta']['description'] = $author['metadescription'];
        $page['meta']['robots'] = 'index';

        return $page;
    }
}