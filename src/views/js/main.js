/**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*/

$(document).ready(function(){
	hideMethods();
	$('input[name="YA_ORG_INSIDE"]').change(function(){
		hideMethods();
	})
	$('#tabs').tabs();
	var view = $.totalStorage('tab_ya');
	if(view == null)
		$.totalStorage('tab_ya', 'money');
	else
		$('.ui-tabs-nav li a[href="#'+ view +'"]').click();
	
	$('.ui-tabs-nav li').live('click', function(){
		var view = $(this).find('a').first().attr('href').replace('#', '');
		$.totalStorage('tab_ya', view);
	});
});

function strpos( haystack, needle, offset){
    var i = haystack.indexOf( needle, offset );
    return i >= 0 ? i : false;
}

function hideMethods()
{
	var inside = $('input[name="YA_ORG_INSIDE"]:checked').val();
	if (inside == 1)
	{
		$('#YA_ORG_PAYMENT_YANDEX').parents('.form-group').first().slideDown('slow');
		$('.text_inside').parents('.form-group').first().slideUp('slow');
	}
	else
	{
		$('#YA_ORG_PAYMENT_YANDEX').parents('.form-group').first().slideUp('slow');
		$('.text_inside').parents('.form-group').first().slideDown('slow');
	}

	return inside;
}
