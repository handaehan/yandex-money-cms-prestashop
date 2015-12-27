{**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*}

<div class="center-block col-lg-7">
	<script>
	$(document).ready(function(){
		$('#myTabR a').click(function (e) {
			e.preventDefault()
			$(this).tab('show')
		})
	});
	</script>
	<ul class="nav nav-tabs" id="myTabR">
		<li class="active">
			<a href="#kassa_return">
				<i class="icon-time"></i>
				{l s='Возврат' mod='yamodule'}</span>
			</a>
		</li>
		<li>
			<a href="#kassa_return_table">
				<i class="icon-time"></i>
				{l s='История' mod='yamodule'} {*<span class="badge">{$kassa_returns|@count}</span>*}
			</a>
		</li>
	</ul>