{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

	<div class="tab-content panel">
		<div class="tab-pane active" id="kassa_return">
			{if isset($return_success) && $return_success}<p class='alert alert-success'>{$text_success|escape:'htmlall':'UTF-8'}</p>{/if}
			{if isset($return_errors) && $return_errors|count > 0}
				{foreach $return_errors as $ke}
					<p class='alert alert-danger'>{$ke|escape:'htmlall':'UTF-8'}</p>
				{/foreach}
			{/if}

			<form class="form-horizontal" method='post' action="">
			<table class="table table-bordered">
			{if $invoiceId}
			<tr>
				<td>{l s='Номер транзакции Яндекс.Касса' mod='yamodule'}</td>
				<td>{$invoiceId|escape:'htmlall':'UTF-8'}</td>
			</tr>
			<tr>
				<td>{l s='Номер заказа' mod='yamodule'}</td>
				<td>{$id_order|escape:'htmlall':'UTF-8'}</td>
			</tr>
			<tr>
				<td>{l s='Способ оплаты' mod='yamodule'}</td>
				<td>{$payment_method|escape:'htmlall':'UTF-8'}</td>
			</tr>
			<tr>
				<td>{l s='Сумма платежа' mod='yamodule'}</td>
				<td>
					{displayPrice price=$doc->total_paid_tax_incl}&nbsp;
				</td>
			</tr>
			<tr>
				<td>{l s='Возвращено' mod='yamodule'}</td>
				<td>{$return_total|escape:'htmlall':'UTF-8'}</td>
			</tr>
			<tr>
				<td>{l s='Сумма возврата' mod='yamodule'}</td>
				<td style="width: 350px;">
					<div class="input-group">
						<span class="input-group-addon"> руб</span>
						<input type="text" name="return_sum" class='control-form' value="{$doc->total_paid_tax_incl|replace:',':'.' - $return_total|replace:',':'.'}" id="return_sum" />
					</div>
				</td>
			</tr>
			  <tr>
				 <td>{l s='Причина возврата' mod='yamodule'}</td>
				 <td><textarea class='control-form' name='return_cause'></textarea></td>
			  </tr>
			  <tr>
				 <td colspan='2'><button {if !$invoiceId}disabled{/if} type='submit' class='btn btn-success'>{l s='Сделать возврат' mod='yamodule'}</button></td>
			  </tr>
			{else}
				<tr>
					<td colspan='3'><div class='alert alert-danger'>{l s='Информация по платежу отсутствует. Причиной может быть ошибочный сертификат по работе с MWS или настройки модуля Яндекс.Касса' mod='yamodule'}</div></td>
				</tr>
			{/if}
			</table>
			</form>
		</div>
		<div class="tab-pane" id="kassa_return_table">
			<div id="history"></div>
			<br />
			  <legend>{l s='Список возвратов' mod='yamodule'}</legend>
			  <form class="form-horizontal">
				<div class="form-group">
				  <div class="col-lg-12">
						<table class='table'>
						<tr>
							<td>{l s='Дата возврата' mod='yamodule'}</td>
							<td>{l s='Сумма возврата' mod='yamodule'}</td>
							<td>{l s='Причина возврата' mod='yamodule'}</td>
						</tr>
						{if $return_items}
							{foreach $return_items as $ret}
							 <tr>
								 <td>{$ret['date']|escape:'htmlall':'UTF-8'}</td>
								 <td>{displayPrice price=$ret['amount']}&nbsp;</td>
								 <td>{$ret['cause']|escape:'htmlall':'UTF-8'}</td>
							 </tr>
							 {/foreach}
						{else}
							 <tr>
								 <td colspan='3'><div class='alert alert-danger'>{l s='Успешные возвраты по данному платежу отсутствуют' mod='yamodule'}</div></td>
							 </tr>
						{/if}
						</table>
				  </div>
				</div>
			  </form>
		</div>
	</div>
</div>