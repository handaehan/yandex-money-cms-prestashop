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

class Hforms
{
    public $cats;
    public function l($s)
    {
        $mod = Module::getInstanceByName('yamodule');
        return $mod->l($s, 'hforms');
    }

    public function getFormYaPokupki()
    {
        $yamodule = new Yamodule();
        $dir = _PS_ADMIN_DIR_;
        $dir = explode('/', $dir);
        $dir = $yamodule->cryptor->encrypt(end($dir).'_'.Context::getContext()->cookie->id_employee.'_pokupki');
        $carriers = Carrier::getCarriers(Context::getContext()->language->id, true, false, false, null, 5);
        $type = array(
            array(
                'name' => 'POST',
                'id' => 'POST'
            ),
            array(
                'name' => 'PICKUP',
                'id' => 'PICKUP'
            ),
            array(
                'name' => 'DELIVERY',
                'id' => 'DELIVERY'
            )
        );
        $out = array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Module configuration Orders on the market'),
                'icon' => 'icon-cogs',
                ),
            'input' => array(
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('A token for access to API Yandex.Market'),
                        'name' => 'YA_POKUPKI_TOKEN',
                        'label' => $this->l('An authorization token Yandex.Market'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'disabled' => 1,
                        'type' => 'text',
                        'name' => 'YA_POKUPKI_FD',
                        'label' => $this->l('Формат данных'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'disabled' => 1,
                        'type' => 'text',
                        'name' => 'YA_POKUPKI_TA',
                        'label' => $this->l('Тип авторизации'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Prepayment'),
                        'name' => 'YA_POKUPKI_PREDOPLATA',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'YANDEX',
                                    'name' => $this->l('Payment at registration (only in Russia)'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'SHOP_PREPAID',
                                    'name' => $this->l('Directly to the shop (only for Ukraine)'),
                                    'val' => 1
                                ),

                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Post-paid'),
                        'name' => 'YA_POKUPKI_POSTOPLATA',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'CASH_ON_DELIVERY',
                                    'name' => $this->l('Cash upon receipt of goods'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'CARD_ON_DELIVERY',
                                    'name' => $this->l('Payment via credit card upon receipt of order'),
                                    'val' => 1
                                ),

                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Settings'),
                        'name' => 'YA_POKUPKI_SET',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'CHANGEC',
                                    'name' => $this->l('To enable the change of delivery'),
                                    'val' => 1
                                ),

                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Ссылка на https://api.partner.market.yandex.ru/v2/'),
                        'name' => 'YA_POKUPKI_APIURL',
                        'label' => $this->l('URL affiliate API Yandex.Market'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The Campaign Number'),
                        'name' => 'YA_POKUPKI_NC',
                        'label' => $this->l('The Campaign Number'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The user login in the system Yandex.Market'),
                        'name' => 'YA_POKUPKI_LOGIN',
                        'label' => $this->l('The user login in the system Yandex.Market'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Application ID'),
                        'name' => 'YA_POKUPKI_ID',
                        'label' => $this->l('Application ID'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Password prilozheniye'),
                        'name' => 'YA_POKUPKI_PW',
                        'label' => $this->l('An application-specific password'),
                    ),array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => '<a href="https://oauth.yandex.ru/authorize?response_type=code&display=popup&state='
                            .$dir.'&client_id='.Configuration::get('YA_POKUPKI_ID')."&device_id="
                            .md5(Configuration::get('YA_POKUPKI_ID')).'">'
                            .$this->l('To obtain a token for access to Yandex.Buy').'</a>',
                        'name' => 'YA_POKUPKI_YATOKEN',
                        'label' => $this->l('An authorization token'),
                        'disabled' => true
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Item number ex'),
                        'name' => 'YA_POKUPKI_PUNKT',
                        'label' => $this->l('The ID of the item ex'),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'name' => 'YA_MARKET_REDIRECT',
                        'desc' => $this->l('Callback Url for OAuth applications'),
                        'label' => $this->l('The link for the application'),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('URL API to fill in the store settings on Yandex.Market'),
                        'name' => 'YA_POKUPKI_APISHOP',
                        'label' => $this->l('The link to access Your store'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );

        foreach ($carriers as $a) {
            $out['form']['input'][] = array(
                        'type' => 'select',
                        'label' => $this->l('The delivery type').' '.$a['name'],
                        'name' => 'YA_POKUPKI_DELIVERY_'.$a['id_carrier'],
                        'desc' =>$this->l('POST - Mail DELIVERY - Express delivery, PICKUP Pickup'),
                        'options' => array(
                            'query' => $type,
                            'name' => 'name',
                            'id' => 'id'
                        ),
                        'class' => 't'
                    );
        }

        return $out;
    }

    public function getFormYamoneyMarket()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('The module settings Yandex.Market'),
                'icon' => 'icon-cogs',
                ),
            'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Simplified yml:'),
                        'name' => 'YA_MARKET_SHORT',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Included')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Off')
                            )
                        ),
                    ),
                    array(
                        'type' => 'categories',
                        'label' => $this->l('Categories'),
                        'desc' => $this->l('Select the categories to export. If you need a subcategory, select them.'),
                        'name' => 'YA_MARKET_CATEGORIES',
                        'tree' => array(
                            'use_search' => false,
                            'id' => 'categoryBox',
                            'use_checkbox' => true,
                            'selected_categories' => $this->cats,
                        ),
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('To unload:'),
                        'name' => 'YA_MARKET_CATALL',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('All categories')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Only selected')
                            )
                        ),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The name of your company for Yandex.Market'),
                        'name' => 'YA_MARKET_NAME',
                        'label' => $this->l('The name of the store'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The shipping cost to your home location'),
                        'name' => 'YA_MARKET_DELIVERY',
                        'label' => $this->l('The shipping cost to your home location'),
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Type paged descriptions'),
                        'name' => 'YA_MARKET_DESC_TYPE',
                        'class' => 't',
                        'values' => array(
                            array(
                                'id' => 'NORMAL',
                                'value' => 0,
                                'label' => $this->l('Full')
                            ),
                            array(
                                'id' => 'SHORT',
                                'value' => 1,
                                'label' => $this->l('Short')
                            )
                        ),
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Availability'),
                        'desc' => $this->l('Availability'),
                        'name' => 'YA_MARKET_DOSTUPNOST',
                        'is_bool' => false,
                        'values' => array(
                            array(
                                'id' => 'd_0',
                                'value' => 0,
                                'label' => $this->l('All available')
                            ),
                            array(
                                'id' => 'd_1',
                                'value' => 1,
                                'label' => $this->l('If available > 0, the rest to order')
                            ),
                            array(
                                'id' => 'd_2',
                                'value' => 2,
                                'label' => $this->l('If = 0, do not unload')
                            ),
                            array(
                                'id' => 'd_3',
                                'value' => 3,
                                'label' => $this->l('All made to order')
                            )
                        )
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Settings'),
                        'name' => 'YA_MARKET_SET',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'AVAILABLE',
                                    'name' => $this->l('To export only the goods which are in stock'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'NACTIVECAT',
                                    'name' => $this->l('To exclude inactive categories'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'HOMECARRIER',
                                    'name' => $this->l('To use the delivery at your home location'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'COMBINATIONS',
                                    'name' => $this->l('Export of product combinations'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'DIMENSIONS',
                                    'val' => 1,
                                    'name' => $this->l('Display dimensions of product (dimensions)')
                                ),
                                array(
                                    'id' => 'ALLCURRENCY',
                                    'val' => 1,
                                    'name' => $this->l('Unload all currencies? (If not, will be uploaded only by default)')
                                ),
                                array(
                                    'id' => 'GZIP',
                                    'val' => 1,
                                    'name' => $this->l('Gzip compression')
                                ),
                                array(
                                    'id' => 'ROZNICA',
                                    'val' => 1,
                                    'name' => $this->l('the opportunity to buy in a retail store.')
                                ),
                                array(
                                    'id' => 'DOST',
                                    'val' => 1,
                                    'name' => $this->l(' the possibility of delivery of the product.')
                                ),
                                array(
                                    'id' => 'SAMOVIVOZ',
                                    'val' => 1,
                                    'name' => $this->l('the ability to reserve and pick up yourself.')
                                ),

                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Link to the dynamic file price list'),
                        'name' => 'YA_MARKET_YML',
                        'label' => $this->l('The yml file'),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'name' => 'YA_MARKET_REDIRECT',
                        'label' => $this->l('The redirect link for the application.'),
                    ),
                ),
            'submit' => array(
                    'title' => $this->l('Save'),
                ),
                'buttons' => array(
                'generatemanual' => array(
                    'title' => $this->l('To generate manually'),
                    'name' => 'generatemanual',
                    'type' => 'submit',
                    'class' => 'btn btn-default pull-right',
                    'icon' => 'process-icon-refresh'
                )
            )
            ),
        );
    }

    public function getFormYamoneyMetrika()
    {
        $yamodule = new Yamodule();
        $dir = _PS_ADMIN_DIR_;
        $dir = explode('/', $dir);
        $dir = $yamodule->cryptor->encrypt(end($dir).'_'.Context::getContext()->cookie->id_employee.'_metrika');
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('The module settings Yandex.The metric'),
                'icon' => 'icon-cogs',
                ),
            'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Activity:'),
                        'name' => 'YA_METRIKA_ACTIVE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The number of Your counter'),
                        'name' => 'YA_METRIKA_NUMBER',
                        'label' => $this->l('The number of the counter'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('ID of the OAuth application'),
                        'name' => 'YA_METRIKA_ID_APPLICATION',
                        'label' => $this->l('Application ID'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The password of the OAuth application'),
                        'name' => 'YA_METRIKA_PASSWORD_APPLICATION',
                        'label' => $this->l('An application-specific password'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => '<a href="https://oauth.yandex.ru/authorize?response_type=code&display=popup&state='.
                            $dir.'&client_id='.Configuration::get('YA_METRIKA_ID_APPLICATION').'">'
                            .$this->l('To request a token for accessing the Yandex.The metric').'</a>',
                        'name' => 'YA_METRIKA_TOKEN',
                        'label' => $this->l('The OAuth Token'),
                        'disabled' => true
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Settings'),
                        'name' => 'YA_METRIKA_SET',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'WEBVIZOR',
                                    'name' => $this->l('Vebvizor'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'CLICKMAP',
                                    'name' => $this->l('Map clicks'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'OUTLINK',
                                    'name' => $this->l('External links, file downloads and report the "Share"button'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'OTKAZI',
                                    'name' => $this->l('Accurate bounce rate'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'HASH',
                                    'name' => $this->l('Hash tracking in the browser address bar'),
                                    'val' => 1
                                ),

                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('To collect statistics on the following circuits:'),
                        'name' => 'YA_METRIKA_CELI',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'CART',
                                    'name' => $this->l('Basket(Visitor has clicked "add to cart")'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'ORDER',
                                    'name' => $this->l('Ordering(Visitor checkout)'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'WISHLIST',
                                    'name' => $this->l('Wishlist(Visitor added an item to wishlist)'),
                                    'val' => 1
                                )
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'name' => 'YA_METRIKA_REDIRECT',
                        'desc' => $this->l('Callback Url for OAuth applications'),
                        'label' => $this->l('The link for the application'),
                    ),
                ),
            'submit' => array(
                    'title' => $this->l('Save'),
            ),
            ),
        );
    }

    public function getFormYamoneyOrg()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('The module settings Yandex.Cash'),
                'icon' => 'icon-cogs',
                ),
            'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Activity:'),
                        'name' => 'YA_ORG_ACTIVE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Hours of operation:'),
                        'name' => 'YA_ORG_TYPE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Work')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Test')
                            )
                        ),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The ID of the shop (shopId)'),
                        'name' => 'YA_ORG_SHOPID',
                        'label' => $this->l('The ID of the shop (shopId)'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The room showcases (scid)'),
                        'name' => 'YA_ORG_SCID',
                        'label' => $this->l('The room showcases (scid)'),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Password store (shopPassword)'),
                        'name' => 'YA_ORG_MD5_PASSWORD',
                        'label' => $this->l('Password store (shopPassword)'),
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Режим оплаты:'),
                        'name' => 'YA_ORG_INSIDE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Выбор способов оплаты на стороне магазина')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Выбор способов оплаты на стороне сервиса Яндекс.Касса')
                            )
                        ),
                    ),
                    array(
                        'col' => 9,
                        'class' => 't text_inside',
                        'type' => 'free',
                        'name' => 'YA_ORG_TEXT_INSIDE',
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Methods of payment'),
                        'name' => 'YA_ORG_PAYMENT',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'YANDEX',
                                    'name' => $this->l('Payment from the purse in Yandex.Money.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'CARD',
                                    'name' => $this->l('Arbitrary payment with Bank card.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'TERMINAL',
                                    'name' => $this->l('Payment in cash through cash desks and terminals.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'MOBILE',
                                    'name' => $this->l('Payment with mobile phone account.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'WEBMONEY',
                                    'name' => $this->l('Payment of the purse in system WebMoney.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'SBER',
                                    'name' => $this->l('Payment via Sberbank: payment by SMS or Sberbank Online.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'ALFA',
                                    'name' => $this->l('Payment via Alfa-Click.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'PB',
                                    'name' => $this->l('Payments via Promsvyazbank.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'MA',
                                    'name' => $this->l('Payment via MasterPass.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'QW',
                                    'name' => $this->l('Payment via QIWI Wallet.'),
                                    'val' => 1
                                ),
                                array(
                                    'id' => 'QP',
                                    'name' => $this->l('Payment through a trusted payment (Kuppi.ru).'),
                                    'val' => 1
                                ),
                                
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Minimum order amount'),
                        'name' => 'YA_ORG_MIN',
                        'label' => $this->l('Minimum order amount'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Keep a log of logs'),
                        'name' => 'YA_ORG_LOGGING',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'ON',
                                    'name' => ''
                                ),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('CheckOrder'),
                        'name' => 'YA_ORG_CHECKORDER',
                        'label' => $this->l('CheckOrder'),
                        'disabled' => true
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('PaymentAviso'),
                        'name' => 'YA_ORG_AVISO',
                        'label' => $this->l('PaymentAviso'),
                        'disabled' => true
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Fail'),
                        'name' => 'YA_ORG_FAIL',
                        'label' => $this->l('Fail'),
                        'disabled' => true
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Success'),
                        'name' => 'YA_ORG_SUCCESS',
                        'label' => $this->l('Success'),
                        'disabled' => true
                    ),
                ),
            'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    public function getFormYamoney()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('The module settings Yandex.Money'),
                'icon' => 'icon-cogs',
                ),
            'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Activity:'),
                        'name' => 'YA_P2P_ACTIVE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('The number of purse'),
                        'name' => 'YA_P2P_NUMBER',
                        'label' => $this->l('The number of Your purse in system Yandex.Money'),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Application Id'),
                        'name' => 'YA_P2P_IDENTIFICATOR',
                        'label' => $this->l('Application Id'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Secret key:'),
                        'name' => 'YA_P2P_KEY',
                        'rows' => 5,
                        'cols' => 30,
                        'desc' => $this->l('The secret key is received after you create your application.'),
                        'class' => 't'
                    ),
                    array(
                        'col' => 4,
                        'class' => 't',
                        'type' => 'text',
                        'desc' => $this->l('Minimum order amount'),
                        'name' => 'YA_P2P_MIN',
                        'label' => $this->l('Minimum order amount'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Keep a log of logs'),
                        'name' => 'YA_P2P_LOGGING',
                        'values' => array(
                            'query' => array(
                                array(
                                    'id' => 'ON',
                                    'name' => '',
                                    'val' => 1
                                ),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'col' => 6,
                        'class' => 't',
                        'type' => 'text',
                        'name' => 'YA_P2P_REDIRECT',
                        'label' => $this->l('Link to receive notifications'),
                    ),
                ),
            'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }
}
