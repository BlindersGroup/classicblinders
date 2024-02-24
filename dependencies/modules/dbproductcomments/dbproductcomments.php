<?php
/**
* 2007-2022 PrestaShop
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
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dbproductcomments extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        require_once(dirname(__FILE__).'/classes/DbProductCommentsComment.php');

        if(file_exists(dirname(__FILE__).'/premium/DbPremium.php')){
            require_once(dirname(__FILE__).'/premium/DbPremium.php');
            $this->premium = 1;
        } else {
            $this->premium = 0;
        }

        $this->name = 'dbproductcomments';
        $this->tab = 'front_office_features';
        $this->version = '2.0.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Product Comments');
        $this->description = $this->l('Comentarios de productos');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        $this->createTabs();

        if($this->premium == 1) {
            Configuration::updateValue('DBPRODUCTCOMMENTS_CHARACTERISTIC1', 'Calidad');
            Configuration::updateValue('DBPRODUCTCOMMENTS_CHARACTERISTIC2', 'Precio');
            Configuration::updateValue('DBPRODUCTCOMMENTS_CHARACTERISTIC3', 'Rendimiento');
            Configuration::updateValue('DBPRODUCTCOMMENTS_DAYS', 20);
            Configuration::updateValue('DBPRODUCTCOMMENTS_SUBJECT', '');
        }

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayProductListReviews') &&
            $this->registerHook('displayFooterProduct') &&
            $this->registerHook('displayFooterCategory') &&
            $this->registerHook('actionOrderStatusPostUpdate') &&
            $this->registerHook('displayCustomerAccount') &&
            $this->registerHook('ModuleRoutes');

    }

    public function uninstall()
    {
        //include(dirname(__FILE__).'/sql/uninstall.php');
        $this->deleteTabs();

        return parent::uninstall();
    }

    /**
     * Create Tabs
     */
    public function createTabs()
    {
        // Tabs
        $idTabs = array();
        $idTabs[] = Tab::getIdFromClassName('AdminDbProductCommentsGeneral');
        $idTabs[] = Tab::getIdFromClassName('AdminDbProductCommentsList');
        $idTabs[] = Tab::getIdFromClassName('AdminDbProductCommentsSettings');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }

        // Tabs
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

        // Comentarios
        $parent = new Tab();
        $parent->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $parent->name[$lang['id_lang']] = $this->l('Comentarios');

        $parent->class_name = 'AdminDbProductCommentsGeneral';
        $parent->id_parent = $id_full_parent;
        $parent->module = $this->name;
        $parent->icon = 'question_answer';
        $parent->add();

        // Listado comentarios
        $tab_config = new Tab();
        $tab_config->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $tab_config->name[$lang['id_lang']] = $this->l('Gestionar');

        $tab_config->class_name = 'AdminDbProductCommentsList';
        $tab_config->id_parent = $parent->id;
        $tab_config->module = $this->name;
        $tab_config->add();

        if($this->premium == 1) {
            // Configuración
            $tab_config = new Tab();
            $tab_config->name = array();
            foreach (Language::getLanguages(true) as $lang)
                $tab_config->name[$lang['id_lang']] = $this->l('Configuración');

            $tab_config->class_name = 'AdminDbProductCommentsSettings';
            $tab_config->id_parent = $parent->id;
            $tab_config->module = $this->name;
            $tab_config->add();
        }

    }

    /**
     * Delete Tabs
     */
    public function deleteTabs()
    {
        // Tabs
        $idTabs = array();
        $idTabs[] = Tab::getIdFromClassName('AdminDbProductCommentsGeneral');
        $idTabs[] = Tab::getIdFromClassName('AdminDbProductCommentsList');
        $idTabs[] = Tab::getIdFromClassName('AdminDbProductCommentsSettings');

        foreach ($idTabs as $idTab) {
            if ($idTab) {
                $tab = new Tab($idTab);
                $tab->delete();
            }
        }
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitDbproductcommentsModule')) == true) {
            $this->postProcess();
        }
        if($this->premium) {
            return $this->renderForm();
        } else {
            return;
        }
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
        $helper->submit_action = 'submitDbproductcommentsModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => DbProductCommentsPremium::getConfigFormValuesConfiguration(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array(DbProductCommentsPremium::getConfigFormConfiguration()));
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        if($this->premium == 1) {
            $form_values = DbProductCommentsPremium::getConfigFormValuesConfiguration();

            foreach (array_keys($form_values) as $key) {
                Configuration::updateValue($key, Tools::getValue($key));
            }
        }
    }

    /**
     * Add Routes
     */
    public function hookModuleRoutes($params)
    {

        $context = Context::getContext();
        $controller = Tools::getValue('controller', 0);
        $id_lang = $context->language->id;

        $my_routes = array(

            // User opiniones
            'module-dbproductcomments-dbmisopiniones' => array(
                'controller' => 'dbmisopiniones',
                'rule' => 'opiniones/',
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'dbproductcomments',
                ),
            ),

        );

        return $my_routes;
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/dbproductcomments.js');
        $this->context->controller->addCSS($this->_path.'/views/css/dbproductcomments.css');

        Media::addJsDef(array(
            'dbproductcomments_ajax' => Context::getContext()->link->getModuleLink('dbproductcomments', 'ajax', array()),
        ));
    }

    public function renderCommentModal($id_product, $id_customer)
    {
        $customer = new Customer($id_customer);
        $charact1 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC1');
        $charact2 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC2');
        $charact3 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC3');

        $this->smarty->assign(array(
            'id_product' => $id_product,
            'customer' => (array)$customer,
            'charact1' => $charact1,
            'charact2' => $charact2,
            'charact3' => $charact3,
            'premium' => $this->premium,
        ));

        return $this->fetch('module:dbproductcomments/views/templates/hook/modal_comment.tpl');
    }

    public function renderGenericModal($action)
    {
        if($action == 'login'){
            $text = $this->l('Debe de estar logueado para poder comentar');
        } elseif($action == 'create_question'){
            $text = $this->l('El comentario se ha enviado correctamente, está en revisión por nuestro equipo');
        } elseif($action == 'push_vote'){
            $text = $this->l('Se ha realizado la votación correctamente');
        }

        $this->smarty->assign(array(
            'text' => $text,
        ));

        return $this->fetch('module:dbproductcomments/views/templates/hook/modal_generic.tpl');
    }

    public function hookdisplayProductListReviews($params)
    {
        $id_product = $params['product']->id;
        $stars = $this->getProductPorcentajeValoraciones($id_product);

        $this->smarty->assign(array(
            'stars' => $stars,
        ));
        return $this->fetch('module:dbproductcomments/views/templates/hook/product_list.tpl');
    }

    public function hookdisplayFooterCategory()
    {
        $controller = Tools::getValue('controller');
        if($controller == 'category') {
            $id_category = (int)Tools::getValue('id_category');
            $category = new Category($id_category, $this->context->language->id);
            $name = $category->name;
            $vals_counts = $this->getMediaValoraciones($id_category);
            $total_comments = $vals_counts['total'];
            if ($total_comments > 0) {
                $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);
                $average_media_comments = round($vals_counts['grade'] / $vals_counts['total'] * 100 / 5, 1);
                $last_comments = $this->getLastValoraciones('3', $id_category);

                $this->smarty->assign(array(
                                          'total_comments' => $total_comments,
                                          'media_comments' => $media_comments,
                                          'average_media_comments' => $average_media_comments,
                                          'last_comments' => $last_comments,
                                          'name' => $name,
                                      ));
                return $this->fetch('module:dbproductcomments/views/templates/hook/category.tpl');
            }
        } elseif ($controller == 'manufacturer'){
            $id_manufacturer = (int)Tools::getValue('id_manufacturer');
            $manufacturer = new Manufacturer($id_manufacturer, $this->context->language->id);
            $name = $manufacturer->name;
            $vals_counts = $this->getMediaValoracionesBrand($id_manufacturer);
            $total_comments = $vals_counts['total'];
            if ($total_comments > 0) {
                $media_comments = round($vals_counts['grade'] / $vals_counts['total'], 2);
                $average_media_comments = round($vals_counts['grade'] / $vals_counts['total'] * 100 / 5, 1);
                $last_comments = $this->getLastValoracionesBrand('3', $id_manufacturer);

                $this->smarty->assign(array(
                                          'total_comments' => $total_comments,
                                          'media_comments' => $media_comments,
                                          'average_media_comments' => $average_media_comments,
                                          'last_comments' => $last_comments,
                                          'name' => $name,
                                      ));
                return $this->fetch('module:dbproductcomments/views/templates/hook/category.tpl');
            }
        }
    }

    public function hookdisplayProductCenterColumn($params)
    {
        $id_product = $params['product']->id;
        $stars = $this->getProductPorcentajeValoraciones($id_product);

        $this->smarty->assign(array(
            'stars' => $stars,
        ));
        return $this->fetch('module:dbproductcomments/views/templates/hook/product_top.tpl');
    }

    public function hookdisplayBlockLeftFooter($params)
    {
        $return = '';
        if($this->premium == 1) {
            $this->smarty->assign(DbProductCommentsPremium::hookdisplayProductShop($params));
            return $this->fetch('module:dbproductcomments/premium/views/templates/hook/product_shop.tpl');
        }
        return $return;
    }

    public function hookdisplayReassurance($params)
    {
        if(Tools::getValue('controller') == 'cart') {
            return $this->hookdisplayBlockLeftFooter($params);
        }
    }

    public function hookdisplayFooterProduct($params)
    {
        $id_product = $params['product']->id;
        $stars = $this->getProductPorcentajeValoraciones($id_product);
        $progress = $this->getProgressProduct($id_product);
        $comments = $this->getCommentsProduct($id_product);
        $charact1 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC1');
        $charact2 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC2');
        $charact3 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC3');

        $this->smarty->assign(array(
            'stars' => $stars,
            'progress' => $progress,
            'comments' => $comments,
            'charact1' => $charact1,
            'charact2' => $charact2,
            'charact3' => $charact3,
            'premium' => $this->premium,
        ));
        return $this->fetch('module:dbproductcomments/views/templates/hook/product.tpl');
    }

    public function hookdisplayOrderConfirmation($params)
    {
        $return = '';
        if($this->premium == 1) {
            $return = DbProductCommentsPremium::hookdisplayOrderConfirmation($params);
        }
        return $return;
    }

    public function hookdisplayFooterBottom($params)
    {
        $return = '';
        if($this->premium == 1) {
            $return = DbProductCommentsPremium::hookdisplayFooterBottom($params);
        }
        return $return;
    }

    public function hookdisplayMenuTop($params)
    {
        if($this->premium == 1) {
            $this->smarty->assign(DbProductCommentsPremium::hookdisplayMenuTop($params));
            return $this->fetch('module:dbproductcomments/premiumviews/templates/hook/menu_shop.tpl');
        }
        return;
    }

    public function hookdisplayCustomerAccount($params)
    {
        $this->smarty->assign(array(
            'url' => $this->context->link->getModuleLink('dbproductcomments', 'dbmisopiniones'),
        ));
        return $this->fetch('module:dbproductcomments/views/templates/hook/myaccount.tpl');
    }

    public function getProductPorcentajeValoraciones($id_product)
    {
        if($id_product > 0){
            $sql = "SELECT count(*) as total, SUM(grade) as grade
                    FROM "._DB_PREFIX_."dbproductcomments
                    WHERE id_product = '$id_product' AND validate = 1 AND deleted = 0";
            $grade = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);

            $result = [];
            if($grade['total'] > 0){
                $average = round($grade['grade'] / $grade['total'] * 100 / 5, 1);
                $puntuacion = round($grade['grade'] / $grade['total'], 1);
                $result = array(
                    'total' => $grade['total'],
                    'average' => $average,
                    'grade' => $puntuacion,
                );
            } else {
                $result = array(
                    'total' => 0,
                    'average' => 0,
                    'grade' => 0,
                );
            }

            return $result;
        }
    }

    public function getMediaValoraciones($id_category = null)
    {
        $sql = "SELECT count(*) as total, SUM(grade) as grade
                FROM "._DB_PREFIX_."dbproductcomments pc
                LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product
                LEFT JOIN "._DB_PREFIX_."category_product cp ON p.id_product = cp.id_product
                WHERE pc.validate = 1";
        if($id_category > 0) {
            $sql .= " AND cp.id_category = '$id_category'";
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
        return $result;
    }

    public function getMediaValoracionesBrand($id_manufacturer = null)
    {
        $sql = "SELECT count(*) as total, SUM(grade) as grade
                FROM "._DB_PREFIX_."dbproductcomments pc
                LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product
                WHERE pc.validate = 1";
        if($id_manufacturer > 0) {
            $sql .= " AND p.id_manufacturer = '$id_manufacturer'";
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
        return $result;
    }

    public function getLastValoraciones($num = 3, $id_category = null)
    {
        $link = new Link();
        $id_lang = $this->context->language->id;
        if($id_category > 0){
            $sql = "SELECT pc.title, pc.customer_name, pc.grade, pc.id_product, pc.date_add
                    FROM "._DB_PREFIX_."dbproductcomments pc
                    LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product AND p.active = 1 AND p.visibility IN ('both', 'catalog')
                    LEFT JOIN "._DB_PREFIX_."category_product cp ON p.id_product = cp.id_product
                    WHERE cp.id_category = '$id_category' AND pc.grade >= 3 AND pc.validate = 1
                    GROUP BY pc.id_product
                    ORDER BY date_add DESC
                    LIMIT $num";
            $comments = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
            if(is_array($comments) && count($comments) > 0) {
                $result = [];
                foreach ($comments as $comment) {
                    $product = new Product((int)$comment['id_product'], false, $id_lang);
                    $img = $product->getCover($product->id);
                    $image_type = 'small_default';
                    $img_url = $link->getImageLink(isset($product->link_rewrite) ? $product->link_rewrite : $product->name,
                                                   (int)$img['id_image'], $image_type);
                    $average = round($comment['grade'] * 100 / 5, 1);

                    $result[] = array(
                        'title' => $comment['customer_name'],
                        'grade' => $comment['grade'],
                        'date_add' => $comment['date_add'],
                        'img' => $img_url,
                        'url' => $link->getProductLink($product->id),
                        'product_name' => $product->name,
                        'average' => $average,
                    );
                }
            }
            return $result;
        }
    }

    public function getLastValoracionesBrand($num = 3, $id_manufacturer = null)
    {
        $link = new Link();
        $id_lang = $this->context->language->id;
        if($id_manufacturer > 0){
            $sql = "SELECT pc.title, pc.customer_name, pc.grade, pc.id_product, pc.date_add
                    FROM "._DB_PREFIX_."dbproductcomments pc
                    LEFT JOIN "._DB_PREFIX_."product p ON pc.id_product = p.id_product
                    WHERE p.id_manufacturer = '$id_manufacturer' AND pc.grade >= 3 AND pc.validate = 1
                    GROUP BY pc.id_product
                    ORDER BY date_add DESC
                    LIMIT $num";
            $comments = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
            if(is_array($comments) && count($comments) > 0) {
                $result = [];
                foreach ($comments as $comment) {
                    $product = new Product((int)$comment['id_product'], false, $id_lang);
                    $img = $product->getCover($product->id);
                    $image_type = 'small_default';
                    $img_url = $link->getImageLink(isset($product->link_rewrite) ? $product->link_rewrite : $product->name,
                                                   (int)$img['id_image'], $image_type);
                    $average = round($comment['grade'] * 100 / 5, 1);

                    $result[] = array(
                        'title' => $comment['customer_name'],
                        'grade' => $comment['grade'],
                        'date_add' => $comment['date_add'],
                        'img' => $img_url,
                        'url' => $link->getProductLink($product->id),
                        'product_name' => $product->name,
                        'average' => $average,
                    );
                }
            }
            return $result;
        }
    }

    public function getProgressProduct($id_product)
    {
        $result = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        );
        $sql = "SELECT count(*) total
                    FROM "._DB_PREFIX_."dbproductcomments
                    WHERE validate = 1 AND id_product = '$id_product'";
        $totals = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        $sql = "SELECT count(*) total, grade
                    FROM "._DB_PREFIX_."dbproductcomments
                    WHERE validate = 1 AND id_product = '$id_product'
                    GROUP BY grade";
        $progress = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        foreach($progress as $prog) {
            $result[$prog['grade']] = round($prog['total'] * 100 / $totals);
        }

        return $result;
    }

    public function getCommentsProduct($id_product)
    {
        $sql = "SELECT *
                    FROM "._DB_PREFIX_."dbproductcomments
                    WHERE validate = 1 AND id_product = '$id_product'";
        $comments = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        return $comments;
    }

    public function hookactionOrderStatusPostUpdate($params)
    {
        if($this->premium == 1) {
            DbProductCommentsPremium::hookactionOrderStatusPostUpdate($params);
        }
    }

}
