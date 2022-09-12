

<?php

class dbfreeshippingajaxModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        $this->ajax = true;
        parent::initContent();
    }


    public function displayAjax()
    {
        $action = Tools::getValue('action');
        if($action === 'update_cart'){
            $cart = $this->module->getFreeShippingTotal();
        }
        die(Tools::jsonEncode(array('cart' => $cart)));
    }

}