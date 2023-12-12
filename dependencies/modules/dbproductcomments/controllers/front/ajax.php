<?php

class dbproductcommentsajaxModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
        $this->ajax = true;
        parent::initContent();
    }


    public function displayAjax()
    {
        $action = Tools::getValue('action');
        if($action === 'form_comment') {

            if(Context::getContext()->customer->isLogged()) {
                $id_product = (int)Tools::getValue('id_product');
                $id_customer = (int)Context::getContext()->customer->id;

                $modal = $this->module->renderCommentModal($id_product, $id_customer);
            } else {
                $modal = $this->module->renderGenericModal('login');
            }
            die(json_encode(array('modal' => $modal)));
        }

        if($action === 'create_comment') {
            if(Context::getContext()->customer->isLogged()) {
                $id_product = (int)Tools::getValue('id_product');
                $id_customer = Context::getContext()->customer->id;
                $rate_global = (int)Tools::getValue('rate_global');
                $charact1 = (int)Tools::getValue('charact1');
                $charact2 = (int)Tools::getValue('charact2');
                $charact3 = (int)Tools::getValue('charact3');
                $recommend = (int)Tools::getValue('recomendacion');
                $title = Tools::getValue('title');
                $content = Tools::getValue('content');

                $comment = new DbProductCommentsComment();
                $comment->id_product = $id_product;
                $comment->id_customer = $id_customer;
                $comment->customer_name = Context::getContext()->customer->firstname.' '.Context::getContext()->customer->lastname[0].'.';
                $comment->title = $title;
                $comment->content = $content;
                $comment->grade = $rate_global;

                if($this->module->premium == 1) {
                    $comment->characteristic1 = $charact1;
                    $comment->characteristic2 = $charact2;
                    $comment->characteristic3 = $charact3;
                    $comment->recommend = $recommend;
                } else {
                    $comment->characteristic1 = 0;
                    $comment->characteristic2 = 0;
                    $comment->characteristic3 = 0;
                    $comment->recommend = 0;
                }

                $comment->validate = 0;
                $comment->deleted = 0;
                $comment->date_add = date('Y-m-d');
                $comment->add();

                $modal = $this->module->renderGenericModal('create_question');
            } else {
                $modal = $this->module->renderGenericModal('login');
            }
            die(json_encode(array('modal' => $modal)));
        }

    }

}
