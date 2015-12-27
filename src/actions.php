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

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/yamodule.php');
$yamodule = new yamodule();
$return = array();
if (Tools::GetValue('action')) {
    $action = Tools::GetValue('action');
    $token = Tools::encrypt('AdminOrders'.(int)Tab::getIdFromClassName('AdminOrders').(int)Tools::getValue('idm'));
    if (strcasecmp($token, Tools::getValue('tkn')) == 0) {
        switch ($action) {
            case 'load_price':
                $return = $yamodule->processLoadPrice();
                break;
            case 'change_order':
                $return = $yamodule->processChangeCarrier();
                break;
        }
    } else {
        $return['errors'] = $yamodule->l('Invalid Security Token !');
    }
    die(Tools::jsonEncode($return));
}
