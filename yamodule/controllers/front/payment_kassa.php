<?php
use \YandexMoney\ExternalPayment;
use \YandexMoney\API;
class yamodulepayment_kassaModuleFrontController extends ModuleFrontController
{
    public $display_header = true;
    public $display_column_left = true;
    public $display_column_right = false;
    public $display_footer = true;
    public $ssl = true;

    public function postProcess()
    {

        parent::postProcess();
        $dd = serialize($_REQUEST);
		$this->log_on = Configuration::get('YA_ORG_LOGGING_ON');
		if($this->log_on)
			$this->module->log_save('payment_kassa '.$dd);
		$data = explode('_', Tools::getValue('customerNumber'));
		if(!empty($data) && $data[0] == 'KASSA')
		{
			$cart = new Cart($data[1]);
			if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
					Tools::redirect('index.php?controller=order&step=1');

			$customer = new Customer($cart->id_customer);
			if (!Validate::isLoadedObject($customer))
					Tools::redirect('index.php?controller=order&step=1');

			$total_to_pay = $cart->getOrderTotal(true);
			$rub_currency_id = Currency::getIdByIsoCode('RUB');
			if($cart->id_currency != $rub_currency_id){
				$from_currency = new Currency($cart->id_currency);
				$to_currency = new Currency($rub_currency_id);
				$total_to_pay = Tools::convertPriceFull($total_to_pay, $from_currency, $to_currency);
			}
			$total_to_pay = number_format($total_to_pay, 2, '.', '');
			$amount = Tools::getValue('orderSumAmount');
			$action = Tools::getValue('action');
			$shopId = Tools::getValue('shopId');
			$invoiceId = Tools::getValue('invoiceId');
			$signature = md5(
				$action . ';' .
				$amount . ';' .
				Tools::getValue('orderSumCurrencyPaycash') . ';' .
				Tools::getValue('orderSumBankPaycash') . ';' .
				$shopId . ';' .
				$invoiceId . ';' .
				Tools::getValue('customerNumber') . ';' .
				trim(Configuration::get('YA_ORG_MD5_PASSWORD'))
			);
			$ord = ($cart->orderExists())?new Order((int)Order::getOrderByCartId($cart->id)):$this->module->validateOrder($cart->id,_PS_OS_PREPARATION_, $cart->getOrderTotal(true, Cart::BOTH), $this->module->displayName, NULL, array(), NULL, false, $cart->secure_key);

			if (!$ord)
				$this->module->validateResponse($this->module->l('Invalid order number'), 1, $action, $shopId, $invoiceId, true);

			if (Tools::strtoupper($signature) != Tools::strtoupper(Tools::getValue('md5')))
				$this->module->validateResponse($this->module->l('Invalid signature'), 1, $action, $shopId, $invoiceId, true);
			
			if ($amount != $total_to_pay)
				$this->module->validateResponse($this->module->l('Incorrect payment amount'), ($action == 'checkOrder' ? 100 : 200), $action, $shopId, $invoiceId, true);
			
			if ($action == 'checkOrder')
			{
				if($this->log_on)
					$this->module->log_save('payment_kassa: checkOrder invoiceId="'.$invoiceId.'" shopId="'.$shopId.'" '.$this->module->l('check order'));
				$this->module->validateResponse('', 0, $action, $shopId, $invoiceId, true);
			}

			if ($action == 'paymentAviso') 
			{
				$history = new OrderHistory();
				$history->id_order = $ord->id;
				$history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), $ord->id);
				$history->addWithemail(true);

				if($this->log_on)
					$this->module->log_save('payment_kassa: paymentAviso invoiceId="'.$invoiceId.'" shopId="'.$shopId.'" #'.$ord->id.' '.$this->module->l('Order success'));
				$this->module->validateResponse('', 0, $action, $shopId, $invoiceId, true);
			}
		}
		else
			Tools::redirect('index.php?controller=order&step=3');
    }
}
