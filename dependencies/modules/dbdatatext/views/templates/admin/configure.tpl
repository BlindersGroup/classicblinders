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
* @author    DevBlinders <soporte@devblinders.com>
* @copyright Copyright (c) DevBlinders
* @license   Commercial license
*}

<div class="iframetop_devblinders" style="margin-bottom: 1rem;">
	<iframe src="https://cdn.devblinders.com/modules/free/iframe.php?module=classicblinders"
			width="100%"
			height="80px"
			border="0"
			frameborder="0"
			scrolling="no"
			id="frame_module"
	>
	</iframe>
</div>

<div class="panel">
	<h3><i class="icon icon-tags"></i> {l s='Documentation' mod='dbdatatext'}</h3>
	<p>{l s='Este módulo no ofusca los enlaces automáticamente, hay que modificar el html del enlace.' mod='dbdatatext'}</p>
	<p>{l s='Para la ofuscación necesitamos tener en cuenta los siguientes puntos:' mod='dbdatatext'}</p>
	<ol>
		<li>{l s='La clase del contenedor (div, span, p, etc) debe de contener una llamada' mod='dbdatatext'} <strong>datatext</strong></li>
		<li>{l s='Debe de haber una etiqueta llamada' mod='dbdatatext'} <strong>datatext</strong> {l s='y dentro insertar el enlace' mod='dbdatatext'}</li>
		<li>{l s='El enlace debe de estar codificado en Base64' mod='dbdatatext'}</li>
		<li>{l s='Si queremos abrir el enlace en una pestaña nueva hay que añadirle la siguiente etiqueta' mod='dbdatatext'} <strong>datatarget="blank"</strong></li>
	</ol>
	<br />
	<p>{l s='Ejemplo de enlace a ofuscar' mod='dbdatatext'}:</p>
	{assign var="enlace_antes" value='<a href="url_producto" class="thumbnail product-thumbnail">Anchor text</a>'}
	<p>{$enlace_antes|escape}</p>
	<p>{l s='Lo modificamos con este formato' mod='dbdatatext'}</p>
	{assign var="enlace_nuevo" value='<span class="thumbnail product-thumbnail datatext" datatext="url_producto_codificado_base64">Anchor text</span>'}
	<p>{$enlace_nuevo|escape}</p>
	<p>{l s='Si queremos abrir el link en una pestaña nueva seria este formato' mod='dbdatatext'}</p>
	{assign var="enlace_nuevo_target" value='<span class="thumbnail product-thumbnail datatext" datatext="url_producto_codificado_base64" datatarget="blank">Anchor text</span>'}
	<p>{$enlace_nuevo_target|escape}</p>
</div>

<div class="iframebottom_devblinders">
	<iframe src="https://cdn.devblinders.com/modules/free/iframe_bottom.php?module=classicblinders"
			width="100%"
			height="250"
			border="0"
			frameborder="0"
			scrolling="no"
			id="frame_module"
	>
	</iframe>
</div>