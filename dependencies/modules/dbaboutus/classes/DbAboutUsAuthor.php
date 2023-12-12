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

require_once _PS_MODULE_DIR_ . 'dbaboutus/dbaboutus.php';

class DbAboutUsAuthor extends ObjectModel
{

    public $id;
    public $id_dbaboutus_author;
    public $name;
    public $email;
    public $profession;
    public $number;
    public $specialties;
    public $id_tag;
    public $short_desc;
    public $large_desc;
    public $views;
    public $twitter;
    public $facebook;
    public $linkedin;
    public $youtube;
    public $instagram;
    public $web;
    public $metatitle;
    public $metadescription;
    public $link_rewrite;
    public $active = 1;
    public $position = 1;

    public static $definition = array(
        'table' => 'dbaboutus_author',
        'primary' => 'id_dbaboutus_author',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'email' =>          array('type' => self::TYPE_STRING, 'required' => true , 'validate' => 'isEmail', 'size' => 128),
            'number' =>         array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 128),
            'specialties' =>    array('type' => self::TYPE_STRING, 'required' => false , 'size' => 255),
            'id_tag' =>         array('type' => self::TYPE_INT, 'required' => false , 'validate' => 'isunsignedInt'),            
            'twitter' =>        array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 255),
            'facebook' =>       array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 255),
            'linkedin' =>       array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 255),
            'youtube' =>        array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 255),
            'instagram' =>      array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 255),
            'web' =>            array('type' => self::TYPE_STRING, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 255),
            'position' =>       array('type' => self::TYPE_INT, 'required' => false , 'validate' => 'isunsignedInt'),            
            'active' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),

            'name' =>           array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true , 'validate' => 'isCleanHtml', 'size' => 128),
            'profession' =>     array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true , 'validate' => 'isCleanHtml', 'size' => 128),
            'short_desc' =>     array('type' => self::TYPE_HTML, 'lang' => true, 'required' => false, 'size' => 512),
            'large_desc' =>     array('type' => self::TYPE_HTML, 'lang' => true, 'required' => false),
            'views' =>          array('type' => self::TYPE_HTML, 'lang' => true, 'required' => false),
            'metatitle' =>	    array('type' => self::TYPE_STRING, 'lang' => true, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 256),
            'metadescription' =>array('type' => self::TYPE_STRING, 'lang' => true, 'required' => false , 'validate' => 'isCleanHtml', 'size' => 256),
            'link_rewrite' =>	array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true , 'validate' => 'isCleanHtml', 'size' => 128),
            
        ),
    );

    public function __construct($id_dbaboutus_author = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_dbaboutus_author, $id_lang, $id_shop);
    }

    public  function add($autodate = true, $null_values = false)
    {
        $this->position = DbAboutUsAuthor::getNewLastPosition();
        $default_language_id = Configuration::get('PS_LANG_DEFAULT');
        foreach ( $this->name as $k => $value ) {
            if ( preg_match( '/^[1-9]\./', $value ) ) {
                $this->name[ $k ] = '0' . $value;
            }
            if(empty($value)) {
                $this->name[$k] = $this->name[$default_language_id];
            }
        }
        foreach ( $this->link_rewrite as $k => $value ) {
            if(empty($value)) {
                $this->link_rewrite[$k] = Tools::link_rewrite($this->name[$k]);
            }
        }
        $ret = parent::add($autodate, $null_values);
        return $ret;
    }

    public function update( $null_values = false ) {

        foreach ( $this->name as $k => $value ) {
            if ( preg_match( '/^[1-9]\./', $value ) ) {
                $this->name[ $k ] = '0' . $value;
            }
        }
        foreach ( $this->link_rewrite as $k => $value ) {
            if(empty($value)) {
                $this->link_rewrite[$k] = Tools::link_rewrite($this->name[$k]);
            }
        }
        return parent::update( $null_values );
    }

    public static function getNewLastPosition()
    {
        return (Db::getInstance()->getValue('
            SELECT IFNULL(MAX(position),0)+1
            FROM `'._DB_PREFIX_.'dbaboutus_author`'
        ));
    }

    public static function getAuthors()
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        
        $sql = "SELECT * 
            FROM "._DB_PREFIX_."dbaboutus_author a
            INNER JOIN "._DB_PREFIX_."dbaboutus_author_lang al 
                ON a.id_dbaboutus_author = al.id_dbaboutus_author 
                    AND al.id_lang = '$id_lang' AND al.id_shop = '$id_shop'
            WHERE a.active = 1
            ORDER BY a.position ASC";
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        foreach($results as $key => $result) {
            $image = $result['id_dbaboutus_author'].'.jpg';
            $results[$key]['image'] = Dbaboutus::getNewImg($image);
        }

        return $results;
    }

    public static function getAuthor($rewrite)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        
        $sql = "SELECT * 
            FROM "._DB_PREFIX_."dbaboutus_author a
            INNER JOIN "._DB_PREFIX_."dbaboutus_author_lang al 
                ON a.id_dbaboutus_author = al.id_dbaboutus_author 
                    AND al.id_lang = '$id_lang' AND al.id_shop = '$id_shop'
            WHERE al.link_rewrite = '$rewrite'";
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);

        $image = $result['id_dbaboutus_author'].'.jpg';
        $result['image'] = Dbaboutus::getNewImg($image);

        return $result;
    }

    public static function getLink($rewrite, $id_lang = null, $id_shop = null)
    {
        return Context::getContext()->link->getModuleLink('dbaboutus', 'author', array('rewrite' => $rewrite));
    }

    public function isToggleStatus($id_author){
        $sql = "SELECT active FROM "._DB_PREFIX_."dbaboutus_author WHERE id_dbaboutus_author = '$id_author'";
        $status = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        if($status == 0){
            $active = 1;
        } else {
            $active = 0;
        }
        $update = "UPDATE "._DB_PREFIX_."dbaboutus_author SET active = '$active' WHERE id_dbaboutus_author = '$id_author'";
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($update);

        die(json_encode(
            array(
                'status' => true,
                'message' => 'Actualizado correctamente',
            )
        ));
    }

    public static function getPosts($id_author, $id_lang, $limit = 10, $page = 0)
    {
        $id_shop = (int)Context::getContext()->shop->id;
        $offset = $page * $limit;
        $sql = "SELECT p.*, pl.*, cl.title as title_category, cl.link_rewrite as link_category
            FROM "._DB_PREFIX_."dbblog_post p
            INNER JOIN "._DB_PREFIX_."dbblog_post_lang pl 
                ON p.id_dbblog_post = pl.id_dbblog_post AND pl.id_lang = '$id_lang'
            INNER JOIN "._DB_PREFIX_."dbblog_category_lang cl ON p.id_dbblog_category = cl.id_dbblog_category
            WHERE p.active = 1 AND p.author = '$id_author'
            GROUP BY p.id_dbblog_post
            ORDER BY date_add DESC
            LIMIT ".$offset.",".$limit;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $posts = array();
        foreach ($result as $row) {
            $comments = DbBlogComment::getTotalCommentsByPost($row['id_dbblog_post']);
            if($comments['total'] == 0){
                $rating = 0;
            } else {
                $rating = round($comments['suma'] * 100 / ($comments['total'] * 5), 0);
            }

            $posts[$row['id_dbblog_post']]['author'] = self::getAuthorById($row['author']);
            $posts[$row['id_dbblog_post']]['id'] = $row['id_dbblog_post'];
            $posts[$row['id_dbblog_post']]['image'] = Dbblog::getNewImg($row['image']);
            $posts[$row['id_dbblog_post']]['url'] = DbBlogPost::getLink($row['link_rewrite'], $id_lang);
            $posts[$row['id_dbblog_post']]['title'] = $row['title'];
            $posts[$row['id_dbblog_post']]['short_desc'] = $row['short_desc'];
            $posts[$row['id_dbblog_post']]['date'] = date_format(date_create($row['date_upd']), 'd/m/Y');
            $posts[$row['id_dbblog_post']]['img'] = _MODULE_DIR_.'dbblog/views/img/post/'.$row['image'];
            $posts[$row['id_dbblog_post']]['title_category'] = $row['title_category'];
            $posts[$row['id_dbblog_post']]['url_category'] = DbBlogCategory::getLink($row['link_category'], $id_lang);
            $posts[$row['id_dbblog_post']]['total_comments'] = $comments['total'];
            $posts[$row['id_dbblog_post']]['rating'] = $rating;
            $posts[$row['id_dbblog_post']]['views'] = $row['views'];
        }
        return $posts;
    }

    public static function getPostsRead($id_author, $id_lang, $limit = 10, $page = 0)
    {
        $offset = $page * $limit;
        $sql = "SELECT p.*, pl.*, cl.title as title_category, cl.link_rewrite as link_category
            FROM "._DB_PREFIX_."dbblog_post p
            INNER JOIN "._DB_PREFIX_."dbblog_post_lang pl ON p.id_dbblog_post = pl.id_dbblog_post AND pl.id_lang = '$id_lang'
            INNER JOIN "._DB_PREFIX_."dbblog_category_lang cl ON p.id_dbblog_category = cl.id_dbblog_category
            WHERE p.active = 1 AND p.author = '$id_author'
            GROUP BY p.id_dbblog_post
            ORDER BY views DESC
            LIMIT ".$offset.",".$limit;
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $posts = array();
        foreach ($result as $row) {
            $comments = DbBlogComment::getTotalCommentsByPost($row['id_dbblog_post']);
            if($comments['total'] == 0){
                $rating = 0;
            } else {
                $rating = round($comments['suma'] * 100 / ($comments['total'] * 5), 0);
            }

            $posts[$row['id_dbblog_post']]['author'] = self::getAuthorById($row['author']);
            $posts[$row['id_dbblog_post']]['id'] = $row['id_dbblog_post'];
            $posts[$row['id_dbblog_post']]['image'] = Dbblog::getNewImg($row['image']);
            $posts[$row['id_dbblog_post']]['url'] = DbBlogPost::getLink($row['link_rewrite'], $id_lang);
            $posts[$row['id_dbblog_post']]['title'] = $row['title'];
            $posts[$row['id_dbblog_post']]['short_desc'] = $row['short_desc'];
            $posts[$row['id_dbblog_post']]['date'] =  date_format(date_create($row['date_upd']), 'd/m/Y');
            $posts[$row['id_dbblog_post']]['img'] = _MODULE_DIR_.'dbblog/views/img/post/'.$row['image'];
            $posts[$row['id_dbblog_post']]['title_category'] = $row['title_category'];
            $posts[$row['id_dbblog_post']]['url_category'] = DbBlogCategory::getLink($row['link_category'], $id_lang);
            $posts[$row['id_dbblog_post']]['total_comments'] = $comments['total'];
            $posts[$row['id_dbblog_post']]['rating'] = $rating;
            $posts[$row['id_dbblog_post']]['views'] = $row['views'];
        }
        return $posts;
    }

    public static function getTotalsOpinionsByAuthor($id_author)
    {
        $sql = "SELECT count(*) as total, SUM(rating) as suma
            FROM "._DB_PREFIX_."dbblog_comment c
            INNER JOIN "._DB_PREFIX_."dbblog_post p ON c.id_post = p.id_dbblog_post AND p.author = '$id_author'
            WHERE approved = 1";
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);

        return $result;
    }

    public static function getOpinionsByAuthor($id_author, $limit = 5)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $sql = "SELECT *, c.date_add as fecha
            FROM "._DB_PREFIX_."dbblog_comment c
            INNER JOIN "._DB_PREFIX_."dbblog_post p ON c.id_post = p.id_dbblog_post AND p.author = '$id_author'
            INNER JOIN "._DB_PREFIX_."dbblog_post_lang pl ON pl.id_dbblog_post = p.id_dbblog_post AND pl.id_lang = '$id_lang'
            WHERE approved = 1 AND c.comment <> ''
            GROUP BY c.id_post
            ORDER BY c.date_add DESC
            LIMIT $limit";
        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $result = [];
        foreach($results as $key => $comment){
            $result[$key]['id_dbblog_comment'] = $comment['id_dbblog_comment'];
            $result[$key]['id_post'] = $comment['id_post'];
            $result[$key]['name'] = $comment['name'];
            $result[$key]['comment'] = strip_tags($comment['comment']);
            $result[$key]['rating'] = $comment['rating'];
            $result[$key]['fecha'] = date('d-m-Y', strtotime($comment['fecha']));
            $result[$key]['title'] = $comment['title'];
            $result[$key]['link_rewrite'] = Context::getContext()->link->getModuleLink('dbblog', 'dbpost', array('rewrite' => $comment['link_rewrite']));
        }

        return $result;
    }

    public static function getAuthorById($id_author)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;
        $sql = "SELECT * 
            FROM "._DB_PREFIX_."dbaboutus_author dba
            INNER JOIN "._DB_PREFIX_."dbaboutus_author_lang dbal 
                ON dba.id_dbaboutus_author = dbal.id_dbaboutus_author 
                    AND dbal.id_lang = '$id_lang' AND dbal.id_shop = '$id_shop'
            WHERE dba.id_dbaboutus_author = '$id_author'";
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);

        $author = array();
        $author['name'] = $result['name'];
        $author['link_rewrite'] = $result['link_rewrite'];
        $author['url'] = self::getLink_author($author['link_rewrite']);
        $author['id'] = $id_author;
        $author['profession'] = $result['profession'];
        $author['description'] = $result['short_desc'];
        $author['twitter'] = $result['twitter'];
        $author['facebook'] = $result['facebook'];
        $author['linkedin'] = $result['linkedin'];
        $author['youtube'] = $result['youtube'];
        $author['instagram'] = $result['instagram'];
        $author['imagen'] = self::getImage($result['id_dbaboutus_author']);
        return $author;
    }

    public static function getLink_author($rewrite, $id_lang = null, $id_shop = null)
    {
        return Context::getContext()->link->getModuleLink('dbaboutus', 'author', array('rewrite' => $rewrite));
    }

    public static function getImage($id_employee)
    {
        $imagen = _PS_MODULE_DIR_.'dbaboutus/views/img/author/'.$id_employee.'.jpg';
        if (file_exists($imagen)) {
            $img = _MODULE_DIR_.'dbaboutus/views/img/author/'.$id_employee.'.jpg';
        } else {
            $img = _MODULE_DIR_.'dbaboutus/views/img/icons/usuario.png';
        }
        return $img;
    }
}
