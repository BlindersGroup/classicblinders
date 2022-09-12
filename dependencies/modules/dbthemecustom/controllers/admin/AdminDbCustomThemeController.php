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

if (!defined('_PS_VERSION_'))
    exit;

class AdminDbCustomThemeController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->lang = true;

        parent::__construct();

    }

    public function initProcess()
    {

        if(Tools::getIsset('submitDbthemecustomModule')){
            $this->saveData();
        }

        return parent::initProcess();
    }

    public function renderList()
    {
        $iframe = $this->module->display(_PS_MODULE_DIR_.$this->module->name, '/views/templates/admin/iframe.tpl');
        $iframe_bottom = $this->module->display(_PS_MODULE_DIR_.$this->module->name, '/views/templates/admin/iframe_bottom.tpl');

        return $iframe.$this->renderForm().$iframe_bottom;
    }

    public function renderForm()
    {
        
        $forms = [];
        $options_images = array(
            array(
                'id_option' => 0,
                'name' => $this->l('Sin miniaturas')
            ),
            array(
                'id_option' => 1,
                'name' => $this->l('Abajo')
            ),
            array(
                'id_option' => 2,
                'name' => $this->l('Lateral')
            ),
        );
        $options_width = array(
            array(
                'id_option' => 0,
                'name' => $this->l('Normal')
            ),
            array(
                'id_option' => 1,
                'name' => $this->l('Ancho completo')
            ),
        );
        $options_product_columns = array(
            array(
                'id_option' => 2,
                'name' => $this->l('2 columnas')
            ),
            array(
                'id_option' => 3,
                'name' => $this->l('3 columnas')
            ),
        );
        $options_product_desc = array(
            array(
                'id_option' => 0,
                'name' => $this->l('Acordeón')
            ),
            array(
                'id_option' => 1,
                'name' => $this->l('Siempre abierto')
            ),
        );

        // General
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración General'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Logo width'),
                        'desc' => $this->l('Ancho en px del logo, ejem: 128 (si lo pone demasiado ancho puede descuadrar la cabecera)'),
                        'name' => 'DBTHEMECUSTOM_LOGO_WIDTH',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Logo height'),
                        'desc' => $this->l('Alto en px del logo, ejem: 34'),
                        'name' => 'DBTHEMECUSTOM_LOGO_HEIGHT',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Google Font'),
                        'desc' => $this->l('Si desea personalizar la tipografía inserte el nombre de Google Font, https://fonts.google.com/'),
                        'name' => 'DBTHEMECUSTOM_GOOGLE_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color Primario'),
                        'desc' => $this->l('Color primario de la plantilla'),
                        'name' => 'DBTHEMECUSTOM_PRIMARY_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color Secundario'),
                        'desc' => $this->l('Color secundario de la plantilla'),
                        'name' => 'DBTHEMECUSTOM_SECOND_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background general'),
                        'desc' => $this->l('Color genérico de fondo'),
                        'name' => 'DBTHEMECUSTOM_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color fuente'),
                        'desc' => $this->l('Color genérico de la fuente'),
                        'name' => 'DBTHEMECUSTOM_COLOR_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color enlace'),
                        'desc' => $this->l('Color genérico de los enlaces'),
                        'name' => 'DBTHEMECUSTOM_COLOR_LINK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color hover'),
                        'desc' => $this->l('Color genérico del hover'),
                        'name' => 'DBTHEMECUSTOM_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Icono visa'),
                        'name' => 'DBTHEMECUSTOM_PAYMENT_VISA',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar icono de Visa'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Icono mastercard'),
                        'name' => 'DBTHEMECUSTOM_PAYMENT_MASTERCARD',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar icono de MasterCard'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Icono maestro'),
                        'name' => 'DBTHEMECUSTOM_PAYMENT_MAESTRO',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar icono de Maestro'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Icono paypal'),
                        'name' => 'DBTHEMECUSTOM_PAYMENT_PAYPAL',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar icono de Paypal'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Icono bizum'),
                        'name' => 'DBTHEMECUSTOM_PAYMENT_BIZUM',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar icono de Bizum'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // Buttons
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración Botones'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background botón Primario'),
                        'desc' => $this->l('Color de fondo del boton primario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_P_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto botón Primario'),
                        'desc' => $this->l('Color del texto del boton primario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_P_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde botón Primario'),
                        'desc' => $this->l('Color del borde del boton primario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_P_BORDER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background hover botón Primario'),
                        'desc' => $this->l('Color de fondo del hover del boton primario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_P_BK_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto hover botón Primario'),
                        'desc' => $this->l('Color del texto del hover del boton primario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde hover botón Primario'),
                        'desc' => $this->l('Color del borde hover del boton primario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_P_BORDER_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background botón Secundario'),
                        'desc' => $this->l('Color de fondo del boton secundario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_S_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto botón Secundario'),
                        'desc' => $this->l('Color del texto del boton secundario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_S_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde botón Secundario'),
                        'desc' => $this->l('Color del borde del boton Secundario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_S_BORDER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background hover botón Secundario'),
                        'desc' => $this->l('Color de fondo del hover del boton secundario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_S_BK_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto hover botón Secundario'),
                        'desc' => $this->l('Color del texto del hover del boton secundario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde hover botón Secundario'),
                        'desc' => $this->l('Color del borde hover del boton Secundario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_S_BORDER_HOVER',
                    ),

                    array(
                        'type' => 'color',
                        'label' => $this->l('Background botón Terciario'),
                        'desc' => $this->l('Color de fondo del boton terciario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_T_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto botón Terciario'),
                        'desc' => $this->l('Color del texto del boton terciario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_T_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde botón Terciario'),
                        'desc' => $this->l('Color del borde del boton terciario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_T_BORDER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background hover botón Terciario'),
                        'desc' => $this->l('Color de fondo del hover del boton terciario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_T_BK_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto hover botón Terciario'),
                        'desc' => $this->l('Color del texto del hover del boton terciario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_T_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde hover botón Terciario'),
                        'desc' => $this->l('Color del borde hover del boton terciario'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_T_BORDER_HOVER',
                    ),

                    array(
                        'type' => 'color',
                        'label' => $this->l('Background botón Especial'),
                        'desc' => $this->l('Boton mas destacado call to action, normalmente boton comprar'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto botón Especial'),
                        'desc' => $this->l('Boton mas destacado call to action, normalmente boton comprar'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_COLOR',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde botón Especial'),
                        'desc' => $this->l('Boton mas destacado call to action, normalmente boton comprar'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_BORDER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background hover botón Especial'),
                        'desc' => $this->l('Boton mas destacado call to action, normalmente boton comprar'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_BK_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto hover botón Especial'),
                        'desc' => $this->l('Boton mas destacado call to action, normalmente boton comprar'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color borde hover botón Especial'),
                        'desc' => $this->l('Boton mas destacado call to action, normalmente boton comprar'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_BORDER_HOVER',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // Header
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración Cabecera'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Ancho de la cabecera'),
                        'name' => 'DBTHEMECUSTOM_HEADER_WIDTH',
                        'desc' => $this->l('Selecciona el tipo de ancho de la cabecera que quieras en la plantilla'),
                        'options' => array(
                            'query' => $options_width,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('DisplayNav'),
                        'name' => 'DBTHEMECUSTOM_DISPLAYNAV',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar la barra superior de la cabecera'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background TopBar'),
                        'desc' => $this->l('Color de fondo para la barra superior de la cabecera'),
                        'name' => 'DBTHEMECUSTOM_TOPBAR_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto TopBar'),
                        'desc' => $this->l('Color de los textos del topbar'),
                        'name' => 'DBTHEMECUSTOM_TOPBAR_COLOR_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color enlaces TopBar'),
                        'desc' => $this->l('Color de los enlaces del topbar'),
                        'name' => 'DBTHEMECUSTOM_TOPBAR_COLOR_LINK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color hover TopBar'),
                        'desc' => $this->l('Color del hover de los enlaces del topbar'),
                        'name' => 'DBTHEMECUSTOM_TOPBAR_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Header'),
                        'desc' => $this->l('Color de fondo para la cabecera'),
                        'name' => 'DBTHEMECUSTOM_HEADER_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto Header'),
                        'desc' => $this->l('Color de los textos de la cabecera'),
                        'name' => 'DBTHEMECUSTOM_HEADER_COLOR_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color enlaces Header'),
                        'desc' => $this->l('Color de los enlaces de la cabecera'),
                        'name' => 'DBTHEMECUSTOM_HEADER_COLOR_LINK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color hover Header'),
                        'desc' => $this->l('Color del hover de los enlaces de la cabecera'),
                        'name' => 'DBTHEMECUSTOM_HEADER_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Buscador'),
                        'desc' => $this->l('Color de fondo para el buscador'),
                        'name' => 'DBTHEMECUSTOM_SEARCH_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto Buscador'),
                        'desc' => $this->l('Color del texto del buscador'),
                        'name' => 'DBTHEMECUSTOM_SEARCH_COLOR_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color iconos'),
                        'desc' => $this->l('Color de los iconos carrito, login y favoritos'),
                        'name' => 'DBTHEMECUSTOM_COLOR_ICONS_HEADER',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // FOOTER
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración Footer'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Ancho del footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTER_WIDTH',
                        'desc' => $this->l('Selecciona el tipo de ancho del footer que quieras en la plantilla'),
                        'options' => array(
                            'query' => $options_width,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background PreFooter'),
                        'desc' => $this->l('Color de fondo para la barra superior del prefooter'),
                        'name' => 'DBTHEMECUSTOM_PREFOOTER_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto PreFooter'),
                        'desc' => $this->l('Color de los textos del prefooter'),
                        'name' => 'DBTHEMECUSTOM_PREFOOTER_COLOR_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color enlaces PreFooter'),
                        'desc' => $this->l('Color de los enlaces del prefooter'),
                        'name' => 'DBTHEMECUSTOM_PREFOOTER_COLOR_LINK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color hover PreFooter'),
                        'desc' => $this->l('Color del hover de los enlaces del prefooter'),
                        'name' => 'DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Footer'),
                        'desc' => $this->l('Color de fondo para el footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTER_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto Footer'),
                        'desc' => $this->l('Color de los textos del footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTER_COLOR_FONT',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color enlaces Footer'),
                        'desc' => $this->l('Color de los enlaces del footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTER_COLOR_LINK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color hover Footer'),
                        'desc' => $this->l('Color del hover de los enlaces del footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTER_COLOR_HOVER',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Copyright'),
                        'desc' => $this->l('Color de fondo para el footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTERCOPY_BK',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Color texto Copyright'),
                        'desc' => $this->l('Color de los textos del footer'),
                        'name' => 'DBTHEMECUSTOM_FOOTERCOPY_COLOR_FONT',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // Categorias
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración Categorías'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar imagen categoría'),
                        'name' => 'DBTHEMECUSTOM_CATEGORY_IMG',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar la imagen de la categoría a la derecha de la descripción corta'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar subcategorias'),
                        'name' => 'DBTHEMECUSTOM_SUBCATEGORIES',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar las subcategorias con sus imágenes en la ficha de categoria?'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar botón listado'),
                        'name' => 'DBTHEMECUSTOM_BUTTON_BUY',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar el botón de comprar en los listados de productos'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Imágen secundaria'),
                        'name' => 'DBTHEMECUSTOM_SECOND_IMG',
                        'is_bool' => true,
                        'desc' => $this->l('Mostrar la imagen secundaria de los productos en el hover de los listados'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // Productos
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración Productos'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Miniaturas productos'),
                        'name' => 'DBTHEMECUSTOM_PRODUCTIMG',
                        'desc' => $this->l('Mostrar las miniaturas de las imágenes de productos en la ficha de producto'),
                        'options' => array(
                            'query' => $options_images,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Columnas'),
                        'name' => 'DBTHEMECUSTOM_PRODUCT_COLUMNS',
                        'desc' => $this->l('Estructura de columnas en la parte superior de la ficha de productos'),
                        'options' => array(
                            'query' => $options_product_columns,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'lang' => true,
                        'label' => $this->l('Bloque descripciones'),
                        'name' => 'DBTHEMECUSTOM_PRODUCT_DESC',
                        'desc' => $this->l('Formato a mostrar el bloque de descripción larga, características, etc'),
                        'options' => array(
                            'query' => $options_product_desc,
                            'id' => 'id_option',
                            'name' => 'name'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // Checkout
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración Checkout'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Eliminar puntos de fuga'),
                        'name' => 'DBTHEMECUSTOM_CHECKOUT_LEAKAGE',
                        'is_bool' => true,
                        'desc' => $this->l('Eliminar enlaces del header y footer en el proceso de compra'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        // WPO
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración WPO'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Bootstrap mínimo'),
                        'name' => 'DBTHEMECUSTOM_BOOTSTRAP_MIN',
                        'is_bool' => true,
                        'desc' => $this->l('Activar el bootstrap minimo para esta plantilla, si tienes algunos problemas con módulos externos puede que necesite utilizar bootstrap completo.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Preload CSS'),
                        'name' => 'DBTHEMECUSTOM_PRELOAD_CSS',
                        'is_bool' => true,
                        'desc' => $this->l('Si activa esta opción se realizará un preload de todos los css, esto mejora el rendimiento pero provoca un parpadeo al cargar cualquier url.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Material icons'),
                        'name' => 'DBTHEMECUSTOM_MATERIALICONS',
                        'is_bool' => true,
                        'desc' => $this->l('Cargar la libreria por defecto de PrestaShop de Material Icons, puede que algunos modulos externos lo utilicen'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        $helper = new HelperForm();
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int) Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $helper->submit_action = 'submitDbthemecustomModule';
        $helper->token = Tools::getAdminTokenLite('AdminDbthemecustomConfig');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm($forms);
    }

    protected function getConfigFormValues()
    {
        return array(
            'DBTHEMECUSTOM_LOGO_WIDTH' => Configuration::get('DBTHEMECUSTOM_LOGO_WIDTH'),
            'DBTHEMECUSTOM_LOGO_HEIGHT' => Configuration::get('DBTHEMECUSTOM_LOGO_HEIGHT'),
            'DBTHEMECUSTOM_GOOGLE_FONT' => Configuration::get('DBTHEMECUSTOM_GOOGLE_FONT'),
            'DBTHEMECUSTOM_PRIMARY_COLOR' => Configuration::get('DBTHEMECUSTOM_PRIMARY_COLOR'),
            'DBTHEMECUSTOM_SECOND_COLOR' => Configuration::get('DBTHEMECUSTOM_SECOND_COLOR'),
            'DBTHEMECUSTOM_BK' => Configuration::get('DBTHEMECUSTOM_BK'),
            'DBTHEMECUSTOM_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_COLOR_FONT'),
            'DBTHEMECUSTOM_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_COLOR_LINK'),
            'DBTHEMECUSTOM_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_COLOR_HOVER'),
            'DBTHEMECUSTOM_PAYMENT_VISA' => Configuration::get('DBTHEMECUSTOM_PAYMENT_VISA'),
            'DBTHEMECUSTOM_PAYMENT_MASTERCARD' => Configuration::get('DBTHEMECUSTOM_PAYMENT_MASTERCARD'),
            'DBTHEMECUSTOM_PAYMENT_MAESTRO' => Configuration::get('DBTHEMECUSTOM_PAYMENT_MAESTRO'),
            'DBTHEMECUSTOM_PAYMENT_PAYPAL' => Configuration::get('DBTHEMECUSTOM_PAYMENT_PAYPAL'),
            'DBTHEMECUSTOM_PAYMENT_BIZUM' => Configuration::get('DBTHEMECUSTOM_PAYMENT_BIZUM'),

            'DBTHEMECUSTOM_BUTTON_P_BK' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK'),
            'DBTHEMECUSTOM_BUTTON_P_COLOR' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR'),
            'DBTHEMECUSTOM_BUTTON_P_BORDER' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BORDER'),
            'DBTHEMECUSTOM_BUTTON_P_BK_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK_HOVER'),
            'DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER'),
            'DBTHEMECUSTOM_BUTTON_P_BORDER_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BORDER_HOVER'),
            'DBTHEMECUSTOM_BUTTON_S_BK' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK'),
            'DBTHEMECUSTOM_BUTTON_S_COLOR' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR'),
            'DBTHEMECUSTOM_BUTTON_S_BORDER' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BORDER'),
            'DBTHEMECUSTOM_BUTTON_S_BK_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK_HOVER'),
            'DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER'),
            'DBTHEMECUSTOM_BUTTON_S_BORDER_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BORDER_HOVER'),
            'DBTHEMECUSTOM_BUTTON_T_BK' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BK'),
            'DBTHEMECUSTOM_BUTTON_T_COLOR' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_COLOR'),
            'DBTHEMECUSTOM_BUTTON_T_BORDER' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BORDER'),
            'DBTHEMECUSTOM_BUTTON_T_BK_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BK_HOVER'),
            'DBTHEMECUSTOM_BUTTON_T_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_COLOR_HOVER'),
            'DBTHEMECUSTOM_BUTTON_T_BORDER_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BORDER_HOVER'),
            'DBTHEMECUSTOM_BUTTON_BK' => Configuration::get('DBTHEMECUSTOM_BUTTON_BK'),
            'DBTHEMECUSTOM_BUTTON_COLOR' => Configuration::get('DBTHEMECUSTOM_BUTTON_COLOR'),
            'DBTHEMECUSTOM_BUTTON_BORDER' => Configuration::get('DBTHEMECUSTOM_BUTTON_BORDER'),
            'DBTHEMECUSTOM_BUTTON_BK_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_BK_HOVER'),
            'DBTHEMECUSTOM_BUTTON_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_COLOR_HOVER'),
            'DBTHEMECUSTOM_BUTTON_BORDER_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_BORDER_HOVER'),

            'DBTHEMECUSTOM_HEADER_WIDTH' => Configuration::get('DBTHEMECUSTOM_HEADER_WIDTH'),
            'DBTHEMECUSTOM_DISPLAYNAV' => Configuration::get('DBTHEMECUSTOM_DISPLAYNAV'),
            'DBTHEMECUSTOM_TOPBAR_BK' => Configuration::get('DBTHEMECUSTOM_TOPBAR_BK'),
            'DBTHEMECUSTOM_TOPBAR_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_TOPBAR_COLOR_FONT'),
            'DBTHEMECUSTOM_TOPBAR_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_TOPBAR_COLOR_LINK'),
            'DBTHEMECUSTOM_TOPBAR_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_TOPBAR_COLOR_HOVER'),
            'DBTHEMECUSTOM_HEADER_BK' => Configuration::get('DBTHEMECUSTOM_HEADER_BK'),
            'DBTHEMECUSTOM_HEADER_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_HEADER_COLOR_FONT'),
            'DBTHEMECUSTOM_HEADER_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_HEADER_COLOR_LINK'),
            'DBTHEMECUSTOM_HEADER_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_HEADER_COLOR_HOVER'),
            'DBTHEMECUSTOM_SEARCH_BK' => Configuration::get('DBTHEMECUSTOM_SEARCH_BK'),
            'DBTHEMECUSTOM_SEARCH_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_SEARCH_COLOR_FONT'),
            'DBTHEMECUSTOM_COLOR_ICONS_HEADER' => Configuration::get('DBTHEMECUSTOM_COLOR_ICONS_HEADER'),

            'DBTHEMECUSTOM_FOOTER_WIDTH' => Configuration::get('DBTHEMECUSTOM_FOOTER_WIDTH'),
            'DBTHEMECUSTOM_PREFOOTER_BK' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_BK'),
            'DBTHEMECUSTOM_PREFOOTER_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_FONT'),
            'DBTHEMECUSTOM_PREFOOTER_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_LINK'),
            'DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER'),
            'DBTHEMECUSTOM_FOOTER_BK' => Configuration::get('DBTHEMECUSTOM_FOOTER_BK'),
            'DBTHEMECUSTOM_FOOTER_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_FONT'),
            'DBTHEMECUSTOM_FOOTER_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_LINK'),
            'DBTHEMECUSTOM_FOOTER_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_HOVER'),
            'DBTHEMECUSTOM_FOOTERCOPY_BK' => Configuration::get('DBTHEMECUSTOM_FOOTERCOPY_BK'),
            'DBTHEMECUSTOM_FOOTERCOPY_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_FOOTERCOPY_COLOR_FONT'),

            'DBTHEMECUSTOM_CATEGORY_IMG' => Configuration::get('DBTHEMECUSTOM_CATEGORY_IMG'),
            'DBTHEMECUSTOM_SUBCATEGORIES' => Configuration::get('DBTHEMECUSTOM_SUBCATEGORIES'),
            'DBTHEMECUSTOM_BUTTON_BUY' => Configuration::get('DBTHEMECUSTOM_BUTTON_BUY'),
            'DBTHEMECUSTOM_SECOND_IMG' => Configuration::get('DBTHEMECUSTOM_SECOND_IMG'),

            'DBTHEMECUSTOM_PRODUCTIMG' => Configuration::get('DBTHEMECUSTOM_PRODUCTIMG'),
            'DBTHEMECUSTOM_PRODUCT_COLUMNS' => Configuration::get('DBTHEMECUSTOM_PRODUCT_COLUMNS'),
            'DBTHEMECUSTOM_PRODUCT_DESC' => Configuration::get('DBTHEMECUSTOM_PRODUCT_DESC'),

            'DBTHEMECUSTOM_CHECKOUT_LEAKAGE' => Configuration::get('DBTHEMECUSTOM_CHECKOUT_LEAKAGE'),

            'DBTHEMECUSTOM_BOOTSTRAP_MIN' => Configuration::get('DBTHEMECUSTOM_BOOTSTRAP_MIN'),
            'DBTHEMECUSTOM_PRELOAD_CSS' => Configuration::get('DBTHEMECUSTOM_PRELOAD_CSS'),
            'DBTHEMECUSTOM_MATERIALICONS' => Configuration::get('DBTHEMECUSTOM_MATERIALICONS'),
        );
    }

    protected function saveData()
    {
        $form_values = $this->getConfigFormValues();
        $idShop = (int) $this->context->shop->id;
        $idShopGroup = (int) $this->context->shop->id_shop_group;

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key), false, $idShopGroup, $idShop);
        }

        $templateFile = 'module:dbthemecustom/views/templates/hook/header.tpl';
        $this->module->clearCache($templateFile, 'dbthemecustom_header');
    }
}