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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dbproductcomments extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbproductcomments';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Product Comments');
        $this->description = $this->l('Es un modulo adicional para mostrar mas datos sobre los comentarios del módulo de comentarios del producto');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayFooterCategory') &&
            $this->registerHook('displayNavCenter');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }


    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/dbproductcomments.css');
        $this->context->controller->addJS($this->_path.'/views/js/dbproductcomments.js');
    }

    public function hookdisplayFooterCategory()
    {
        $controller = Tools::getValue('controller');
        if($controller == 'category') {
            $id_category = (int)Tools::getValue('id_category');
            $category = new Category($id_category, $this->context->language->id);
            $name = $category->name;
            $vals_counts = $this->getMediaValoraciones($id_category);
            $total_comments = $vals_counts['total'];
            if ($total_comments > 0) {
                $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);
                $last_comments = $this->getLastValoraciones('3', $id_category);

                $this->smarty->assign(array(
                    'total_comments' => $total_comments,
                    'media_comments' => $media_comments,
                    'last_comments' => $last_comments,
                    'name' => $name,
                ));
                return $this->fetch('module:dbproductcomments/views/templates/hook/category.tpl');
            }
        } elseif ($controller == 'manufacturer'){
            $id_manufacturer = (int)Tools::getValue('id_manufacturer');
            $manufacturer = new Manufacturer($id_manufacturer, $this->context->language->id);
            $name = $manufacturer->name;
            $vals_counts = $this->getMediaValoracionesBrand($id_manufacturer);
            $total_comments = $vals_counts['total'];
            if ($total_comments > 0) {
                $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);
                $last_comments = $this->getLastValoracionesBrand('3', $id_manufacturer);

                $this->smarty->assign(array(
                    'total_comments' => $total_comments,
                    'media_comments' => $media_comments,
                    'last_comments' => $last_comments,
                    'name' => $name,
                ));
                return $this->fetch('module:dbproductcomments/views/templates/hook/category.tpl');
            }
        }
    }

    public function getMediaValoraciones($id_category = null)
    {

        $sql = "SELECT count(*) as total, SUM(grade) as grade
                FROM "._DB_PREFIX_."product_comment pc
                LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product
                LEFT JOIN "._DB_PREFIX_."category_product cp ON p.id_product = cp.id_product";
        if($id_category > 0) {
            $sql .= " WHERE cp.id_category = '$id_category'";
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
        return $result;
    }

    public function getMediaValoracionesBrand($id_manufacturer = null)
    {

        $sql = "SELECT count(*) as total, SUM(grade) as grade
                FROM "._DB_PREFIX_."product_comment pc
                LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product";
        if($id_manufacturer > 0) {
            $sql .= " WHERE p.id_manufacturer = '$id_manufacturer'";
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
        return $result;
    }

    public function getLastValoraciones($num = 3, $id_category = null)
    {
        $link = new Link();
        $id_lang = $this->context->language->id;
        if($id_category > 0){
            $sql = "SELECT pc.title, pc.grade, pc.id_product, pc.date_add
                    FROM "._DB_PREFIX_."product_comment pc
                    LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product
                    LEFT JOIN "._DB_PREFIX_."category_product cp ON p.id_product = cp.id_product
                    WHERE cp.id_category = '$id_category' AND grade >= 3
                    ORDER BY date_add DESC
                    LIMIT $num";
            $comments = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
            if(is_array($comments) && count($comments) > 0) {
                $result = [];
                foreach ($comments as $comment) {
                    $product = new Product((int)$comment['id_product'], false, $id_lang);
                    $img = $product->getCover($product->id);
                    $image_type = 'small_default';
                    $img_url = $link->getImageLink(isset($product->link_rewrite) ? $product->link_rewrite : $product->name,
                        (int)$img['id_image'], $image_type);
                    $result[] = array(
                        'title' => $comment['title'],
                        'grade' => $comment['grade'],
                        'date_add' => $comment['date_add'],
                        'img' => $img_url,
                        'url' => $link->getProductLink($product->id),
                        'product_name' => $product->name,
                    );
                }
            }
            return $result;
        }
    }

    public function getLastValoracionesBrand($num = 3, $id_manufacturer = null)
    {
        $link = new Link();
        $id_lang = $this->context->language->id;
        if($id_manufacturer > 0){
            $sql = "SELECT pc.title, pc.grade, pc.id_product, pc.date_add
                    FROM "._DB_PREFIX_."product_comment pc
                    LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product
                    WHERE p.id_manufacturer = '$id_manufacturer' AND grade >= 3
                    ORDER BY date_add DESC
                    LIMIT $num";
            $comments = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
            if(is_array($comments) && count($comments) > 0) {
                $result = [];
                foreach ($comments as $comment) {
                    $product = new Product((int)$comment['id_product'], false, $id_lang);
                    $img = $product->getCover($product->id);
                    $image_type = 'small_default';
                    $img_url = $link->getImageLink(isset($product->link_rewrite) ? $product->link_rewrite : $product->name,
                        (int)$img['id_image'], $image_type);
                    $result[] = array(
                        'title' => $comment['title'],
                        'grade' => $comment['grade'],
                        'date_add' => $comment['date_add'],
                        'img' => $img_url,
                        'url' => $link->getProductLink($product->id),
                        'product_name' => $product->name,
                    );
                }
            }
            return $result;
        }
    }

    public function getProductMediaValoraciones($id_product)
    {
        if($id_product > 0){
            $sql = "SELECT count(*) as total, SUM(grade) as grade
                    FROM "._DB_PREFIX_."product_comment
                    WHERE id_product = '$id_product'";
            $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
            return $result;
        }
    }

    public function hookdisplayNavCenter()
    {
        $vals_counts = $this->getMediaValoraciones();
        $total_comments = $vals_counts['total'];
        if($total_comments > 0) {
            $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);

            $this->smarty->assign(array(
                'total_comments' => $total_comments,
                'media_comments' => $media_comments,
            ));
            return $this->fetch('module:dbproductcomments/views/templates/hook/nav.tpl');
        }
    }

    public function hookdisplayProductCenterColumn($params)
    {
        $id_product = (int)$params['product']['id_product'];
        $vals_counts = $this->getProductMediaValoraciones($id_product);
        $total_comments = $vals_counts['total'];
        if($total_comments > 0) {
            $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);

            $this->smarty->assign(array(
                'total_comments' => $total_comments,
                'media_comments' => $media_comments,
            ));
            return $this->fetch('module:dbproductcomments/views/templates/hook/product_centercolumn.tpl');
        }
    }

    public function hookdisplayMenuInside()
    {
        $vals_counts = $this->getMediaValoraciones();
        $total_comments = $vals_counts['total'];
        if($total_comments > 0) {
            $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);

            $this->smarty->assign(array(
                'total_comments' => $total_comments,
                'media_comments' => $media_comments,
            ));
            return $this->fetch('module:dbproductcomments/views/templates/hook/menu.tpl');
        }
    }
}
