{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

<div id="tabs" class="yan_tabs">
	<ul>
		<li><a href="#moneyorg">{l s='Яндекс.Касса' mod='yamodule'}</a></li>
		<li><a href="#mws">{l s='Яндекс.Касса: Управление.Заказами' mod='yamodule'}</a></li>
		<li><a href="#money">{l s='Яндекс.Деньги' mod='yamodule'}</a></li>
		<li><a href="#metrika">{l s='Яндекс.Метрика' mod='yamodule'}</a></li>
		<li><a href="#market">{l s='Яндекс.Маркет' mod='yamodule'}</a></li>
		<li><a href="#marketp">{l s='Заказы в Маркете' mod='yamodule'}</a></li>
	</ul>
	<div id="money">
		<div class="errors">{$p2p_status|escape:'quotes':'UTF-8'}</div>
		{$money_p2p|default:'':'UTF-8'}
	</div>
	<div id="moneyorg">
		<div class="errors">{$org_status|escape:'quotes':'UTF-8'}</div>
		{$money_org|default:'':'UTF-8'}
	</div>
	<div id="mws">
		<div class="errors">{$mws_status|escape:'quotes':'UTF-8'}</div>
		<p>{l s='Любое использование вами модуля Y.CMS означает полное и безоговорочное принятие вами условий' mod='yamodule'} <a target="_blank" href="https://money.yandex.ru/doc.xml?id=527052">{l s='лицензионного договора' mod='yamodule'} </a> {l s='Если вы не принимаете условия указанного договора в полном объеме, то не имеете права использовать программу в каких-либо целях.' mod='yamodule'}<p>
		<h4>Настройка взаимодействия по протоколу MWS (<a target="_blank" href="https://tech.yandex.ru/money/doc/payment-solution/payment-management/payment-management-about-docpage/">Merchant Web Services</a>)</h4>
		{if !$mws_cert}
			{if !$YA_ORG_ACTIVE || !$YA_ORG_SHOPID}
				{if !$YA_ORG_ACTIVE}
					<div class="alert alert-danger">{l s='Отключен модуль Яндекс.Кассы' mod='yamodule'}</div>
				{/if}
				{if !$YA_ORG_SHOPID}
					<div class="alert alert-danger">{l s='Отсутствует идентификатор магазина (shopId)' mod='yamodule'}</div>
				{/if}
			{else}
				<p>{l s='Для работы с MWS необходимо получить в Яндекс.Деньгах специальный сертификат и загрузить его в приложении.' mod='yamodule'}<p>
				<p>
				<form id="mws_form" class="market_form form-horizontal" method="post" action="">
					<div class="form-group">
						<label class="col-sm-3 control-label" for="mws_download">{l s='Сертификат' mod='yamodule'}</label>
						<div class="col-sm-3">
							<label id="mws_crt_load" class="btn btn-default"/>{l s='Загрузить' mod='yamodule'}</label>
						</div>
						<div class="col-sm-6" id='mws_cert_status'>
						</div>
					</div>
					<div class="form-group without-cert">
						<label class="col-sm-3 control-label" for="mws_rule">{l s='Как получить сертификат' mod='yamodule'}</label>
						<div class="col-sm-9">
							<ol>
								<li>{l s='Скачайте' mod='yamodule'} <a href="{$ajax_limk_ym|escape:'quotes':'UTF-8'}&output_csr">{l s='готовый запрос на сертификат' mod='yamodule'}</a> {l s='(файл в формате .csr).' mod='yamodule'}</li>
								<li>{l s='Скачайте' mod='yamodule'} <a target="_blank"  href="https://money.yandex.ru/i/html-letters/SSL_Cert_Form.doc">заявку на сертификат</a>. {l s='Ее нужно заполнить, распечатать, поставить подпись и печать. Внизу страницы — таблица с данными для заявки, просто скопируйте их. Отправьте файл запроса вместе со сканом готовой заявки менеджеру Яндекс.Денег на merchants@yamoney.ru.' mod='yamodule'}</li>
								<li>{l s='Загрузите сертификат, который пришлет вам менеджер, наверху этой страницы.' mod='yamodule'}</li>
							</ol>
						</div>
					</div>

					<div class="form-group without-cert">
						<label class="col-sm-3 control-label" >{l s='Данные для заполнения заявки' mod='yamodule'}</label>
						<div class="col-sm-9">
							{l s='Скопируйте эти данные в таблицу. Остальные строчки заполните самостоятельно.' mod='yamodule'}
							<table style="width: 600px;" class="table table-bordered">
								 <tr>
								<td>CN</td>
								<td>{$mws_cn|escape:'htmlall':'UTF-8'}</td>
								 </tr>
								 <tr>
								<td>{l s='Электронная подпись на сертификат' mod='yamodule'}</td>
								<td><textarea cols="80" disabled rows="13">{$mws_sign|escape:'htmlall':'UTF-8'}</textarea></td>
								 </tr>
								 <tr>
								<td>{l s='Причина запроса' mod='yamodule'}</td>
								<td>{l s='Первоначальный' mod='yamodule'}</td>
								 </tr>
							</table>
						</div>
					</div>								
				</form>
			{/if}
		{else}
			<div class="alert alert-success">{l s='Модуль настроен для работы с платежами и возвратами. Сертификат загружен.' mod='yamodule'}</div>
			<p>{l s='Просмотреть информацию о платеже или сделать возврат можно в ' mod='yamodule'}<a href="{$orders_link|escape:'quotes':'UTF-8'}">{l s='Списке заказов' mod='yamodule'}</a></p>
			<p><a class="reset_csr">{l s='Сбросить настройки' mod='yamodule'}</a></p>
		{/if}
	</p>
	</div>
	<div id="metrika">
		<div class="errors">{$metrika_status|escape:'quotes':'UTF-8'}</div>
		{$money_metrika|default:'':'UTF-8'}
		<div id="iframe_container"></div>
	</div>
	<div id="market">
		<div class="errors">{$market_status|escape:'quotes':'UTF-8'}</div>
		{$money_market|default:'':'UTF-8'}
	</div>
	<div id="marketp">
		<div class="errors">{$pokupki_status|escape:'quotes':'UTF-8'}</div>
		{$money_marketp|default:'':'UTF-8'}
	</div>
</div>
{literal}
<script type="text/javascript">
(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter27737730 = new Ya.Metrika({ id:27737730 }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/27737730" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
{/literal}
<style>
	.yan_tabs a {
		color:#00aff0 ;
	}
</style>
<script type="text/javascript"><!--
var step = new Array();
var total = 0;
$('.reset_csr').bind('click', function(ee) {
	ee.preventDefault();
	if (confirm('Все настройки для работы с MWS будут стерты. Сертификат нужно будет запросить повторно. Вы действительно хотите сбросить настройки MWS?')) {
		$.ajax({
			url: '{$ajax_limk_ym|escape:'quotes':'UTF-8'}&generate_cert',
			cache: false,
			success: function(json) {
				location.reload();
			}
		});
	}
});

$('#mws_crt_load').on('click', function() {
	$('#form-upload').remove();
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
	$('#form-upload input[name=\'file\']').trigger('click');
	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			$('.alert').remove();
			$.ajax({
				url: '{$ajax_limk_ym|escape:'quotes':'UTF-8'}&cert_upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#mws_crt_load').button('loading');
				},
				complete: function() {
					$('#mws_crt_load').button('reset');
				},
				success: function(json) {
					if (!json.error){	
						$('#mws_form').submit();
					} else {
						$('#mws_form').prepend("<div class='alert alert-danger'>"+ json.error +"</div>");
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
</script>