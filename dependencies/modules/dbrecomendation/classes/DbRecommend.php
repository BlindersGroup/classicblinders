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

class DbRecommend extends ObjectModel
{

    public $id;
    public $id_product;
    public $id_author;
    public $recomendation;

    public static $definition = array(
        'table' => 'dbrecomendation',
        'primary' => 'id_dbrecomendation',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isunsignedInt'),
            'id_author' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isunsignedInt'),
            'recomendation' => array('type' => self::TYPE_HTML, 'lang' => true, 'required' => false),
        ),
    );

    public function __construct($id_dbaboutus_author = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_dbaboutus_author, $id_lang, $id_shop);
    }

    public function getIdRecommendByProduct($id_product){
        $sql = "SELECT id_dbrecomendation FROM "._DB_PREFIX_."dbrecomendation WHERE id_product = '$id_product'";
        $id_recommendation = Db::getInstance()->getValue($sql);
        return $id_recommendation;
    }

    public function getRecommendByProduct($id_product, $id_lang, $id_shop){
        $sql = "SELECT * 
            FROM "._DB_PREFIX_."dbrecomendation r
            INNER JOIN  "._DB_PREFIX_."dbrecomendation_lang rl
                ON r.id_dbrecomendation = rl.id_dbrecomendation AND rl.id_lang = '$id_lang' AND rl.id_shop = '$id_shop'
            WHERE r.id_product = '$id_product'";
        $recommendation = Db::getInstance()->getRow($sql);
        return $recommendation;
    }

    public function getAuthors()
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
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        return $result;
    }

    public static function getRecommend($id_product, $id_lang, $id_shop){
        $sql = "SELECT r.*, rl.*, a.*, al.*, tl.name as tag
            FROM "._DB_PREFIX_."dbrecomendation r
            INNER JOIN  "._DB_PREFIX_."dbrecomendation_lang rl
                ON r.id_dbrecomendation = rl.id_dbrecomendation AND rl.id_lang = '$id_lang' AND rl.id_shop = '$id_shop'
            INNER JOIN "._DB_PREFIX_."dbaboutus_author a
                ON r.id_author = a.id_dbaboutus_author
            INNER JOIN "._DB_PREFIX_."dbaboutus_author_lang al
                ON a.id_dbaboutus_author = al.id_dbaboutus_author AND al.id_lang = '$id_lang' AND al.id_shop = '$id_shop'
            INNER JOIN "._DB_PREFIX_."dbaboutus_tag_lang tl
                ON a.id_tag = tl.id_dbaboutus_tag AND tl.id_lang = '$id_lang' AND tl.id_shop = '$id_shop'
            WHERE r.id_product = '$id_product' AND a.active = 1";
        $recommendation = Db::getInstance()->getRow($sql);

        $result = [
            'img' => _MODULE_DIR_ . 'dbaboutus/views/img/author/' . $recommendation['id_author'] . '.jpg',
            'name_author' => $recommendation['name'],
            'profession' => $recommendation['profession'],
            'tag' => $recommendation['tag'],
            'url_author' => Context::getContext()->link->getModuleLink('dbaboutus', 'author', array('rewrite' => $recommendation['link_rewrite'])),
            'recomendation' => $recommendation['recomendation']
        ];

        return $result;
    }
}