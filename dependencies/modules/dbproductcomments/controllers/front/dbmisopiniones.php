<?php

class DbproductcommentsDbmisopinionesModuleFrontController extends ModuleFrontController
{
    public $home;
    public $parents = [];

    public function init()
    {
        parent::init();
    }

    public function initContent()
    {
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        $id_customer = (int)Context::getContext()->customer->id;
        $module = Module::getInstanceByName('dbproductcomments');

        parent::initContent();

	    if(!Context::getContext()->customer->isLogged()){
            $url_login = $this->context->link->getPageLink('myaccount');
            Tools::redirectLink($url_login);
        }

        // Sacamos las opiniones
        $products = $this->getBuyProducts($id_customer);

        $charact1 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC1');
        $charact2 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC2');
        $charact3 = Configuration::get('DBPRODUCTCOMMENTS_CHARACTERISTIC3');

        $this->context->smarty->assign(array(
            'products' => $products,
            'charact1' => $charact1,
            'charact2' => $charact2,
            'charact3' => $charact3,
            'premium'  => $module->premium,
        ));

        $this->setTemplate('module:dbproductcomments/views/templates/front/misopiniones.tpl');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->l('Mis opiniones'),
            'url' => '',
        ];

        return $breadcrumb;
    }


    public function setMedia()
    {
        parent::setMedia();

        /*$this->registerStylesheet(
            'module-modulename-style',
            'themes/classicblinders/assets/css/customer.css',
            [
                'media' => 'all',
                'priority' => 200,
            ]
        );*/
    }

    public function getBuyProducts($id_customer)
    {
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        $customer = new Customer($id_customer);
        $products = [];
        $ids_products_bought = [];

        $bought_products = $customer->getBoughtProducts();
        foreach($bought_products as $bought) {
            $id_product = $bought['product_id'];
            $ids_products_bought[] = $id_product;
            $sql = "SELECT *
                    FROM " . _DB_PREFIX_ . "dbproductcomments
                    WHERE id_product = '$id_product' AND id_customer = '$id_customer' AND validate = 1 AND deleted = 0";
            $comment = Db::getInstance()->executeS($sql);
            if(empty($comment)) {
                $products['not_bought'][] = $this->getProductContent($id_product);
            } else {
                $products['bought'][] = array(
                    'product' => $this->getProductContent($id_product),
                    'comment' => $comment,
                );
            }
        }

        $comments_random = $this->getProductComment($id_customer, $ids_products_bought);
        foreach($comments_random as $comment) {
            $products['bought'][] = array(
                'product' => $this->getProductContent($comment['id_product']),
                'comment' => [$comment],
            );
        }

        return $products;

    }

    public function getProductContent($id_product)
    {
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        $link = new Link();
        $product = new Product($id_product, false, $id_lang, $id_shop);

        $name = $product->name;
        $url = $link->getProductLink($id_product).'#dbproductcomments_product';
        $image = $product->getCover($product->id);
        $img = '//'.$link->getImageLink($product->link_rewrite, $image['id_image'], 'home_default');

        return array(
            'name_product' => $name,
            'url_product' => $url,
            'img_product' => $img,
        );
    }

    public function getProductComment($id_customer, $ids_products_bought)
    {
        $ids_products_bought = implode(',', $ids_products_bought);
        $sql = "SELECT * 
                FROM "._DB_PREFIX_."dbproductcomments 
                WHERE id_customer = '$id_customer' AND validate = 1 AND deleted = 0";
        if(!empty($ids_products_bought)) {
            $sql .= " AND id_product NOT IN (".$ids_products_bought.")";
        }
        $comments = Db::getInstance()->executeS($sql);

        return $comments;
    }

}
