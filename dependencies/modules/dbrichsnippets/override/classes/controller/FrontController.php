<?php

class FrontController extends FrontControllerCore
{

    protected function getBreadcrumbLinks()
    {
        $shop_name = Configuration::get('PS_SHOP_NAME');
        $breadcrumb = [];
        $breadcrumb['links'][] = [
            'title' => $shop_name,
            'url' => $this->context->link->getPageLink('index', true),
        ];
        return $breadcrumb;
    }
}