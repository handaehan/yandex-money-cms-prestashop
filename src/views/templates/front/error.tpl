{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

{capture name=path}
    {l s='Оплата Банковской картой.' mod='yamodule'}
{/capture}

<h1 class="page-heading">
    {l s='Информация о оплате' mod='yamodule'}
</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="alert alert-warning">
        {l s='Ваша корзина пуста.' mod='yamodule'}
    </p>
{else}
    <form action="{$payment_link|escape:'quotes':'UTF-8'}" method="post">
	<input type="hidden" name="cnf" value="1" checked />
        <div class="box cheque-box">
            <h3 class="page-subheading">
                {l s='Оплата Банковской картой.' mod='yamodule'}
            </h3>
            <p class="cheque-indent">
                <strong class="dark">
                    {l s='Вы выбрали оплату через Банковскую карту.' mod='yamodule'} {l s='Во время заказа произошли следующие ошибки:' mod='yamodule'}
                </strong>
            </p>
            <p>
                <div class="alert alert-danger">
					<p>{l s='Колличество ошибок ' mod='yamodule'} {$errors|count}</p>
					<ol>
						{foreach $errors as $e}
							<li>{$e|escape:'htmlall':'UTF-8'}</li>
						{/foreach}
					</ol>
				</div>
            </p>
        </div>
        <p class="cart_navigation clearfix" id="cart_navigation">
        	<a 
            class="button-exclusive btn btn-default" 
            href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}">
                <i class="icon-chevron-left"></i>{l s='Другие методы оплаты' mod='yamodule'}
            </a>
        </p>
    </form>
{/if}