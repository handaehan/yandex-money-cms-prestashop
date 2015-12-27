{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

<div class="box">
	<p class = "success">{l s='Платёж успешно завершён' mod='yamodule'}</p>
	<h2>{l s='Список заказанных товаров:' mod='yamodule'}</h2>
	<ul>
	{foreach from=$products item=product}
		<li>{if $product.download_hash}
			<a href="{$base_dir|escape:'htmlall':'UTF-8'}get-file.php?key={$product.filename|escape:'htmlall':'UTF-8'}-{$product.download_hash|escape:'htmlall':'UTF-8'}">
				<img src="{$img_dir|escape:'htmlall':'UTF-8'}icon/download_product.gif" class="icon" alt="" />
			</a>
			<a href="{$base_dir|escape:'htmlall':'UTF-8'}get-file.php?key={$product.filename|escape:'htmlall':'UTF-8'}-{$product.download_hash|escape:'htmlall':'UTF-8'}">
				{l s='Download' mod='yamodule'} {$product.product_name|escape:'htmlall':'UTF-8'}
			</a>
			{else}
			{$product.product_name|escape:'htmlall':'UTF-8'}
		{/if}
		</li>
	{/foreach}
	</ul>
</div>