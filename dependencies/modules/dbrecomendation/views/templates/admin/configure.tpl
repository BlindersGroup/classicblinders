{*
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel">
	<h2>{l s='Product recommendation' mod='dbrecomendation'}</h2>

	<div class="row">
		<div class="col-lg-12 col-xl-6">
			<fieldset class="form-group mb-0">
				<label class="form-control-label">{l s='Author' mod='dbrecomendation'}</label>
				<select id="form_id_author" name="id_author" class="custom-select custom-select">
					<option>{l s='Seleccionar' mod='dbrecomendation'}</option>
					{foreach from=$authors item=author}
						<option value="{$author.id_dbaboutus_author}"
							{if $recommendation.id_author && $author.id_dbaboutus_author == $recommendation.id_author}selected="selected"{/if}
						>
							{$author.name}
						</option>
					{/foreach}
				</select>
			</fieldset>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-lg-12 col-xl-12">
			<fieldset class="form-group mb-0">
				<label class="form-control-label">{l s='Recommendation' mod='dbrecomendation'}</label>
				<textarea class="autoload_rte" id="recommendation" name="recommendation" rows="10" cols="45">{$recommendation.recomendation}</textarea>
			</fieldset>
		</div>
	</div>
</div>
