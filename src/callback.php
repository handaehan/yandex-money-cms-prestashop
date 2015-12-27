<?php
/**
* Module is prohibited to sales! Violation of this condition leads to the deprivation of the license!
*
* @category  Front Office Features
* @package   Yandex Payment Solution
* @author    Yandex.Money <cms@yamoney.ru>
* @copyright © 2015 NBCO Yandex.Money LLC
* @license   https://money.yandex.ru/doc.xml?id=527052
*/

require_once(dirname(__FILE__) . '/../../config/config.inc.php');
require_once(dirname(__FILE__) . '/../../init.php');
require_once(dirname(__FILE__) . '/yamodule.php');
require_once(dirname(__FILE__) . '/classes/callback.php');
$yamodule = new yamodule();
$m = new Metrika();
$code = Tools::getValue('code');
$error = Tools::getValue('error');
$state = Tools::getValue('state');
$response = $m->run();
if ($error == '') {
    $state = explode('_', $yamodule->cryptor->decrypt($state));
    $type = $state[2];
    $m->code = $code;
    $m->getToken($type);
    Tools::redirect(
        _PS_BASE_URL_.__PS_BASE_URI__.$state[0].'/'.Context::getContext()->link->getAdminLink('AdminModules', false)
        .($m->errors ? '&error='.$yamodule->cryptor->encrypt($m->errors) : '')
        .'&configure=yamodule&tab_module=payments_gateways&module_name=yamodule&token='
        .Tools::getAdminToken('AdminModules'.(int)Tab::getIdFromClassName('AdminModules').(int)$state[1])
    );
} else {
    die('error #'.$error.' error description: '.Tools::getValue('error_description'));
}
