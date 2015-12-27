{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

<form target="" name="yamoney_form{$pt|escape:'html':'UTF-8'}" action="https://{if !$DATA_ORG['YA_ORG_TYPE']}demo{/if}money.yandex.ru/eshop.xml" method="post">
	<input type="hidden" name="cms_name" value="ya_prestashop">
	<input type="hidden" value="KASSA_{$id_cart|escape:'html':'UTF-8'}" name="label" />
	<input type="hidden" value="KASSA_{$id_cart|escape:'html':'UTF-8'}" name="orderNumber" />
	<input type="hidden" value="{$pt|escape:'html':'UTF-8'}" name="paymentType" />
	<input type="hidden" name="shopId" value="{$DATA_ORG['YA_ORG_SHOPID']|escape:'html':'UTF-8'}"/>
	<input type="hidden" name="scid" value="{$DATA_ORG['YA_ORG_SCID']|escape:'html':'UTF-8'}"/>
	<input type="hidden" name="sum" value="{$total_to_pay|escape:'html':'UTF-8'}"/>
	<input type="hidden" name="customerNumber" value="KASSA_{$id_cart|escape:'html':'UTF-8'}"/>
	<input type="hidden" name="shopSuccessURL" value="{$link->getModuleLink('yamodule', 'success', [], true)|escape:'quotes':'UTF-8'}"/>
	<input type="hidden" name="shopFailURL" value="{$link->getPageLink('order.php', true, null, 'step=3')|escape:'quotes':'UTF-8'}"/>
	<input type="submit" style="display: none;" value="{l s='Click here to proceed with the payment' mod='yamodule'}"/>
	<input name="cps_phone" value="{$address->phone_mobile|escape:'html':'UTF-8'}" type="hidden"/> 
	<input name="cps_email" value="{$customer->email|escape:'html':'UTF-8'}" type="hidden"/> 
</form>
{literal}
	<script>
			document.yamoney_form{/literal}{$pt|escape:'html':'UTF-8'}{literal}.submit();
	</script>
{/literal}