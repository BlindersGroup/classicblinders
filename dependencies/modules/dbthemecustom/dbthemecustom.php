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

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dbthemecustom extends Module
{
    protected $config_form = false;
    protected $templateFile;

    public function __construct()
    {
        $this->name = 'dbthemecustom';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Theme Custom');
        $this->description = $this->l('Customizar el theme Blinders');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:dbthemecustom/views/templates/hook/header.tpl';
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        $this->addValues();

        return parent::install() &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        Configuration::deleteByName('DBTHEMECUSTOM_SUBCATEGORIES');
        Configuration::deleteByName('DBTHEMECUSTOM_PRODUCTIMG');

        return parent::uninstall();
    }

    public function addValues()
    {
        Configuration::updateValue('DBTHEMECUSTOM_GOOGLE_FONT', '');
        Configuration::updateValue('DBTHEMECUSTOM_PRIMARY_COLOR', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_SECOND_COLOR', '#f39d72');
        Configuration::updateValue('DBTHEMECUSTOM_BK', '#f6f6f6');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_FONT', '#232323');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_VISA', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_MASTERCARD', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_MAESTRO', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_PAYPAL', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_BIZUM', 1);

        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_BK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_COLOR', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_BK_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_BK', '#f39d72');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_COLOR', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_BK_HOVER', '#de8d65');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER', '#ffffff');

        Configuration::updateValue('DBTHEMECUSTOM_HEADER_WIDTH', 0);
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_BK', '#efeff0');
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_COLOR_FONT', '#232323');
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_BK', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_COLOR_FONT', '#232323');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_SEARCH_BK', '#efeff0');
        Configuration::updateValue('DBTHEMECUSTOM_SEARCH_COLOR_FONT', '#7a7a7a');

        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_WIDTH', 0);
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_BK', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_COLOR_FONT', '#232323');
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_BK', '#f6f6f6');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_FONT', '#232323');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_LINK', '#232323');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_HOVER', '#2fb5d2');

        Configuration::updateValue('DBTHEMECUSTOM_CATEGORY_IMG', 1);
        Configuration::updateValue('DBTHEMECUSTOM_SUBCATEGORIES', false);
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_BUY', 1);

        Configuration::updateValue('DBTHEMECUSTOM_PRODUCTIMG', 0);
        Configuration::updateValue('DBTHEMECUSTOM_PRODUCT_COLUMNS', 3);
        Configuration::updateValue('DBTHEMECUSTOM_PRODUCT_DESC', 0);

        Configuration::updateValue('DBTHEMECUSTOM_CHECKOUT_LEAKAGE', 1);
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitDbthemecustomModule')) == true) {
            $this->postProcess();
        }

        $iframe = $this->context->smarty->fetch($this->local_path.'views/templates/admin/iframe.tpl');
        $iframe_bottom = $this->context->smarty->fetch($this->local_path.'views/templates/admin/iframe_bottom.tpl');

        return $iframe.$this->renderForm().$iframe_bottom;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitDbthemecustomModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm($this->getConfigForm());
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
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

        // Header
        $forms[] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuración General'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
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
                        'label' => $this->l('Ancho de la cabecera'),
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

        return $forms;
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
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
            'DBTHEMECUSTOM_BUTTON_P_BK_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK_HOVER'),
            'DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER'),
            'DBTHEMECUSTOM_BUTTON_S_BK' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK'),
            'DBTHEMECUSTOM_BUTTON_S_COLOR' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR'),
            'DBTHEMECUSTOM_BUTTON_S_BK_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK_HOVER'),
            'DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER'),

            'DBTHEMECUSTOM_HEADER_WIDTH' => Configuration::get('DBTHEMECUSTOM_HEADER_WIDTH'),
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

            'DBTHEMECUSTOM_FOOTER_WIDTH' => Configuration::get('DBTHEMECUSTOM_FOOTER_WIDTH'),
            'DBTHEMECUSTOM_PREFOOTER_BK' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_BK'),
            'DBTHEMECUSTOM_PREFOOTER_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_FONT'),
            'DBTHEMECUSTOM_PREFOOTER_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_LINK'),
            'DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER'),
            'DBTHEMECUSTOM_FOOTER_BK' => Configuration::get('DBTHEMECUSTOM_FOOTER_BK'),
            'DBTHEMECUSTOM_FOOTER_COLOR_FONT' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_FONT'),
            'DBTHEMECUSTOM_FOOTER_COLOR_LINK' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_LINK'),
            'DBTHEMECUSTOM_FOOTER_COLOR_HOVER' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_HOVER'),

            'DBTHEMECUSTOM_CATEGORY_IMG' => Configuration::get('DBTHEMECUSTOM_CATEGORY_IMG'),
            'DBTHEMECUSTOM_SUBCATEGORIES' => Configuration::get('DBTHEMECUSTOM_SUBCATEGORIES'),
            'DBTHEMECUSTOM_BUTTON_BUY' => Configuration::get('DBTHEMECUSTOM_BUTTON_BUY'),

            'DBTHEMECUSTOM_PRODUCTIMG' => Configuration::get('DBTHEMECUSTOM_PRODUCTIMG'),
            'DBTHEMECUSTOM_PRODUCT_COLUMNS' => Configuration::get('DBTHEMECUSTOM_PRODUCT_COLUMNS'),
            'DBTHEMECUSTOM_PRODUCT_DESC' => Configuration::get('DBTHEMECUSTOM_PRODUCT_DESC'),

            'DBTHEMECUSTOM_CHECKOUT_LEAKAGE' => Configuration::get('DBTHEMECUSTOM_CHECKOUT_LEAKAGE'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }

        $this->_clearCache($this->templateFile, 'dbthemecustom_header');
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $controller = Tools::getValue('controller');

        // Categorias
        if($controller == 'category') {
            $db_subcategories = Configuration::get('DBTHEMECUSTOM_SUBCATEGORIES');
            $category_img = Configuration::get('DBTHEMECUSTOM_CATEGORY_IMG');
            $this->context->smarty->assign(array(
                'db_subcategories' => $db_subcategories,
                'category_img' => $category_img,
            ));
        }

        // Marcas
        if($controller == 'manufacturer') {
            $category_img = Configuration::get('DBTHEMECUSTOM_CATEGORY_IMG');
            $this->context->smarty->assign(array(
                'category_img' => $category_img,
            ));
        }

        // Productos
        if($controller == 'product') {
            $show_product_imgs = Configuration::get('DBTHEMECUSTOM_PRODUCTIMG');
            $product_columns = Configuration::get('DBTHEMECUSTOM_PRODUCT_COLUMNS');
            $product_block_desc = Configuration::get('DBTHEMECUSTOM_PRODUCT_DESC');
            $this->context->smarty->assign(array(
                'show_product_imgs' => $show_product_imgs,
                'product_columns' => $product_columns,
                'product_block_down' => $product_block_desc,
            ));
            Media::addJsDef([
                'show_product_imgs' => $show_product_imgs,
            ]);
        }

        // Checkout
        if($controller == 'order') {
            $delete_leakage = Configuration::get('DBTHEMECUSTOM_CHECKOUT_LEAKAGE');
            $this->context->smarty->assign(array(
                'delete_leakage' => $delete_leakage,
            ));
        }

        // General
        $this->context->smarty->assign(array(
            'custom_generic' => $this->getVarsGeneric(),
        ));

        $cache_id = 'dbthemecustom_header';
        if (!$this->isCached($this->templateFile, $cache_id)) {
            $this->context->smarty->assign(array(
                'custom_css' => $this->getVarsCss(),
            ));
        }
        return $this->fetch($this->templateFile, $cache_id);
    }

    public function getVarsCss()
    {
        return array(
            'google_font_url' => urlencode(Configuration::get('DBTHEMECUSTOM_GOOGLE_FONT')),
            'google_font' => Configuration::get('DBTHEMECUSTOM_GOOGLE_FONT'),
            'primary_color' => Configuration::get('DBTHEMECUSTOM_PRIMARY_COLOR'),
            'second_color' => Configuration::get('DBTHEMECUSTOM_SECOND_COLOR'),
            'background' => Configuration::get('DBTHEMECUSTOM_BK'),
            'color_font' => Configuration::get('DBTHEMECUSTOM_COLOR_FONT'),
            'color_link' => Configuration::get('DBTHEMECUSTOM_COLOR_LINK'),
            'color_hover' => Configuration::get('DBTHEMECUSTOM_COLOR_HOVER'),

            'button_p_bk' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK'),
            'button_p_color' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR'),
            'button_p_bk_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK_HOVER'),
            'button_p_color_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER'),
            'button_s_bk' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK'),
            'button_s_color' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR'),
            'button_s_bk_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK_HOVER'),
            'button_s_color_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER'),

            'topbar_bk' => Configuration::get('DBTHEMECUSTOM_TOPBAR_BK'),
            'topbar_color' => Configuration::get('DBTHEMECUSTOM_TOPBAR_COLOR_FONT'),
            'topbar_link' => Configuration::get('DBTHEMECUSTOM_TOPBAR_COLOR_LINK'),
            'topbar_hover' => Configuration::get('DBTHEMECUSTOM_TOPBAR_COLOR_HOVER'),
            'header_bk' => Configuration::get('DBTHEMECUSTOM_HEADER_BK'),
            'header_color' => Configuration::get('DBTHEMECUSTOM_HEADER_COLOR_FONT'),
            'header_link' => Configuration::get('DBTHEMECUSTOM_HEADER_COLOR_LINK'),
            'header_hover' => Configuration::get('DBTHEMECUSTOM_HEADER_COLOR_HOVER'),
            'search_bk' => Configuration::get('DBTHEMECUSTOM_SEARCH_BK'),
            'seach_color' => Configuration::get('DBTHEMECUSTOM_SEARCH_COLOR_FONT'),

            'prefooter_bk' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_BK'),
            'prefooter_color' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_FONT'),
            'prefooter_link' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_LINK'),
            'prefooter_hover' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER'),
            'footer_bk' => Configuration::get('DBTHEMECUSTOM_FOOTER_BK'),
            'footer_color' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_FONT'),
            'footer_link' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_LINK'),
            'footer_hover' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_HOVER'),
        );
    }

    public function getVarsGeneric()
    {
        return array(
            'width_header' => Configuration::get('DBTHEMECUSTOM_HEADER_WIDTH'),
            'width_footer' => Configuration::get('DBTHEMECUSTOM_FOOTER_WIDTH'),
            'button_buy' => Configuration::get('DBTHEMECUSTOM_BUTTON_BUY'),
            'visa' => Configuration::get('DBTHEMECUSTOM_PAYMENT_VISA'),
            'mastercard' => Configuration::get('DBTHEMECUSTOM_PAYMENT_MASTERCARD'),
            'maestro' => Configuration::get('DBTHEMECUSTOM_PAYMENT_MAESTRO'),
            'paypal' => Configuration::get('DBTHEMECUSTOM_PAYMENT_PAYPAL'),
            'bizum' => Configuration::get('DBTHEMECUSTOM_PAYMENT_BIZUM'),
        );
    }
}
