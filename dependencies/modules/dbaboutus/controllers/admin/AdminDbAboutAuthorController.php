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

class AdminDbAboutAuthorController extends ModuleAdminController
{

    protected $_defaultOrderBy = 'position';
    protected $_defaultOrderWay = 'ASC';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'dbaboutus_author';
        $this->className = 'DbAboutUsAuthor';
        $this->lang = true;
        // $this->multishop_context = Shop::CONTEXT_ALL;
        $this->position_identifier = 'position';
        $this->_orderWay = $this->_defaultOrderWay;

        parent::__construct();

        $this->fields_list = array(
            'id_dbaboutus_author' => array(
                'title' => $this->trans('ID', array(), 'Admin.Global'),
                'align' => 'center',
                'width' => 30
            ),
            'name' => array(
                'title' => $this->trans('Nombre', array(), 'Admin.Global'),
            ),
            'profession' => array(
                'title' => $this->trans('Cargo en la empresa', array(), 'Admin.Global'),
                'callback' => 'cleanHtml',
                'width' => 500,
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'filter_key' => 'a!position',
                'align' => 'center',
                'class' => 'fixed-width-sm',
                'position' => 'position',
                'width' => 40,
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
            DbAboutUsAuthor::isToggleStatus((int)Tools::getValue('id_dbaboutus_author'));
            return;
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
        $obj = $this->loadObject(true);

        // Sets the title of the toolbar   
        if (Tools::isSubmit('add'.$this->table)) {
            $this->toolbar_title = $this->l('Crear Autor');
        } else {
            $this->toolbar_title = $this->l('Editar Autor');
        }

        $tags = DbAboutUsTag::getTags();
        $specialties = DbAboutUsSpeciality::getSpecialities();

        if((int)Tools::getValue('id_dbaboutus_author') > 0){
            $image = '<div class="col-lg-6"><img src="'._MODULE_DIR_.'dbaboutus/views/img/author/'.(int)Tools::getValue('id_dbaboutus_author').'.jpg" class="img-thumbnail" width="100"></div>';

            $this->fields_value = array(
                'specialties[]' => explode(',', $obj->specialties),
            );
        } else {
            $image = '';

            $this->fields_value = array(
                'specialties[]' => '',
                'position'      => 1,
            );
        }

        // Sets the fields of the form
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Autor'),
                'icon' => 'icon-pencil'
            ),
            
            'input' => array(

                array(
                    'type' => 'hidden',
                    'name' => 'id_dbaboutus_author',
                ),

                array(
                    'type' => 'hidden',
                    'name' => 'position',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Nombre'),
                    'name' => 'name',
                    'required' => true,
                    'lang' => true,
                    'id' => 'name',
                    'class' => 'copy2friendlyUrl',
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Email'),
                    'name' => 'email',
                    'required' => true,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Cargo en la empresa'),
                    'name' => 'profession',
                    'required' => true,
                    'lang' => true,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Nº Colegiado'),
                    'name' => 'number',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'select',
                    'label' => $this->l('Etiqueta de experto'),
                    'name' => 'id_tag',
                    'multiple' => false,
                    'required' => true,
                    'desc' => $this->l('Selecciona la etiqueta'),
                    'options' => array(
                        'id' => 'id_dbaboutus_tag',
                        'query' => $tags,
                        'name' => 'name'
                    )
                ),

                array(
                    'type' => 'textarea',
                    'label' => $this->l('Descripción'),
                    'name' => 'short_desc',
                    'lang' => true,
                    'rows' => 5,
                    'cols' => 40,
                    'autoload_rte' => true,
                ),

                array(
                    'type' => 'file',
                    'label' => $this->l('Imagen'),
                    'display_image' => true,
                    'image' => $image,
                    'name' => 'image',
                    'desc' => $this->l('Subir imagen desde tu ordenador'),
                    'lang' => true,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Twitter'),
                    'name' => 'twitter',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Facebook'),
                    'name' => 'facebook',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Linkedin'),
                    'name' => 'linkedin',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('YouTube'),
                    'name' => 'youtube',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Instagram'),
                    'name' => 'instagram',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Web'),
                    'name' => 'web',
                    'required' => false,
                    'lang' => false,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Meta-título'),
                    'name' => 'metatitle',
                    'required' => false,
                    'lang' => true,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Meta descripción'),
                    'name' => 'metadescription',
                    'required' => false,
                    'lang' => true,
                ),

                array(
                    'type' => 'text',
                    'label' => $this->l('Url'),
                    'name' => 'link_rewrite',
                    'required' => true,
                    'lang' => true,
                ),

                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                ),
                
            ),
        );

        if($this->module->premium == 1){
            $this->fields_form = DbPremium::adminRenderFormAuthor($specialties, $tags, $image);
        }

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

    public function processAdd()
    {
        // loads object
        if (!($object = $this->loadObject(true))) {
            return;
        }

        $specialities = '';
        if(!empty(Tools::getValue('specialties'))) {
            $specialities = implode(",", Tools::getValue('specialties'));
        }
        if(!empty($specialities)) {
            $_POST['specialties'] = $specialities;
        } else {
            $_POST['specialties'] = '';
        }
        $author = parent::processAdd();

        // Imagen
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image_name = $this->saveImg($author->id);
        }

        return $author;
    }

    public function processUpdate()
    {
        // loads object
        if (!($object = $this->loadObject(true))) {
            return;
        }

        $specialities = '';
        if(!empty(Tools::getValue('specialties'))) {
            $specialities = implode(",", Tools::getValue('specialties'));
        }
        if(!empty($specialities)) {
            $_POST['specialties'] = $specialities;
        } else {
            $_POST['specialties'] = '';
        }
        $object = parent::processUpdate();

        // Imagen
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image_name = $this->saveImg($object->id);
        }

        return $object;
    }

    public function processDelete()
    {
        // loads object
        if (!($object = $this->loadObject(true))) {
            return;
        }

        $object = parent::processDelete();

        // Borramos la imagen
        unlink(_PS_MODULE_DIR_.'dbaboutus/views/img/author/'.$object->id.'.jpg');

        return $object;
    }

    public function saveImg($id_author)
    {
        // Guardamos las imagenes
        $type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
        $imagesize = @filesize($_FILES['image']['tmp_name']);
        if (isset($_FILES['image']) &&
            isset($_FILES['image']['tmp_name']) &&
            !empty($_FILES['image']['tmp_name']) &&
            !empty($imagesize) &&
            in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
        ) {
            $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
            $image_name = (int)$id_author.'.jpg';
            if (!move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__).'/../../views/img/author/'.$image_name)) {
                $this->errors[] = $this->l('Error al subir la imagen');
                return false;
            }

            // redimensionamos las imagenes
            $dir_img = dirname(__FILE__).'/../../views/img/author/';
            $img_orig = $dir_img.$image_name;
            $img_small = $dir_img.(int)$id_author.'-small.'.$type;
            $img_big = $dir_img.(int)$id_author.'-big.'.$type;
            list($originalWidth, $originalHeight) = getimagesize($img_orig);
            $ratio = $originalWidth / $originalHeight;
            $height_small = 100 / $ratio;
            $height_big = 250 / $ratio;
            ImageManager::resize($img_orig, $img_small, 100, $height_small);
            ImageManager::resize($img_orig, $img_big, 250, $height_big);

            // Generamos el webp
            $checkWebp = $this->module->checkWebp();
            if($checkWebp && $type != 'webp') {
                $img_small_webp = $img_small.'.webp';
                $img_big_webp = $img_big.'.webp';
                $this->module->convertImageToWebP($img_small, $img_small_webp);
                $this->module->convertImageToWebP($img_big, $img_big_webp);
            }

            if (isset($temp_name)) {
                @unlink($temp_name);
            }

        }

        return $image_name;
    }

    public function cleanHtml($html)
    {
        return strip_tags(Tools::stripslashes($html));
    }

    public function ajaxProcessUpdatePositions()
    {
        $way = (int)(Tools::getValue('way'));
        $id_dbaboutus_author = (int)(Tools::getValue('id'));
        $positions = Tools::getValue('dbaboutus_author');

        foreach ($positions as $position => $value) {
            $pos = explode('_', $value);

            $id_dbaboutus_author = (int)$pos[2];

            if ((int)$id_dbaboutus_author > 0) {
                if ($DbAboutUsAuthor = new DbAboutUsAuthor($id_dbaboutus_author)) {
                    $DbAboutUsAuthor->position = $position+1;
                    if ($DbAboutUsAuthor->update()) {
                        echo 'Posicion '.(int)$position.' para la categoria '.(int)$DbAboutUsAuthor->id.' actualizada\r\n';
                    }
                } else {
                    echo '{"hasError" : true, "errors" : "This category ('.(int)$id_dbaboutus_author.') cant be loaded"}';
                }

            }
        }
    }
}