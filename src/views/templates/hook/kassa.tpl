{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

{if $DATA_ORG && $DATA_ORG['YA_ORG_ACTIVE'] && $summ >= $DATA_ORG['YA_ORG_MIN']}
	<div class="row">
		<div class="col-xs-12 col-md-6">
			<p class="payment_module">
				<a class='ym_{$pt|escape:'htmlall':'UTF-8'}' href="{$link->getModuleLink('yamodule', 'redirectk', ['type' => {$pt|escape:'htmlall':'UTF-8'}], true)|escape:'quotes':'UTF-8'}" title="{l s='Yandex.Money' mod='yamodule'}">
					{$buttontext|escape:'htmlall':'UTF-8'}
				</a>
			</p>
		</div>
	</div>
{/if}