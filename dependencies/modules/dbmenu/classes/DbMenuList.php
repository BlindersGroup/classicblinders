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
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   Commercial license
 */

class DbMenuList extends ObjectModel
{
    public $id;
    public $id_dbmenu_list;
    public $id_parent = 0;
    public $type;
    public $id_item;
    public $strong = 0;
    public $color;
    public $alt;
    public $ofuscate = 0;
    public $featured = 0;
    public $additional = 0;
    public $position = 1;
    public $active = 1;

    public $title;
    public $url;


    public static $definition = array(
        'table' => 'dbmenu_list',
        'primary' => 'id_dbmenu_list',
        'multilang' => true,
        'multilang_shop' => true,
        'fields' => array(
            'id_parent' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
            'type' =>		    array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true),
            'id_item' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'strong' =>		    array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),
            'color' =>		    array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 10),
            'ofuscate' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),
            'additional' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),
            'featured' =>		array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),
            'position' =>		array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => false),
            'active' =>			array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => false),


            // Lang fields
            'title' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'validate' => 'isCleanHtml', 'size' => 255),
            'alt' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'required' => false, 'validate' => 'isCleanHtml', 'size' => 512),
            'url' =>			array('type' => self::TYPE_STRING, 'lang' => true, 'required' => false, 'validate' => 'isUrl', 'size' => 255),
        ),
    );

    public function __construct($id = null, $idLang = null, $idShop = null)
    {
        parent::__construct($id, $idLang, $idShop);
    }

    public function updatePosition($way, $position, $id_parent)
    {
        if (!$res = Db::getInstance()->executeS(
            'SELECT `id_dbmenu_list`, `position`
            FROM `'._DB_PREFIX_.'dbmenu_list`
            ORDER BY `position` ASC'
        )) {
            return false;
        }

        foreach ($res as $upr) {
            if ((int)$upr['id_dbmenu_list'] == (int)$this->id) {
                $moved_upr = $upr;
            }
        }

        if (!isset($moved_upr)) {
            return false;
        }

        return (Db::getInstance()->execute('
            UPDATE `'._DB_PREFIX_.'dbmenu_list`
            SET `position`= `position` '.($way ? '- 1' : '+ 1').'
            WHERE (`position`
            '.($way
                    ? '> '.(int)$moved_upr['position'].' AND `position` <= '.(int)$position
                    : '< '.(int)$moved_upr['position'].' AND `position` >= '.(int)$position).') AND id_parent = "'.$id_parent.'"')
            && Db::getInstance()->execute('
            UPDATE `'._DB_PREFIX_.'dbmenu_list`
            SET `position` = '.(int)$position.'
            WHERE `id_dbmenu_list` = '.(int)$moved_upr['id_dbmenu_list'].' AND id_parent = "'.$id_parent.'"'));
    }

    public static function getMaxPosition()
    {
        return (Db::getInstance()->getValue('
            SELECT MAX(position) FROM `'._DB_PREFIX_.'dbmenu_list`'
            ));
    }

    public static function isToggleStatus($id_dbmenu_list){
        $sql = "SELECT active FROM "._DB_PREFIX_."dbmenu_list WHERE id_dbmenu_list = '$id_dbmenu_list'";
        $status = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        if($status == 0){
            $active = 1;
        } else {
            $active = 0;
        }
        $update = "UPDATE "._DB_PREFIX_."dbmenu_list SET active = '$active' WHERE id_dbmenu_list = '$id_dbmenu_list'";
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($update);

        die(json_encode(
            array(
                'status' => true,
                'message' => 'Actualizado correctamente',
            )
        ));
    }

    public static function isToggleOfuscate($id_dbmenu_list){
        $sql = "SELECT ofuscate FROM "._DB_PREFIX_."dbmenu_list WHERE id_dbmenu_list = '$id_dbmenu_list'";
        $status = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
        if($status == 0){
            $active = 1;
        } else {
            $active = 0;
        }
        $update = "UPDATE "._DB_PREFIX_."dbmenu_list SET ofuscate = '$active' WHERE id_dbmenu_list = '$id_dbmenu_list'";
        Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($update);

        die(json_encode(
            array(
                'status' => true,
                'message' => 'Actualizado correctamente',
            )
        ));
    }


    public static function getContentLink($id_lang, $parent){
        $link = new Link();
        if($parent['type'] == 'url'){
            $url = $parent['url'];
        } else {
            if((int)$parent['id_item'] > 0) {
                $category = new Category($parent['id_item'], $id_lang);
                if($category->id_category) {
                    $url = $link->getCategoryLink($category->id_category, $category->link_rewrite);
                } else {
                    $url = '#';
                }
            } else {
                $url = '#';
            }
        }

        //$url = $parent['url'];

        $img_menu = '';
        if($parent['id_parent'] == 0 && $parent['type'] == 'category'){
            if(file_exists(_PS_CAT_IMG_DIR_.(int)$parent['id_item'].'-0_thumb.jpg')) {
                $img_menu = __PS_BASE_URI__ . 'img/c/' . (int)$parent['id_item'] . '-0_thumb.jpg';
            }
        }

        if(empty($parent['alt'])){
            $alt = $parent['title'];
        } else {
            $alt = $parent['alt'];
        }

        $menu = array(
            'id_dbmenu_list' => $parent['id_dbmenu_list'],
            'ofuscate' => $parent['ofuscate'],
            'title' => $parent['title'],
            'alt' => $alt,
            'url' => $url,
            'img_menu' => $img_menu,
            'id_parent' => $parent['id_parent'],
            'strong' => $parent['strong'],
            'color' => $parent['color'],
            'type' => $parent['type'],
        );

        return $menu;
    }

    public static function getMenuLinks($id_lang, $id_shop){
        $sql = "SELECT * 
                FROM "._DB_PREFIX_."dbmenu_list ml
                INNER JOIN  "._DB_PREFIX_."dbmenu_list_lang mll 
                    ON ml.id_dbmenu_list = mll.id_dbmenu_list AND mll.id_lang = '$id_lang' AND mll.id_shop = '$id_shop'
                WHERE active = 1 AND id_parent = 0
                ORDER BY ml.position ASC";
        $parents_menu = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $menu = [];
        foreach($parents_menu as $parent){

            $menu[$parent['id_dbmenu_list']] = self::getContentLink($id_lang, $parent);

            $childrens = self::getChildrensMenuLinks($id_lang, $parent['id_dbmenu_list'], $id_shop);
            if(is_array($childrens) && count($childrens) > 0){
                $menu[$parent['id_dbmenu_list']]['childrens'] = $childrens;
            }
        }

        return $menu;
    }

    public static function getChildrensMenuLinks($id_lang, $id_parent, $id_shop){
        $sql = "SELECT * 
                FROM "._DB_PREFIX_."dbmenu_list ml
                INNER JOIN  "._DB_PREFIX_."dbmenu_list_lang mll 
                    ON ml.id_dbmenu_list = mll.id_dbmenu_list AND mll.id_lang = '$id_lang' AND mll.id_shop = '$id_shop'
                WHERE active = 1 AND id_parent = ".$id_parent."
                ORDER BY ml.position ASC";
        $childrens = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $menu = [];

        if(is_array($childrens) && count($childrens) > 0){
            foreach($childrens as $children) {
                $menu[$children['id_dbmenu_list']] = self::getContentLink($id_lang, $children);

                $childrens = self::getChildrensMenuLinks($id_lang, $children['id_dbmenu_list'], $id_shop);
                if(is_array($childrens) && count($childrens) > 0){
                    $menu[$children['id_dbmenu_list']]['childrens'] = $childrens;
                }
            }

            return $menu;
        } else {
            return false;
        }

    }

    public static function getFeaturedLink($id_lang, $id_shop){
        $sql = "SELECT * 
                FROM "._DB_PREFIX_."dbmenu_list ml
                INNER JOIN  "._DB_PREFIX_."dbmenu_list_lang mll 
                    ON ml.id_dbmenu_list = mll.id_dbmenu_list AND mll.id_lang = '$id_lang' AND mll.id_shop = '$id_shop'
                WHERE active = 1 AND featured = 1
                ORDER BY ml.position ASC";
        $featureds = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $menu = [];
        foreach($featureds as $featured) {
            $menu[] = self::getContentLink($id_lang, $featured);
        }
        return $menu;
    }

    public static function getAdditionalLink($id_lang, $id_shop){
        $sql = "SELECT * 
                FROM "._DB_PREFIX_."dbmenu_list ml
                INNER JOIN  "._DB_PREFIX_."dbmenu_list_lang mll 
                    ON ml.id_dbmenu_list = mll.id_dbmenu_list AND mll.id_lang = '$id_lang' AND mll.id_shop = '$id_shop'
                WHERE active = 1 AND additional = 1
                ORDER BY ml.position ASC";
        $featureds = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        $menu = [];
        foreach($featureds as $featured) {
            $menu[] = self::getContentLink($id_lang, $featured);
        }
        return $menu;
    }
}
