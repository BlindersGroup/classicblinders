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

class AdminDbMenuListController extends ModuleAdminController
{
    protected $_defaultOrderBy = 'position';
    protected $_defaultOrderWay = 'ASC';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'dbmenu_list';
        $this->className = 'DbMenuList';
        $this->lang = true;
        $this->position_identifier = 'position';
        $this->_orderWay = $this->_defaultOrderWay;

        parent::__construct();

        $this->fields_list = array(
            'title' => array(
                'title' => $this->trans('Titulo', array(), 'Admin.Global'),
            ),
            'type' => array(
                'title' => $this->trans('Tipo link', array(), 'Admin.Global'),
            ),
            'url' => array(
                'title' => $this->trans('Url', array(), 'Admin.Global'),
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'filter_key' => 'a!position',
                'align' => 'center',
                'class' => 'fixed-width-sm',
                'position' => 'position'
            ),
            'ofuscate' => array(
                'title' => 'Ofuscado',
                'active' => 'ofuscate',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'ajax' => true,
                'orderby' => false,
                'search' => false,
            ),
            'active' => array(
                'title' => 'Activo',
                'active' => 'status',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'ajax' => true,
                'orderby' => false,
                'search' => false,
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
        if (Tools::getIsset('status'.$this->table))
        {
            DbMenuList::isToggleStatus((int)Tools::getValue('id_dbmenu_list'));
            return;
        }

        if (Tools::getIsset('ofuscate'.$this->table))
        {
            DbMenuList::isToggleOfuscate((int)Tools::getValue('id_dbmenu_list'));
            return;
        }

        return parent::initProcess();
    }

    public function renderList()
    {
        // removes links on rows
        $this->list_no_link = true;

        $this->_where = ' AND a.`id_parent` = 0
             AND b.`id_shop` = '.(int)Context::getContext()->shop->id;

        // adds actions on rows
        $this->addRowAction('view');
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    public function initToolbar()
    {
        // gets necessary objects
        $id_dbmenu_list = (int)Tools::getValue('id_dbmenu_list');
        if (($id_dbmenu_list)) {
            $this->toolbar_btn['add_with_parent'] = array(
                'short' => $this->l('Añadir nuevo'),
                'href' => self::$currentIndex . '&adddbmenu_list&id_parent='.$id_dbmenu_list.'&token='.$this->token,
                'desc' => $this->l('Añadir nuevo'),
                'class' => 'process-icon-new',
            );
        }

        parent::initToolbar();

    }

    public function renderView()
    {

        // gets necessary objects
        $id_dbmenu_list = (int)Tools::getValue('id_dbmenu_list');

        // return parent::renderView();

        if (($id_dbmenu_list)) {
            $this->_where = 'AND a.`id_parent` = '.(int)$id_dbmenu_list;
        }
        $this->position_identifier = 'position';
        $this->_orderWay = $this->_defaultOrderWay;

        // removes links on rows
        $this->list_no_link = true;

        // adds actions on rows
        $this->addRowAction('view');
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    public function renderForm()
    {

        // Sets the title of the toolbar
        if (Tools::isSubmit('add'.$this->table)) {
            $this->toolbar_title = $this->l('Crear nuevo link menu');
        } else {
            $this->toolbar_title = $this->l('Actualizar link');
        }

        // Select con los tipos de enlaces
        $types = array(
            array(
                'id_type' => 'category',
                'type' => 'category',
            ),
            array(
                'id_type' => 'url',
                'type' => 'url',
            ),
            array(
                'id_type' => 'separator',
                'type' => 'Separador',
            ),
        );

        // valores guardados
        if (Tools::getValue('id_dbmenu_list') != null) {
            $id_lang = $this->context->language->id;
            $menu = new DbMenuList((int)Tools::getValue('id_dbmenu_list'), $id_lang);
            $this->fields_value = array(
                'id_parent' => $menu->id_parent,
            );
            $selected_categories = [$menu->id_item];

        } else {
            $id_parent = (int)Tools::getValue('id_parent');
            $this->fields_value = array(
                'id_parent' => $id_parent,
            );
            $selected_categories = [];
        }

        // Sets the fields of the form
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Menu'),
                'icon' => 'icon-pencil'
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'name' => 'id_dbmenu_list',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'id_parent',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->trans('Titulo', array(), 'Admin.Global'),
                    'name' => 'title',
                    'lang' => true,
                    'maxlength' => 255,
                    'required' => true,
                    'hint' => $this->trans('Nombre del link', array(), 'Admin.Global'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->trans('Tipo de link', array(), 'Admin.Global'),
                    'name' => 'type',
                    'lang' => false,
                    'options' => array(
                        'query' => $types,
                        'id' => 'id_type',
                        'name' => 'type',
                    ),
                    'maxlength' => 255,
                    'required' => true,
                    'id' => 'type_selected',
                ),
                array(
                    'type'  => 'categories',
                    'label' => $this->trans('Categoría', array(), 'Admin.Global'),
                    'name'  => 'id_item',
                    'id' => 'categories_selected',
                    'required' => true,
                    'tree'  => array(
                        'id' => 'exclude_cats',
                        'use_checkbox' => false,
                        'use_search'  => true,
                        'selected_categories' => $selected_categories,
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->trans('Url', array(), 'Admin.Global'),
                    'name' => 'url',
                    'id' => 'url_selected',
                    'required' => false,
                    'lang' => true,
                    'maxlength' => 255,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->trans('Title link', array(), 'Admin.Global'),
                    'name' => 'alt',
                    'lang' => true,
                    'maxlength' => 255,
                    'required' => false,
                    'desc' => $this->trans('Title personalizado del enlace', array(), 'Admin.Global'),
                    'disabled' => true,
                    'class' => 'disabled',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Negrita', array(), 'Admin.Global'),
                    'desc' => $this->trans('Resaltar el enlace en negrita', array(), 'Admin.Global'),
                    'name' => 'strong',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'strong_on',
                            'value' => 1,
                            'label' => $this->trans('Yes', array(), 'Admin.Global')
                        ),
                        array(
                            'id' => 'strong_off',
                            'value' => 0,
                            'label' => $this->trans('No', array(), 'Admin.Global')
                        )
                    ),
                    'disabled' => true,
                ),
                array(
                    'type' => 'color',
                    'label' => $this->trans('Color', array(), 'Admin.Global'),
                    'desc' => $this->trans('Color personalizado del enlace, no rellenar para color por defecto', array(), 'Admin.Global'),
                    'name' => 'color',
                    'disabled' => true,
                    'class' => 'disabled',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Ofuscado', array(), 'Admin.Global'),
                    'desc' => $this->trans('Ocultar el enlace a Google', array(), 'Admin.Global'),
                    'name' => 'ofuscate',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'ofuscate_on',
                            'value' => 1,
                            'label' => $this->trans('Yes', array(), 'Admin.Global')
                        ),
                        array(
                            'id' => 'ofuscate_off',
                            'value' => 0,
                            'label' => $this->trans('No', array(), 'Admin.Global')
                        )
                    ),
                    'disabled' => true,
                ),
            ),
        );

        $id_parent = Tools::getValue('id_parent');
        if($id_parent == null) {
            $this->fields_form['input'][] = array(
                'type' => 'switch',
                'label' => $this->trans('Barra menú izquierda', array(), 'Admin.Global'),
                'desc' => $this->trans('Mostrar el enlace en la barra del menu en la parte izquierda', array(), 'Admin.Global'),
                'name' => 'additional',
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'featured_on',
                        'value' => 1,
                        'label' => $this->trans('Yes', array(), 'Admin.Global')
                    ),
                    array(
                        'id' => 'featured_off',
                        'value' => 0,
                        'label' => $this->trans('No', array(), 'Admin.Global')
                    )
                ),
                'disabled' => true,
            );
            $this->fields_form['input'][] = array(
                'type' => 'switch',
                'label' => $this->trans('Barra menú derecha', array(), 'Admin.Global'),
                'desc' => $this->trans('Mostrar el enlace en la barra del menu en la parte derecha', array(), 'Admin.Global'),
                'name' => 'featured',
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'featured_on',
                        'value' => 1,
                        'label' => $this->trans('Yes', array(), 'Admin.Global')
                    ),
                    array(
                        'id' => 'featured_off',
                        'value' => 0,
                        'label' => $this->trans('No', array(), 'Admin.Global')
                    )
                ),
                'disabled' => true,
            );
        }

        $this->fields_form['input'][] = array(
            'type' => 'switch',
            'label' => $this->trans('Active', array(), 'Admin.Global'),
            'name' => 'active',
            'is_bool' => true,
            'values' => array(
                array(
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->trans('Yes', array(), 'Admin.Global')
                ),
                array(
                    'id' => 'active_off',
                    'value' => 0,
                    'label' => $this->trans('No', array(), 'Admin.Global')
                )
            ),
        );

        $this->fields_form['submit'] = array(
            'title' => $this->trans('Save', array(), 'Admin.Actions'),
        );

        if($this->module->premium == 1){
            $this->fields_form = DbMenuPremium::renderFormPremium($this->fields_form);
        }

        return parent::renderForm();
    }

    public function processAdd()
    {
        if(Tools::getValue('type') == 'category' && empty(Tools::getValue('id_item'))) {
            $this->errors[] = $this->l('Tienes que seleccionar una categoría');
            return;
        }

        $object = parent::processAdd();

        if (is_object($object) && $object->id > 0) {
            $object->position = (int)DbMenuList::getMaxPosition() + 1;
            $object->update();
        }

        return $object;
    }

    public function ajaxProcessUpdatePositions()
    {
        $way = (int)(Tools::getValue('way'));
        $id = (int)(Tools::getValue('id'));
        $positions = Tools::getValue($this->table);

        foreach($positions as $key => $valor){
            $pos = explode('_', $valor);

            if ($pr = new DbMenuList((int)$pos[2])) {
                $id_parent = $pr->id_parent;
                //if (isset($key) && $pr->updatePosition($way, $key)) {
                if (isset($key) && $pr->updatePosition($way, $key, $id_parent)) {
                    echo 'ok position '.(int)$key.' for id '.(int)$pos[1].'\r\n';
                } else {
                    echo '{"hasError" : true, "errors" : "Can not update product '.(int)$id.' to position '.(int)$key.' "}';
                }
            } else {
                echo '{"hasError" : true, "errors" : "This product ('.(int)$id.') can not be loaded"}';
            }
        }

    }
}
