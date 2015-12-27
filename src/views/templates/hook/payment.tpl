{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

{if $DATA_P2P && $DATA_P2P['YA_P2P_ACTIVE'] && $summ >= $DATA_P2P['YA_P2P_MIN']}
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<p class="payment_module">
				<a href="{$link->getModuleLink('yamodule', 'redirect', ['type' => 'wallet'])|escape:'quotes':'UTF-8'}" title="{l s='Оплата через Яндекс кошелёк' mod='yamodule'}" class="yandex_money_wallet">
					{l s='Оплата через Яндекс кошелёк' mod='yamodule'}
				</a>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<p class="payment_module">
				<a href="{$link->getModuleLink('yamodule', 'redirect', ['type' => 'card'])|escape:'quotes':'UTF-8'}" title="{l s='Оплата банковской картой' mod='yamodule'}" class="yandex_money_card">
					{l s='Оплата банковской картой' mod='yamodule'}
				</a>
			</p>
		</div>
	</div>
{/if}