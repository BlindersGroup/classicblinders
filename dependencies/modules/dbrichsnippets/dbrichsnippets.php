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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Dbrichsnippets extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbrichsnippets';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Rich Snippets');
        $this->description = $this->l('Rich Snippets generales');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('DBRICHSNIPPETS_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitDbsitemapModule')) == true) {
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
        $helper->submit_action = 'submitDbsitemapModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Schema Organization'),
                        'name' => 'DBRICHSNIPPETS_ORGANIZATION',
                        'is_bool' => true,
                        'desc' => $this->l('Insertar el Schema de Organization'),
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
                        'type' => 'textarea',
                        'label' => $this->l('Descripción organización'),
                        'name' => 'DBRICHSNIPPETS_DESCRIPTION',
                        'desc' => $this->l('Descripcion insertar dentro del schema de organization'),
                        'lang'  => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Alternatename'),
                        'name' => 'DBRICHSNIPPETS_ALTERNATENAME',
                        'lang'  => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Empleados'),
                        'name' => 'DBRICHSNIPPETS_EMPLOYEES',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Facebook'),
                        'name' => 'DBRICHSNIPPETS_FACEBOOK',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Twitter'),
                        'name' => 'DBRICHSNIPPETS_TWITTER',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram'),
                        'name' => 'DBRICHSNIPPETS_INSTAGRAM',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Youtube'),
                        'name' => 'DBRICHSNIPPETS_YOUTUBE',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Linkedin'),
                        'name' => 'DBRICHSNIPPETS_LINKEDIN',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Pinterest'),
                        'name' => 'DBRICHSNIPPETS_PINTEREST',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Tik Tok'),
                        'name' => 'DBRICHSNIPPETS_TIKTOK',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Snapchat'),
                        'name' => 'DBRICHSNIPPETS_SANPCHAT',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('GitHub'),
                        'name' => 'DBRICHSNIPPETS_GITHUB',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $languages = Language::getLanguages(false);
        $values = array();

        foreach ($languages as $lang){
            $values['DBRICHSNIPPETS_DESCRIPTION'][$lang['id_lang']] = Configuration::get('DBRICHSNIPPETS_DESCRIPTION', $lang['id_lang']);
            $values['DBRICHSNIPPETS_ALTERNATENAME'][$lang['id_lang']] = Configuration::get('DBRICHSNIPPETS_ALTERNATENAME', $lang['id_lang']);
        }

        $values['DBRICHSNIPPETS_ORGANIZATION'] = Configuration::get('DBRICHSNIPPETS_ORGANIZATION');
        $values['DBRICHSNIPPETS_EMPLOYEES'] = Configuration::get('DBRICHSNIPPETS_EMPLOYEES');
        $values['DBRICHSNIPPETS_FACEBOOK'] = Configuration::get('DBRICHSNIPPETS_FACEBOOK');
        $values['DBRICHSNIPPETS_TWITTER'] = Configuration::get('DBRICHSNIPPETS_TWITTER');
        $values['DBRICHSNIPPETS_INSTAGRAM'] = Configuration::get('DBRICHSNIPPETS_INSTAGRAM');
        $values['DBRICHSNIPPETS_YOUTUBE'] = Configuration::get('DBRICHSNIPPETS_YOUTUBE');
        $values['DBRICHSNIPPETS_LINKEDIN'] = Configuration::get('DBRICHSNIPPETS_LINKEDIN');
        $values['DBRICHSNIPPETS_PINTEREST'] = Configuration::get('DBRICHSNIPPETS_PINTEREST');
        $values['DBRICHSNIPPETS_TIKTOK'] = Configuration::get('DBRICHSNIPPETS_TIKTOK');
        $values['DBRICHSNIPPETS_SANPCHAT'] = Configuration::get('DBRICHSNIPPETS_SANPCHAT');
        $values['DBRICHSNIPPETS_GITHUB'] = Configuration::get('DBRICHSNIPPETS_GITHUB');

        return $values;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();
        $languages = Language::getLanguages(false);
        // die(var_dump($form_values));

        foreach ($form_values as $name => $key) {
            if(is_array($key)){
                $values = array();
                foreach ($languages as $lang){
                    $values[$lang['id_lang']] = Tools::getValue($name . '_'.(int)$lang['id_lang']);
                }
                Configuration::updateValue($name, $values, true);
            } else {
                Configuration::updateValue($name, Tools::getValue($name));
            }
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $sectionType = Tools::getValue('controller');
        $context = Context::getContext();
        $id_lang = $context->language->id;
        $link = new Link();
        $json = '';

        // Datos
        $url = $link->getPageLink('index', null, $id_lang);
        $name = Configuration::get('PS_SHOP_NAME');
        $alternateName = Configuration::get('DBRICHSNIPPETS_ALTERNATENAME', $id_lang);
        $shop_logo = _PS_BASE_URL_.__PS_BASE_URI__.'/img/'.Configuration::get('PS_LOGO');
        $employees = Configuration::get('DBRICHSNIPPETS_EMPLOYEES');
        $description = Configuration::get('DBRICHSNIPPETS_DESCRIPTION', $id_lang);

        // ORGANIZATION
        $organization = Configuration::get('DBRICHSNIPPETS_ORGANIZATION');
        if($organization == true){

            $json_rrss = '';
            if(!empty(Configuration::get('DBRICHSNIPPETS_FACEBOOK'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_FACEBOOK') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_TWITTER'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_TWITTER') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_INSTAGRAM'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_INSTAGRAM') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_YOUTUBE'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_YOUTUBE') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_LINKEDIN'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_LINKEDIN') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_PINTEREST'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_PINTEREST') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_TIKTOK'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_TIKTOK') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_SNAPCHAT'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_SNAPCHAT') . '",';
            }
            if(!empty(Configuration::get('DBRICHSNIPPETS_GITHUB'))){
                $json_rrss .= '"' . Configuration::get('DBRICHSNIPPETS_GITHUB') . '",';
            }

            $json .= '<script type="application/ld+json">';
            $json .= '{
                            "@context":"https:\/\/schema.org",
                            "@type":"Organization",
                            "url":"'.$url.'",
                            "name":"'.$name.'",
                            "alternateName": "'.$alternateName.'",
                            "logo":"'.$shop_logo.'",
                            "numberOfEmployees":'.$employees.',
                            "description": "'.$description.'",
                            "sameAs":[
                                '. substr($json_rrss, 0 , -1) .'
                            ],';

            if (Module::isInstalled('dbaboutus') && Module::isEnabled('dbaboutus')) {

                $db = \Db::getInstance();
                $request = "SELECT * 
                            FROM `" . _DB_PREFIX_ . "dbaboutus_author` a
                            INNER JOIN `" . _DB_PREFIX_ . "dbaboutus_author_lang` al ON a.id_dbaboutus_author = al.id_dbaboutus_author AND al.id_lang = '$id_lang'
                            WHERE a.active = 1";
                $users = $db->executeS($request);
                if(count($users) > 0){
                    $json_user = '';
                    foreach($users as $user){
                        $url_user = DbAboutUsAuthor::getLink($user['link_rewrite']);
                        $json_user .= '{
                                    "@type":"person",
                                    "givenName": "'.$user['name'].'",
                                    "worksFor": "'.$name.'",
                                    "URL": "'.$url_user.'",
                                    "description": "'.strip_tags($user['short_desc']).'",
                                    "jobTitle": "'.$user['profession'].'"
                                },';
                    }
                    $json .= '"employees":[ ' . substr($json_user, 0, -1) . '],';
                }

            }

            $json .= '      "image": "'.$shop_logo.'"
                            }
                        }
                        </script>';
        }

        if($sectionType == 'index' || ($sectionType == 'category' && empty($category_blog))){

            if($sectionType == 'category'){

                // Breadcrumb
                $id_category = Tools::getValue('id_category');

                $json .= '
                <script type="application/ld+json">{
                    "@context":"https://schema.org",
                    "@type":"BreadcrumbList",
                        "itemListElement": [';

                $json .= '
                    {
                        "@type": "ListItem",
                        "position": 0,
                        "name": "'.$name.'",
                        "item": "'.$this->context->link->getPageLink('index', true).'"
                    },
                ';

                $categorias = $this->getbreadbrumbcategories($id_category, '', 1);
                $json .= substr($categorias['json'], 0 , -1);

                $json .= '
                        ]
                }</script>'; 

            }

        } elseif ($sectionType == 'contact') {

            /* BreadcrumbList Contacto */
            $json_breadcrumb = '';
            $json .= '
            <script type="application/ld+json">{
                "@context":"https://schema.org",
                "@type":"BreadcrumbList",
                    "itemListElement": [';

            $breadcrumbs = $this->context->smarty->tpl_vars['breadcrumb']->value['links'];
            foreach($breadcrumbs as $position => $breadcrumb){
                $json_breadcrumb .= '
                    {
                        "@type": "ListItem",
                        "position": '.$position.',
                        "name": "'.$breadcrumb['title'].'",
                        "item": "'.$breadcrumb['url'].'"
                    },';
            }

            $json .= substr($json_breadcrumb, 0, -1);

            $json .= '
                    ]
            }</script>';

        } elseif ($sectionType == 'product') {

            $id_producto = (int)Tools::getValue('id_product');
            if($id_producto > 0) {
                $product = new Product($id_producto, true, $id_lang);
                $valoracion = '';

                // Url del producto
                $link = new Link();
                $product_url = $link->getProductLink((int)$id_producto);

                // Categoria del producto
                $category = new Category($product->id_category_default, $id_lang);
                $categoria = $category->name;

                // Breadcrumb
                $categorias = $this->getProductPathForCrumbs((int)$product->id_category_default,
                    $product->name[$id_lang], true);
                $json .= '
                <script type="application/ld+json">{
                    "@context":"https://schema.org",
                    "@type":"BreadcrumbList",
                        "itemListElement": [';

                $json .= '
                        {
                            "@type": "ListItem",
                            "position": 0,
                            "name": "' . $name . '",
                            "item": "' . $this->context->link->getPageLink('index', true) . '"
                        },
                    ';

                $categorias = $this->getbreadbrumbcategories($product->id_category_default,
                    $product->name[$id_lang], 1);
                $json .= $categorias['json'];
                $json .= '
                                {
                                    "@type": "ListItem",
                                    "position": ' . $categorias['number'] . ',
                                    "name": "' . $product->name . '",
                                    "item": "' . $product_url . '"
                                }
                            ';

                $json .= '
                        ]
                }</script>';

                // Imagen producto
                $protocol_http = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 || $_SERVER['HTTP_X_FORWARDED_PORT'] == 443) ? "https://" : "http://";
                $images = [];
                $imagenes = $product->getImages($id_lang);
                foreach($imagenes as $img) {
                    $images[] = $protocol_http.$link->getImageLink(isset($product->link_rewrite) ? $product->link_rewrite : $product->name,
                        (int)$img['id_image'], 'large_default');
                }

                // Marca
                $id_manufacturer = $product->id_manufacturer;
                $manufacturer = new Manufacturer($id_manufacturer);

                // Rating product
                $sql = "SELECT count(*) as total, SUM(grade) as suma FROM " . _DB_PREFIX_ . "dbproductcomments WHERE id_product = '$id_producto' AND validate = 1";
                $rating = Db::getInstance()->getRow($sql);
                $rating_total = (int)$rating['suma'];
                if ($rating_total == 0) {
                    $ratingValue = 0;
                } else {
                    $ratingValue = round($rating['suma'] / $rating['total'], 1);
                }

                // Valoraciones
                $sql = "SELECT * FROM " . _DB_PREFIX_ . "dbproductcomments WHERE id_product = '$id_producto' AND validate = 1";
                $valoraciones = Db::getInstance()->executeS($sql);
                if (count($valoraciones) > 0) {
                    foreach ($valoraciones as $val) {
                        $valoracion .= '{
                            "@type": "Review",
                            "author": {
                                "@type": "Person",
                                "name": "'.$val['customer_name'].'"
                            },
                            "datePublished": "' . date("d/m/Y", strtotime($val['date_add'])) . '",
                            "reviewBody": "' . strip_tags($val['content']) . '",
                            "reviewRating": {
                                "@type": "Rating",
                                "bestRating": "5",
                                "ratingValue": "' . (int)$val['grade'] . '",
                                "worstRating": "1"
                            }
                        },';
                    }
                    $vals = substr($valoracion, 0, -1);
                }

                // Oferta
                $offer = 0;
                $available = 'http://schema.org/InStock';
                $price = Product::getPriceStatic($product->id, true, null, 2);
                $price_orig = $product->getPriceWithoutReduct();
                if($price < $price_orig) {
                    $offer = 1;

                    if($product->available_for_order == 1) {
                        $available = 'http://schema.org/InStock';
                    } else {
                        $available = 'http://schema.org/OutOfStock';
                    }

                    $fecha_upd = explode(' ', $product->date_upd);
                    $date_upd = $fecha_upd[0];
                }



                // Producto
                $json .= '<script type="application/ld+json">{
                    "@context": "https://schema.org",
                    "@type": "Product",
                    "description": "' . str_replace('"', "'", strip_tags($product->description_short)) . '",
                    "name": "' . str_replace('"', "'", $product->name) . '",
                    "image": ' . json_encode($images) . ',
                    "brand": {
                        "@type": "Brand",
                        "name": "' . str_replace('"', "'", $manufacturer->name) . '",
                        "url": "' . $link->getManufacturerLink($manufacturer) . '"
                    },
                    "category": "' . $categoria . '",
                    "alternateName": "Compra ' . str_replace('"', "'", $product->name) . ' a buen precio",
                    "url": "' . $product_url . '"';
                if($offer == 1) {
                    $json .= ',
                        "offers": {    		
                            "@type": "offer",
                            "price": "' . $price . '",
                            "priceCurrency": "' . $context->currency->iso_code . '", 
                            "itemOffered": "' . str_replace('"', "'", $product->name) . '",
                            "availability": "'.$available.'", 
                            "priceValidUntil": "'.$date_upd.'",
                            "itemCondition":"http://schema.org/NewCondition", 
                            "url": "' . $product_url . '"
                        }';
                }
                if ($rating['total'] > 0) {
                    $json .= ',
                        "aggregateRating": {
                            "@type": "AggregateRating",
                            "name": "' . str_replace('"', "'", $product->name) . '",
                            "ratingValue": "' . $ratingValue . '",
                            "bestRating": "5",
                            "worstRating": "1",
                            "reviewCount": "' . $rating_total . '"
                        }';

                    $json .= ',  		
                            "review": [
                                ' . $vals . '                
                            ]';
                }

                if (!empty($product->reference)) {
                    $json .= ',"sku": "' . $product->reference . '"';
                }

                if (!empty($product->ean13)) {
                    $json .= ',"gtin13": ' . $product->ean13;
                }

                $json .= '}</script>';
            }

        } elseif ($sectionType == 'manufacturer') {

            $id_manufacturer = Tools::getValue('id_manufacturer');

            /* BreadcrumbList Marca */
            $json .= '
            <script type="application/ld+json">{
                "@context":"https://schema.org",
                "@type":"BreadcrumbList",
                    "itemListElement": [';

            $json .= '
                {
                    "@type": "ListItem",
                    "position": 0,
                    "name": "'.$name.'",
                    "item": "'.$this->context->link->getPageLink('index', true).'"
                },
            ';

            $brands = $this->getbreadbrumbmanufacturer($id_manufacturer);
            $json .= $brands['json'];

            $json .= '
                    ]
            }</script>'; 
            /* BreadcrumbList Marca */

        } elseif ($sectionType == 'cms') {

            $id_cms = Tools::getValue('id_cms');

            /* BreadcrumbList Marca */
            $json .= '
            <script type="application/ld+json">{
                "@context":"https://schema.org",
                "@type":"BreadcrumbList",
                    "itemListElement": [';

            $json .= '
                {
                    "@type": "ListItem",
                    "position": 0,
                    "name": "'.$name.'",
                    "item": "'.$this->context->link->getPageLink('index', true).'"
                },
            ';

            $cms = new CMS($id_cms);
            $link_cms = $link->getCmsLink($id_cms);

            $json .= '  {
                "@type": "ListItem",
                "position": 1,
                "name": "'.$cms->meta_title[1].'",
                "item": "'.$link_cms.'"
            }';

            $json .= '
                    ]
            }</script>'; 
            /* BreadcrumbList Marca */

        }

        return $json;
    }

    private function getbreadbrumbcategories($id_category_default, $product_name, $final = 0)
    {
        $categorias = $this->getProductPathForCrumbs((int)$id_category_default, $product_name, true);
        $j = 1;
        if($categorias == NULL){
            return;
        } else {
            $totcat = count($categorias);
        }
        $json = '';
        foreach ($categorias as $category) {
            $url_categoria = Tools::safeOutput($this->context->link->getCategoryLink((int)$category['id_category'], $category['link_rewrite']));
        /*    $json .= '
                        {"@type":"ListItem",
                            "position":'.$j.',
                            "item":"@id":"'.$url_categoria.'",
                            "name":"'.$category['name'].'"'; */

            $json .= '  {
                    "@type": "ListItem",
                    "position": '.$j.',
                    "name": "'.$category['name'].'",
                    "item": "'.$url_categoria.'"
                ';

        if ($final == 0) {
	        if ($j > $totcat) {
                $json .= '}';
            } else {
                $json .= '},';
            }
        } else {
            if ($j > $totcat) {
                $json .= '}';
            } else {
                $json .= '},';
            }
        }

            $j++;
            
        }
        $return = array(
            'json' => $json, 
            'number' => $j
        );

        return $return;

    }

    public static function getProductPathForCrumbs($id_category, $path = '', $link_on_the_item = false, $category_type = 'products', Context $context = null)
    {
        if (!$context)
            $context = Context::getContext();


        //if ($category_type === 'products')
        //{
            $interval = Category::getInterval($id_category);
            $id_root_category = $context->shop->getCategory();
            $interval_root = Category::getInterval($id_root_category);
            if ($interval)
            {
                $sql = 'SELECT c.id_category, cl.name, cl.link_rewrite
                        FROM '._DB_PREFIX_.'category c
                        LEFT JOIN '._DB_PREFIX_.'category_lang cl ON (cl.id_category = c.id_category'.Shop::addSqlRestrictionOnLang('cl').')
                        WHERE c.nleft <= '.$interval['nleft'].'
                            AND c.nright >= '.$interval['nright'].'
                            AND c.nleft >= '.$interval_root['nleft'].'
                            AND c.nright <= '.$interval_root['nright'].'
                            AND cl.id_lang = '.(int)$context->language->id.'
                            AND c.active = 1
                            AND c.level_depth > '.(int)$interval_root['level_depth'].'
                        ORDER BY c.level_depth ASC';
                //echo $sql;
                $categories = Db::getInstance()->executeS($sql);

                return $categories;
            }
        //}
    }

    private function getbreadbrumbmanufacturer($id_manufacturer)
    {
        $link = new Link();
        $manufacturer = new Manufacturer($id_manufacturer);
        $link_manufacturer = $link->getManufacturerLink($id_manufacturer);


        $json = '';
        $json .= '  {
            "@type": "ListItem",
            "position": 1,
            "name": "'.$manufacturer->name.'",
            "item": "'.$link_manufacturer.'"
        }';

        $return = array(
            'json' => $json, 
        );

        return $return;

    }

}
