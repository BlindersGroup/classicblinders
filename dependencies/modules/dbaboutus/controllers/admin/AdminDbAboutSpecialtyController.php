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

class AdminDbAboutSpecialtyController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'dbaboutus_speciality';
        $this->className = 'DbAboutUsSpeciality';
        $this->lang = true;
        //$this->multishop_context = Shop::CONTEXT_ALL;

        parent::__construct();

        $this->fields_list = array(
            'id_dbaboutus_speciality' => array(
                'title' => $this->trans('ID', array(), 'Admin.Global'),
                'align' => 'center',
                'width' => 30
            ),
            'name' => array(
                'title' => $this->trans('Nombre', array(), 'Admin.Global'),
            ),
            'active' => array(
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
            DbAboutUsSpeciality::isToggleStatus((int)Tools::getValue('id_dbaboutus_speciality'));
        }
        return parent::initProcess();
    }

    public function renderList()
    {
        // removes links on rows
        $this->list_no_link = true;

        if (Shop::getContext() == Shop::CONTEXT_SHOP && Shop::isFeatureActive()) {
            $this->_where = ' AND b.`id_shop` = '.(int)Context::getContext()->shop->id;
        }

        // adds actions on rows
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    public function renderForm()
    {

        // Sets the title of the toolbar
        
        if (Tools::isSubmit('add'.$this->table)) {
            $this->toolbar_title = $this->l('Crear Especialidad');
        } else {
            $this->toolbar_title = $this->l('Editar Especialidad');
        }

        // Sets the fields of the form
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Especialidad'),
                'icon' => 'icon-pencil'
            ),
            
            'input' => array(

                array(
                    'type' => 'hidden',
                    'name' => 'id_dbaboutus_speciality',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Nombre'),
                    'name' => 'name',
                    'required' => true,
                    'lang' => true,
                ),

                array(
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
                ),
                
            ),
        );

        $this->fields_form['submit'] = array(
            'title' => $this->trans('Save', array(), 'Admin.Actions'),
        );

        $this->fields_form['buttons'] = array(
            'save-and-stay' => array(
                'title' => $this->trans('Guardar y permanecer', array(), 'Admin.Actions'),
                'name' => 'submitAdd'.$this->table.'AndStay',
                'type' => 'submit',
                'class' => 'btn btn-default pull-right',
                'icon' => 'process-icon-save'
            )
        );

        return parent::renderForm();
    }

    public function cleanHtml($html)
    {
        return strip_tags(Tools::stripslashes($html));
    }

}