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

class DbProductCommentsComment extends ObjectModel
{

    public $id;
    public $id_dbproductcomments;
    public $id_product;
    public $id_customer;
    public $customer_name;
    public $title;
    public $content;
    public $grade;
    public $characteristic1;
    public $characteristic2;
    public $characteristic3;
    public $recommend = 0;
    public $validate = 0;
    public $deleted = 0;
    public $date_add;


    public static $definition = array(
        'table' => 'dbproductcomments',
        'primary' => 'id_dbproductcomments',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'id_customer' => array('type' => self::TYPE_INT, 'required' => true, 'validate' => 'isunsignedInt'),
            'customer_name' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isCleanHtml', 'size' => 64),
            'title' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isCleanHtml', 'size' => 64),
            'content' => array('type' => self::TYPE_HTML, 'required' => false),
            'grade' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isunsignedInt'),
            'characteristic1' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isunsignedInt'),
            'characteristic2' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isunsignedInt'),
            'characteristic3' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isunsignedInt'),
            'recommend' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'validate' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'deleted' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'date_add' => array('type' => self::TYPE_DATE),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
    }

    public function add($autoDate = true, $nullValues = false)
    {
        if (!parent::add($autoDate, $nullValues)) {
            return false;
        }

        return true;
    }

    public function update($null_values = false)
    {
        return parent::update($null_values);
    }

    public function isToggleStatus($id){
        $sql = "SELECT validate FROM "._DB_PREFIX_."dbproductcomments WHERE id_dbproductcomments = '$id'";
        $status = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        if($status == 0){
            $active = 1;
        } else {
            $active = 0;
        }
        $update = "UPDATE "._DB_PREFIX_."dbproductcomments SET validate = '$active' WHERE id_dbproductcomments = '$id'";
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($update);

        die(json_encode(
            array(
                'status' => true,
                'message' => 'Actualizado correctamente',
            )
        ));
    }

}
