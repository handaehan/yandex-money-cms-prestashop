{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

<div class="ya_result bg-warning">
    {l s='Ошибка платежа! Свяжитесь с поддержкой  укажите эти данные:' mod='yamodule'}   
	<ol>
		{$foreach $post as $k => $p}
			<li>{$k|escape:'htmlall':'UTF-8} --- {$p|escape:'htmlall':'UTF-8}</li>
		{/foreach}
	</ol>
</div>
