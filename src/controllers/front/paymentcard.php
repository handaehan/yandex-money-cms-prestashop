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

class YamodulePaymentCardModuleFrontController extends ModuleFrontController
{
    public $display_header = true;
    public $display_column_left = true;
    public $display_column_right = false;
    public $display_footer = true;
    public $ssl = true;
    public $errors;

    public function postProcess()
    {
        parent::postProcess();
        $this->log_on = Configuration::get('YA_P2P_LOGGING_ON');
        $cart = $this->context->cart;
        if ($cart->id_customer == 0
            || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0
            || !$this->module->active
        ) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $this->module->payment_status = false;
        $requestId = $this->module->cryptor->decrypt(urldecode($this->context->cookie->ya_encrypt_CRequestId));
        $res = new stdClass();
        Tools::p($_REQUEST);
        $res->status = Tools::getValue('status');
        $res->error = Tools::getValue('reason');
        if (!empty($requestId)) {
            if ($res->status == 'success') {
                $this->updateStatus($res);
                $this->error = false;
            } else {
                $this->error = true;
                $this->errors[] = $this->module->descriptionError($res->error);
            }
        } else {
            $this->errors[] = $this->module->l('Not received the correct data from Yandex.Money');
            if ($this->log_on) {
                $this->module->logSave('payment_card: Error '.$this->module->l('Invalid send data'));
            }
            return;
        }
    }

    public function updateStatus(&$resp)
    {
        $this->log_on = Configuration::get('YA_P2P_LOGGING_ON');
        if ($resp->status == 'success') {
            $cart = $this->context->cart;
            if ($cart->id>0) {
                if ($cart->orderExists()) {
                    $ord = new Order((int)Order::getOrderByCartId($cart->id));
                } else {
                    $ord = $this->module->validateOrder(
                        $cart->id,
                        Configuration::get('PS_OS_PAYMENT'),
                        $cart->getOrderTotal(true, Cart::BOTH),
                        $this->module->displayName." Банковская карта",
                        null,
                        array(),
                        null,
                        false,
                        $cart->secure_key
                    );
                }

                if ($ord) {
                    $history = new OrderHistory();
                    $history->id_order = $ord->id;
                    $history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), $ord->id);
                    $history->addWithemail(true);
                }
            }
            if ($this->log_on) {
                $this->module->logSave(
                    'payment_card: #'.$this->module->currentOrder.' '.$this->module->l('Order success')
                );
            }
            Tools::redirect(
                $this->context->link->getPageLink('order-confirmation').'&id_cart='
                .$this->context->cart->id.'&id_module='.$this->module->id.'&id_order='
                .$this->module->currentOrder.'&key='.$this->context->cart->secure_key
            );
        }
    }

    public function initContent()
    {
        parent::initContent();
        $cart = $this->context->cart;
        $this->context->smarty->assign(array(
            'payment_status' => $this->module->payment_status,
            'nbProducts' => $cart->nbProducts(),
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
            'errors' => $this->errors
        ));

        $this->setTemplate('error.tpl');
    }
}
