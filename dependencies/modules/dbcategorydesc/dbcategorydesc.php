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
*  @author    DevBlinders <info@devblinders.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Form\Admin\Type\FormattedTextareaType;
use PrestaShopBundle\Form\Admin\Type\TranslateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Dbcategorydesc extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'dbcategorydesc';
        $this->tab = 'seo';
        $this->version = '1.1.0';
        $this->author = 'DevBlinders';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('DB Category Large Description');
        $this->description = $this->l('Descripción larga en la sección de categorias');

        $this->ps_versions_compliancy = array('min' => '1.7.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');
        return parent::install() &&
            $this->registerHook('actionCategoryFormBuilderModifier') &&
            $this->registerHook('actionAfterUpdateCategoryFormHandler') &&
            $this->registerHook('afterCreateCategoryFormHandler') &&
            $this->registerHook('displayFooterCategory');
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');
        return $output;
    }

    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'/views/css/dbcategorydesc.css');
    }

    protected function getLargeDesc($id_category, $id_shop, $id_lang) {
        $result = Db::getInstance()->getRow(
            'SELECT * FROM `' . _DB_PREFIX_ . 'dbcategorydesc` 
            WHERE `id_category` = ' . $id_category . ' ' . ' AND `id_shop` = ' . $id_shop . ' AND `id_lang` = ' . $id_lang);
        return $result;
    }

    public function hookActionCategoryFormBuilderModifier(array $params) {
        $id_shop = (int)$this->context->shop->id;
        $id_category = (int)$params['id'];
        $formBuilder = $params['form_builder'];
        $locales = $this->get('prestashop.adapter.legacy.context')->getLanguages();

        $formBuilder->add('large_desc', TranslateType::class, [
            'type' => FormattedTextareaType::class,
            'label' => $this->getTranslator()->trans('Descripción larga', [], 'Modules.dbcategorydesc.Admin'),
            'locales' => $locales,
            'hideTabs' => false,
            'required' => false,
        ]);

        if(Module::isEnabled('dbaboutus')){

            require_once(dirname(__FILE__).'/../dbaboutus/classes/DbAboutUsAuthor.php');
            require_once(dirname(__FILE__).'/../dbaboutus/classes/DbAboutUsTag.php');
            // Authors
            $authors = DbAboutUsAuthor::getAuthors();
            $choiceAuthors = [];
            foreach($authors as $author){
                $choiceAuthors[$author['name']] = $author['id_dbaboutus_author'];
            }
            // Tags
            $tags = DbAboutUsTag::getTags();
            $choiceTags = [];
            foreach($tags as $tag){
                $choiceTags[$tag['name']] = $tag['id_dbaboutus_tag'];
            }

            $formBuilder
                ->add('id_editor', ChoiceType::class, [
                    'choices' => $choiceAuthors,
                    'label' => $this->getTranslator()->trans('Editor', [], 'Modules.dbcategorydesc.Admin'),
                    'required' => false,
                ])
                ->add('id_review', ChoiceType::class, [
                    'choices' => $choiceAuthors,
                    'label' => $this->getTranslator()->trans('Revisor', [], 'Modules.dbcategorydesc.Admin'),
                    'required' => false,
                ])
                ->add('id_tag', ChoiceType::class, [
                    'choices' => $choiceTags,
                    'label' => $this->getTranslator()->trans('Etiqueta', [], 'Modules.dbcategorydesc.Admin'),
                    'required' => false,
                ]);

        }

        foreach ($locales as $locale) {
            $id_lang = (int)$locale['id_lang'];
            $datas = $this->getLargeDesc($id_category, $id_shop, $id_lang);
            $params['data']['large_desc'][$id_lang] = $datas['large_desc'];
            $params['data']['id_editor'] = $datas['id_editor'];
            $params['data']['id_review'] = $datas['id_review'];
            $params['data']['id_tag'] = $datas['id_tag'];
        }

        $formBuilder->setData($params['data']);
    }

    public function hookActionAfterUpdateCategoryFormHandler(array $params) {
        $this->saveLargeDesc($params);
    }

    public function hookActionAfterCreateCategoryFormHandler(array $params) {
        $this->saveLargeDesc($params);
    }

    private function saveLargeDesc(array $params) {
        $id_category = (int)$params['id'];
        $formData = $params['form_data'];
        $id_shop = (int)$this->context->shop->id;
        $locales = $this->get('prestashop.adapter.legacy.context')->getLanguages();
        foreach ($locales as $locale) {
            $id_lang = (int)$locale['id_lang'];
            $large_desc = $formData['large_desc'][$id_lang];
            $id_editor = (int)$formData['id_editor'];
            $id_review = (int)$formData['id_review'];
            $id_tag = (int)$formData['id_tag'];
            $this->insertLargeDesc($id_shop, $id_lang, $id_category, $large_desc, $id_editor, $id_review, $id_tag);
        }
    }

    protected function insertLargeDesc($id_shop, $id_lang, $id_category, $large_desc, $id_editor = 0, $id_review = 0, $id_tag = 0) {
        if ($this->getLargeDesc($id_category, $id_shop, $id_lang)) {
            Db::getInstance()->update('dbcategorydesc',
                array(
                    'large_desc' => pSQL($large_desc, true),
                    'id_editor' => $id_editor,
                    'id_review' => $id_review,
                    'id_tag' => $id_tag,
                ),
                    '`id_category` = ' . $id_category . ' ' . ' AND `id_shop` = ' . $id_shop . ' AND `id_lang` = ' . $id_lang
                );

        } else {
            Db::getInstance()->insert('dbcategorydesc',
                array(
                    'large_desc' => pSQL($large_desc, true),
                    'id_category' => $id_category,
                    'id_shop' => $id_shop,
                    'id_lang' => $id_lang,
                    'id_editor' => $id_editor,
                    'id_review' => $id_review,
                    'id_tag' => $id_tag,
                ));
        }
    }

    public function hookDisplayFooterCategory(array $params) {
        $id_category = (int)Tools::getValue('id_category');
        $id_shop = (int)$this->context->shop->id;
        $id_lang = (int)$this->context->language->id;
        $datas = $this->getLargeDesc($id_category, $id_shop, $id_lang);
        $category = new Category($id_category, $id_lang);

        if($datas['large_desc']){

            if(Module::isEnabled('dbaboutus')){
                $editor = DbAboutUsAuthor::getAuthorById($datas['id_editor']);
                $review = DbAboutUsAuthor::getAuthorById($datas['id_review']);

                $sql = "SELECT tl.name
            FROM "._DB_PREFIX_."dbaboutus_tag t
            LEFT JOIN "._DB_PREFIX_."dbaboutus_tag_lang tl ON t.id_dbaboutus_tag = tl.id_dbaboutus_tag AND tl.id_lang = '$id_lang'
            WHERE t.active = 1 AND t.id_dbaboutus_tag = ".$datas['id_tag'];
                $tag = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            }

            $this->context->smarty->assign(array(
                'large_desc' => $datas['large_desc'],
                'update' => $category->date_upd,
                'category' => $category->name,
                'editor' => $editor,
                'review' => $review,
                'tag' => $tag,
            ));
            return $this->display(__FILE__, 'views/templates/hook/footer_category.tpl');
        }
    }

}
