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

class Dbmenu extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        require_once(dirname(__FILE__).'/classes/DbMenuList.php');

        if(file_exists(dirname(__FILE__).'/premium/DbPremium.php')){
            require_once(dirname(__FILE__).'/premium/DbPremium.php');
            $this->premium = 1;
        } else {
            $this->premium = 0;
        }

        $this->name = 'dbmenu';
        $this->tab = 'front_office_features';
        $this->version = '1.2.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Menú');
        $this->description = $this->l('Menu personalizado optimizado para mobile');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        if(!Module::isInstalled('dbdatatext')){
            $this->rcopy(dirname(__FILE__).'/dependencies/dbdatatext/', _PS_MODULE_DIR_.'/dbdatatext/');
            $dbdatatext = Module::getInstanceByName('dbdatatext');
            $dbdatatext->install();
        } else {
            if(!Module::isEnabled('dbdatatext')){
                $dbdatatext = Module::getInstanceByName('dbdatatext');
                $dbdatatext->enable();
            }
        }
        include(dirname(__FILE__).'/sql/install.php');
        $this->createTabs();

        // Valores default
        Configuration::updateValue('DBMENU_ACCOUNT', 1);
        Configuration::updateValue('DBMENU_CONTACT_SHOW', 1);
        Configuration::updateValue('DBMENU_RRSS_SHOW', 1);
        Configuration::updateValue('DBMENU_OPINIONS', 1);
        Configuration::updateValue('DBMENU_COLOR_FONT', '#232323');
        Configuration::updateValue('DBMENU_COLOR_HOVER', '#2fb5d2');

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayMenuInside') &&
            $this->registerHook('displayNavFullWidth');
    }

    public function uninstall()
    {
//        include(dirname(__FILE__).'/sql/uninstall.php');
        $this->deleteTabs();

        return parent::uninstall();
    }

    /**
     * Function to Copy folders and files
     */
    function rcopy($src, $dst) {
        if (file_exists ( $dst )) {
            return;
        }
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file ) {
                if ($file != "." && $file != "..") {
                    $this->rcopy("$src/$file", "$dst/$file");
                }
            }
        } else if (file_exists ( $src )) {
            copy($src, $dst);
        }
    }

    /**
     * Create Tabs
     */
    public function createTabs()
    {
        // Tabs
        $idTabs = array();
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenuAjax');
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenu');
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenuList');
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenuConfig');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }

        // Tab hidden
        $tab_config = new Tab();
        $tab_config->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab_config->name[$lang['id_lang']] = $this->l('DbMenu Ajax');
        }
        $tab_config->class_name = 'AdminDbMenuAjax';
        $tab_config->id_parent = 0;
        $tab_config->module = $this->name;
        $tab_config->active = 0;
        $tab_config->add();

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
            $parent->name[$lang['id_lang']] = $this->l('Menú');

        $parent->class_name = 'AdminDbMenu';
        $parent->id_parent = $id_full_parent;
        $parent->module = $this->name;
        $parent->icon = 'menu';
        $parent->add();

        // Gestionar enlaces del menú
        $tab_config = new Tab();
        $tab_config->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $tab_config->name[$lang['id_lang']] = $this->l('Listado');

        $tab_config->class_name = 'AdminDbMenuList';
        $tab_config->id_parent = $parent->id;
        $tab_config->module = $this->name;
        $tab_config->add();

        // Configuración
        $tab_config = new Tab();
        $tab_config->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $tab_config->name[$lang['id_lang']] = $this->l('Configuración');

        $tab_config->class_name = 'AdminDbMenuConfig';
        $tab_config->id_parent = $parent->id;
        $tab_config->module = $this->name;
        $tab_config->add();

    }

    /**
     * Delete Tabs
     */
    public function deleteTabs()
    {
        // Tabs
        $idTabs = array();
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenuAjax');
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenu');
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenuList');
        $idTabs[] = Tab::getIdFromClassName('AdminDbMenuConfig');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the BO.
     */
    public function hookDisplayBackOfficeHeader()
    {
        $controller = Tools::getValue('controller');
        if (Tools::getValue('module_name') == $this->name
            || $controller == 'AdminDbMenuList'
            || $controller == 'AdminDbMenuConfig' ) {
            $this->context->controller->addJquery();
            $this->context->controller->addJS($this->_path . '/views/js/back.js');
            $this->context->controller->addCSS($this->_path . '/views/css/back.css');
            Media::addJsDef(array(
                'dbmenu_ajax' => $this->context->link->getAdminLink('AdminDbMenuAjax'),
            ));
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/dbmenu.js');
        $this->context->controller->addCSS($this->_path.'/views/css/dbmenu.css');

        $color_font = Configuration::get('DBMENU_COLOR_FONT');
        if(empty($color_font)){ $color_font = '#232323'; }
        $color_hover = Configuration::get('DBMENU_COLOR_HOVER');
        if(empty($color_hover)){ $color_hover = '#2fb5d2'; }
        $inline = '<style>
            :root {
                --dbmenu_color: '.$color_font.';
                --dbmenu_color_hover: '.$color_hover.';
            }
        </style>';
        return $inline;
    }

    public function hookDisplayNavFullWidth()
    {
        $id_lang = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        $menu = DbMenuList::getMenuLinks($id_lang, $id_shop);
        $featured = DbMenuList::getFeaturedLink($id_lang, $id_shop);
        $additional = DbMenuList::getAdditionalLink($id_lang, $id_shop);

        // Datos para menu mobile
        $rrss = [];
        $rrss['facebook'] = Configuration::get('DBMENU_FACEBOOK', $id_lang);
        $rrss['twitter'] = Configuration::get('DBMENU_TWITTER', $id_lang);
        $rrss['linkedin'] = Configuration::get('DBMENU_LINKEDIN', $id_lang);
        $rrss['instagram'] = Configuration::get('DBMENU_INSTAGRAM', $id_lang);
        $rrss['youtube'] = Configuration::get('DBMENU_YOUTUBE', $id_lang);
        $prefix = Configuration::get('DBMENU_PREFIX');
        $phone = Configuration::get('DBMENU_PHONE');
        $show_phone = Configuration::get('DBMENU_PHONE_SHOW');
        $show_account = Configuration::get('DBMENU_ACCOUNT');
        if($this->premium == 1) {
            if (Module::isEnabled('productcomments')) {
                $show_opinions = Configuration::get('DBMENU_OPINIONS');
                $productcomments = DbMenuPremium::getProductComments();
            } else {
                $show_opinions = 0;
                $productcomments = [];
            }
        } else {
            $show_opinions = 0;
            $productcomments = [];
        }
        $show_rrss = Configuration::get('DBMENU_RRSS_SHOW');
        $show_contact = Configuration::get('DBMENU_CONTACT_SHOW');
        $show_email = Configuration::get('DBMENU_EMAIL_SHOW');
        $email = Configuration::get('DBMENU_EMAIL');
        $show_schedule = Configuration::get('DBMENU_SCHEDULE_SHOW');
        $schedule = Configuration::get('DBMENU_SCHEDULE');
        $show_whatsapp = Configuration::get('DBMENU_WHATSAPP_SHOW');
        $whatsapp = Configuration::get('DBMENU_WHATSAPP');
        $link_whatsapp = 'https://wa.me/'.$whatsapp;

        $this->context->smarty->assign('path', _MODULE_DIR_.'dbbaners/views/img/banners/');
        $this->context->smarty->assign('menus', $menu);
        $this->context->smarty->assign('featured', $featured);
        $this->context->smarty->assign('additional', $additional);
        $this->context->smarty->assign('rrss', $rrss);
        $this->context->smarty->assign('show_phone', $show_phone);
        $this->context->smarty->assign('prefix', $prefix);
        $this->context->smarty->assign('phone', $phone);
        $this->context->smarty->assign('show_account', $show_account);
        $this->context->smarty->assign('show_opinions', $show_opinions);
        $this->context->smarty->assign('show_rrss', $show_rrss);
        $this->context->smarty->assign('show_contact', $show_contact);
        $this->context->smarty->assign('show_email', $show_email);
        $this->context->smarty->assign('email', $email);
        $this->context->smarty->assign('show_schedule', $show_schedule);
        $this->context->smarty->assign('schedule', $schedule);
        $this->context->smarty->assign('show_whatsapp', $show_whatsapp);
        $this->context->smarty->assign('whatsapp', $whatsapp);
        $this->context->smarty->assign('link_whatsapp', $link_whatsapp);
        $this->context->smarty->assign('productcomments', $productcomments);

        if($this->premium == 0) {
            $template = 'views/templates/hook/menu_new.tpl';
        } else {
            $template = 'premium/menu_new.tpl';
        }
        return $this->display(__FILE__, $template);
    }

}
