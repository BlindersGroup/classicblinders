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
        $this->version = '1.2.0';
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
        $this->createTabs();
        $this->addValues();

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('actionFrontControllerSetMedia');
    }

    public function uninstall()
    {
        $this->deleteTabs();

        Configuration::deleteByName('DBTHEMECUSTOM_SUBCATEGORIES');
        Configuration::deleteByName('DBTHEMECUSTOM_PRODUCTIMG');

        return parent::uninstall();
    }

    /**
     * Create Tabs
     */
    public function createTabs()
    {
        // Tabs
        $idTabs = array();
        $idTabs[] = Tab::getIdFromClassName('AdminDbCustomTheme');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }


        // Tab Primary
        if (!Tab::getIdFromClassName('AdminDevBlinders')) {
            $parent_tab = new Tab();
            $parent_tab->name = array();
            foreach (Language::getLanguages(true) as $lang)
                $parent_tab->name[$lang['id_lang']] = $this->l('DevBlinders');

            $parent_tab->class_name = 'AdminDevBlinders';
            $parent_tab->id_parent = 0;
            $parent_tab->module = $this->name;
            $parent_tab->add();

            $id_full_parent = $parent_tab->id;
        } else {
            $id_full_parent = Tab::getIdFromClassName('AdminDevBlinders');
        }

        // Tabs
        $parent = new Tab();
        $parent->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $parent->name[$lang['id_lang']] = $this->l('Theme');

        $parent->class_name = 'AdminDbCustomTheme';
        $parent->id_parent = $id_full_parent;
        $parent->module = $this->name;
        $parent->icon = 'palette';
        $parent->add();

    }

    /**
     * Delete Tabs
     */
    public function deleteTabs()
    {
        // Tabs
        $idTabs = array();
        $idTabs[] = Tab::getIdFromClassName('AdminDbCustomTheme');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }
    }

    public function addValues()
    {
        Configuration::updateValue('DBTHEMECUSTOM_LOGO_WIDTH', '128');
        Configuration::updateValue('DBTHEMECUSTOM_LOGO_HEIGHT', '34');
        Configuration::updateValue('DBTHEMECUSTOM_GOOGLE_FONT', 'Open Sans');
        Configuration::updateValue('DBTHEMECUSTOM_PRIMARY_COLOR', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_SECOND_COLOR', '#f39d72');
        Configuration::updateValue('DBTHEMECUSTOM_BK', '#FAF9F9');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_FONT', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_VISA', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_MASTERCARD', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_MAESTRO', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_PAYPAL', 1);
        Configuration::updateValue('DBTHEMECUSTOM_PAYMENT_BIZUM', 1);

        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_BK', '#2FB5D2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_COLOR', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_BORDER', '#2FB5D2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_BK_HOVER', '#55E0FF');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_P_BORDER_HOVER', '#55E0FF');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_BK', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_COLOR', '#2FB5D2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_BORDER', '#2FB5D2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_BK_HOVER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER', '#55E0FF');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_S_BORDER_HOVER', '#55E0FF');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_T_BK', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_T_COLOR', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_T_BORDER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_T_BK_HOVER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_T_COLOR_HOVER', '#55E0FF');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_T_BORDER_HOVER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_BK', '#2F64D2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_COLOR', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_BORDER', '#2F64D2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_BK_HOVER', '#7AA2F2');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_COLOR_HOVER', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_BORDER_HOVER', '#7AA2F2');

        Configuration::updateValue('DBTHEMECUSTOM_HEADER_WIDTH', 0);
        Configuration::updateValue('DBTHEMECUSTOM_DISPLAYNAV', 1);
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_BK', '#F1F0F0');
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_COLOR_FONT', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_TOPBAR_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_BK', '#ffffff');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_COLOR_FONT', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_COLOR_LINK', '#2fb5d2');
        Configuration::updateValue('DBTHEMECUSTOM_HEADER_COLOR_HOVER', '#2592a9');
        Configuration::updateValue('DBTHEMECUSTOM_SEARCH_BK', '#FFFFFF');
        Configuration::updateValue('DBTHEMECUSTOM_SEARCH_COLOR_FONT', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_COLOR_ICONS_HEADER', '#2FB5D2');

        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_WIDTH', 0);
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_BK', '#BAE6F0');
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_COLOR_FONT', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_COLOR_LINK', '#2FB5D2');
        Configuration::updateValue('DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER', '#008BAA');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_BK', '#2FB5D2');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_FONT', '#FFFFFF');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_LINK', '#FFFFFF');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_HOVER', '#1F1F1F');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_BK', '#008BAA');
        Configuration::updateValue('DBTHEMECUSTOM_FOOTER_COLOR_FONT', '#FFFFFF');

        Configuration::updateValue('DBTHEMECUSTOM_CATEGORY_IMG', 1);
        Configuration::updateValue('DBTHEMECUSTOM_SUBCATEGORIES', false);
        Configuration::updateValue('DBTHEMECUSTOM_BUTTON_BUY', 1);
        Configuration::updateValue('DBTHEMECUSTOM_SECOND_IMG', 0);

        Configuration::updateValue('DBTHEMECUSTOM_PRODUCTIMG', 0);
        Configuration::updateValue('DBTHEMECUSTOM_PRODUCT_COLUMNS', 3);
        Configuration::updateValue('DBTHEMECUSTOM_PRODUCT_DESC', 0);

        Configuration::updateValue('DBTHEMECUSTOM_CHECKOUT_LEAKAGE', 1);

        Configuration::updateValue('DBTHEMECUSTOM_BOOTSTRAP_MIN', true);
        Configuration::updateValue('DBTHEMECUSTOM_PRELOAD_CSS', false);
        Configuration::updateValue('DBTHEMECUSTOM_MATERIALICONS', false);
    }

    public function clearCache($template, $cache_id)
    {
        $this->_clearCache($template, $cache_id);
    }

    public function hookActionFrontControllerSetMedia($params)
    {
        // Load bootstrap
        if(Configuration::get('DBTHEMECUSTOM_BOOTSTRAP_MIN') == true){
            $bootstrap = 'bootstrap-minimal.css';
        } else {
            $bootstrap = 'bootstrap.css';
        }
        $this->context->controller->registerStylesheet(
            'module-dbthemecustom-bootstrap',
            'modules/'.$this->name.'/assets/css/'.$bootstrap,
            [
                'media' => 'all',
                'priority' => 1,
            ]
        );

        $this->context->controller->registerStylesheet(
            'module-dbthemecustom-fontawesome',
            'modules/'.$this->name.'/assets/css/fontawesome.css',
            [
                'media' => 'all',
                'priority' => 1,
            ]
        );

        if(Configuration::get('DBTHEMECUSTOM_MATERIALICONS') == true){
            $this->context->controller->registerStylesheet(
                'module-dbthemecustom-materialicons',
                'modules/'.$this->name.'/assets/css/materialicons.css',
                [
                    'media' => 'all',
                    'priority' => 100,
                ]
            );
        }

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
                'is_mobile' => Context::getContext()->isMobile(),
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
            'preload_css' => (int) Configuration::get('DBTHEMECUSTOM_PRELOAD_CSS'),
            'route_module' => '/modules/'.$this->name.'/',
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
            'material_icon' => Configuration::get('DBTHEMECUSTOM_MATERIALICONS'),
            'primary_color' => Configuration::get('DBTHEMECUSTOM_PRIMARY_COLOR'),
            'second_color' => Configuration::get('DBTHEMECUSTOM_SECOND_COLOR'),
            'background' => Configuration::get('DBTHEMECUSTOM_BK'),
            'color_font' => Configuration::get('DBTHEMECUSTOM_COLOR_FONT'),
            'color_link' => Configuration::get('DBTHEMECUSTOM_COLOR_LINK'),
            'color_hover' => Configuration::get('DBTHEMECUSTOM_COLOR_HOVER'),

            'button_p_bk' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK'),
            'button_p_color' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR'),
            'button_p_border' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BORDER'),
            'button_p_bk_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BK_HOVER'),
            'button_p_color_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_COLOR_HOVER'),
            'button_p_border_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_P_BORDER_HOVER'),
            'button_s_bk' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK'),
            'button_s_color' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR'),
            'button_s_border' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BORDER'),
            'button_s_bk_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BK_HOVER'),
            'button_s_color_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_COLOR_HOVER'),
            'button_s_border_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_S_BORDER_HOVER'),
            'button_t_bk' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BK'),
            'button_t_color' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_COLOR'),
            'button_t_border' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BORDER'),
            'button_t_bk_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BK_HOVER'),
            'button_t_color_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_COLOR_HOVER'),
            'button_t_border_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_T_BORDER_HOVER'),
            'button_bk' => Configuration::get('DBTHEMECUSTOM_BUTTON_BK'),
            'button_color' => Configuration::get('DBTHEMECUSTOM_BUTTON_COLOR'),
            'button_border' => Configuration::get('DBTHEMECUSTOM_BUTTON_BORDER'),
            'button_bk_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_BK_HOVER'),
            'button_color_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_COLOR_HOVER'),
            'button_border_hover' => Configuration::get('DBTHEMECUSTOM_BUTTON_BORDER_HOVER'),

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
            'color_icons_header' => Configuration::get('DBTHEMECUSTOM_COLOR_ICONS_HEADER'),

            'prefooter_bk' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_BK'),
            'prefooter_color' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_FONT'),
            'prefooter_link' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_LINK'),
            'prefooter_hover' => Configuration::get('DBTHEMECUSTOM_PREFOOTER_COLOR_HOVER'),
            'footer_bk' => Configuration::get('DBTHEMECUSTOM_FOOTER_BK'),
            'footer_color' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_FONT'),
            'footer_link' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_LINK'),
            'footer_hover' => Configuration::get('DBTHEMECUSTOM_FOOTER_COLOR_HOVER'),
            'footercopy_bk' => Configuration::get('DBTHEMECUSTOM_FOOTERCOPY_BK'),
            'footercopy_color' => Configuration::get('DBTHEMECUSTOM_FOOTERCOPY_COLOR_FONT'),
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
            'logo_width' => Configuration::get('DBTHEMECUSTOM_LOGO_WIDTH'),
            'logo_height' => Configuration::get('DBTHEMECUSTOM_LOGO_HEIGHT'),
            'second_img' => Configuration::get('DBTHEMECUSTOM_SECOND_IMG'),
            'show_displaynav' => Configuration::get('DBTHEMECUSTOM_DISPLAYNAV'),
        );
    }
}
