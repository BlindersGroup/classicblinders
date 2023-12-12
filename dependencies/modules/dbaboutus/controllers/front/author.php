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

        // Detectamos en el caso de tener idiomas que la url tenga la url con el idioma
        $languages = Language::getLanguages();
        if (count($languages) > 1) {
            $path_language = $_SERVER['REQUEST_URI'];
            $iso_code = Language::getIsoById($this->context->language->id);
            $route_prefix = $iso_code . '/';
            if (strpos($path_language, $route_prefix) == false) {
                header("HTTP/1.0 404 Not Found");
                $this->setTemplate('errors/404.tpl');
                return;
            }
        }

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
            if($datos_blog) {
                $posts = $datos_blog['posts'];
                $posts_more_read = $datos_blog['posts_more_read'];
                $total_opiniones = $datos_blog['total_opiniones'];
                $media_opiniones = $datos_blog['media_opiniones'];
                $c_active = $datos_blog['c_active'];
                $opiniones = $datos_blog['opiniones'];
            }
        }

        $json_ld = $this->module->generateBreadcrumbJsonld($this->getBreadcrumbLinks());
        if($this->module->premium == 1) {
            $json_ld .= PHP_EOL.DbPremium::generateAuthorJsonld($author, $url_author);
        }

        $this->context->smarty->assign(array(
            'author'            => $author,
            'path_img'          => _MODULE_DIR_.'dbaboutus/views/img/author/',
            'path_img_posts'    => _MODULE_DIR_.'dbblog/views/img/post/',
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
            'json_ld'           => $json_ld,
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

    public function getTemplateVarUrls()
    {
        $urls = parent::getTemplateVarUrls();

        $languages = Language::getLanguages();
        if (count($languages) > 1) {
            $rewrite = Tools::getValue('rewrite');
            $author = DbAboutUsAuthor::getAuthor($rewrite);
            $id_dbaboutus_author = $author['id_dbaboutus_author'];
            foreach ($urls['alternative_langs'] as $locale => $href_lang) {
                $id_lang = (int)Language::getIdByLocale($locale);
                if ($id_lang > 0) {
                    $sql = "SELECT link_rewrite
                    FROM "._DB_PREFIX_."dbaboutus_author_lang al 
                    WHERE al.id_lang = '$id_lang' AND al.id_dbaboutus_author = '$id_dbaboutus_author'";
                    $link_rewrite = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

                    $url_quienes = Configuration::get('DBABOUTUS_URL', $id_lang);
                    $iso_code = Language::getIsoById($id_lang);
                    $urls['alternative_langs'][$locale] = $urls['base_url'].$iso_code.'/'.$url_quienes.'/'.$link_rewrite.'.html';

                }
            }
        }

        return $urls;
    }
}