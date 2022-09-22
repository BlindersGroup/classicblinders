<?php

class dbwishlistajaxModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        $this->ajax = true;
        parent::initContent();
    }


    public function displayAjax()
    {
        $action = Tools::getValue('action');
        if($action === 'saveWishlist') {

            if(Context::getContext()->customer->isLogged()) {
                $id_product = (int)Tools::getValue('id_product');
                $id_customer = Context::getContext()->customer->id;
                $active = Tools::getValue('active');

                $modal = $this->module->renderWishlistModal($id_product, $id_customer, $active);
            } else {
                $modal = $this->module->renderGenericModal('login');
            }
            die(Tools::jsonEncode(array('modal' => $modal)));
        }

        if($action === 'removeWishlist') {

            if(Context::getContext()->customer->isLogged()) {
                $id_product = (int)Tools::getValue('id_product');
                $id_customer = Context::getContext()->customer->id;

                $modal = $this->module->removeWishlist($id_product, $id_customer);
            } else {
                $modal = $this->module->renderGenericModal('login');
            }
            die(Tools::jsonEncode(array('modal' => $modal)));
        }


    }

}
