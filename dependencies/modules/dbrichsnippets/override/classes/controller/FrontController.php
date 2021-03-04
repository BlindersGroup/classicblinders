<?php

class FrontController extends FrontControllerCore
{

    protected function getBreadcrumbLinks()
    {
        $breadcrumb = [];

        $breadcrumb['links'][] = [
            'title' => $this->getTranslator()->trans('Expertos en PrestaShop', [], 'Shop.Theme.Global'),
            'url' => $this->context->link->getPageLink('index', true),
        ];

        return $breadcrumb;
    }
}