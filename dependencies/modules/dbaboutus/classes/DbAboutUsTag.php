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

class DbAboutUsTag extends ObjectModel
{

    public $id;
    public $id_dbaboutus_tag;
    public $name;
    public $active = 1;

    public static $definition = array(
        'table' => 'dbaboutus_tag',
        'primary' => 'id_dbaboutus_tag',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'active' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'name' =>           array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true , 'validate' => 'isCleanHtml', 'size' => 128),
        ),
    );

    public function __construct($id_dbaboutus_author = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id_dbaboutus_author, $id_lang, $id_shop);
    }

    public  function add($autodate = true, $null_values = false)
    {
        foreach ( $this->name as $k => $value ) {
            if ( preg_match( '/^[1-9]\./', $value ) ) {
                $this->name[ $k ] = '0' . $value;
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
        return parent::update( $null_values );
    }

    public static function getTags()
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;

        $sql = "SELECT * 
            FROM "._DB_PREFIX_."dbaboutus_tag t
            INNER JOIN "._DB_PREFIX_."dbaboutus_tag_lang tl 
                ON t.id_dbaboutus_tag = tl.id_dbaboutus_tag 
                    AND tl.id_lang = '$id_lang' AND tl.id_shop = '$id_shop'
            WHERE t.active = 1
            ORDER BY tl.name ASC";
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        return $result;
    }

    public static function getTagByAuthor($id_author)
    {
        $id_lang = (int)Context::getContext()->language->id;
        $id_shop = (int)Context::getContext()->shop->id;

        $sql = "SELECT tl.name
            FROM "._DB_PREFIX_."dbaboutus_tag t
            INNER JOIN "._DB_PREFIX_."dbaboutus_tag_lang tl 
                ON t.id_dbaboutus_tag = tl.id_dbaboutus_tag 
                    AND tl.id_lang = '$id_lang' AND tl.id_shop = '$id_shop'
            INNER JOIN "._DB_PREFIX_."dbaboutus_author a ON a.id_tag = t.id_dbaboutus_tag
            WHERE t.active = 1 AND a.id_dbaboutus_author = '$id_author'";
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $result;
    }

    public function isToggleStatus($id_tag){
        $sql = "SELECT active FROM "._DB_PREFIX_."dbaboutus_tag WHERE id_dbaboutus_tag = '$id_tag'";
        $status = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        if($status == 0){
            $active = 1;
        } else {
            $active = 0;
        }
        $update = "UPDATE "._DB_PREFIX_."dbaboutus_tag SET active = '$active' WHERE id_dbaboutus_tag = '$id_tag'";
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($update);

        die(json_encode(
            array(
                'status' => true,
                'message' => 'Actualizado correctamente',
            )
        ));
    }
}
