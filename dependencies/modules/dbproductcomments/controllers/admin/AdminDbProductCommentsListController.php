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
 *  @author    DevBlinders <info@devblinders.com>
 *  @copyright 2007-2020 DevBlinders
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class AdminDbProductCommentsListController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'dbproductcomments';
        $this->className = 'DbProductCommentsComment';
        $this->lang = false;
        //$this->multishop_context = Shop::CONTEXT_ALL;

        parent::__construct();

        $this->fields_list = array(
            'id_dbproductcomments' => array(
                'title' => $this->trans('ID', array(), 'Admin.Global'),
                'align' => 'center',
                'width' => 30
            ),
            'name' => array(
                'title' => $this->trans('Producto', array(), 'Admin.Global'),
            ),
            'customer_name' => array(
                'title' => $this->trans('Usuario', array(), 'Admin.Global'),
            ),
            'title' => array(
                'title' => $this->trans('Título', array(), 'Admin.Global'),
            ),
            'grade' => array(
                'title' => $this->trans('Puntuación', array(), 'Admin.Global'),
            ),
            'validate' => array(
                'title' => 'Activo',
                'active' => 'status',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'ajax' => true,
                'orderby' => false,
                'search' => true,
                'width' => 25,
            ),
            'date_add' => array(
                'title' => $this->trans('Fecha', array(), 'Admin.Global'),
            ),
        );
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            )
        );

    }

    public function initProcess()
    {
        $isStatusAction = Tools::getIsset('status'.$this->table);
        if ($isStatusAction)
        {
            DbProductCommentsComment::isToggleStatus((int)Tools::getValue('id_dbproductcomments'));
        }
        return parent::initProcess();
    }

    public function renderList()
    {
        // removes links on rows
        $this->list_no_link = true;

        $this->_select = 'pl.*';
        $this->_join = "INNER JOIN "._DB_PREFIX_."product_lang pl ON a.id_product = pl.id_product AND pl.id_lang = ".(int)Context::getContext()->language->id;
        if (Shop::getContext() == Shop::CONTEXT_SHOP && Shop::isFeatureActive()) {
            $this->_where = ' AND b.`id_shop` = '.(int)Context::getContext()->shop->id;
        }

        // adds actions on rows
        $this->addRowAction('delete');

        return parent::renderList();
    }

}
