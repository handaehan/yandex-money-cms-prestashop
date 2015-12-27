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

class Dispatcher extends DispatcherCore
{
    protected function setRequestUri()
    {
        parent::setRequestUri();
        if (Module::isInstalled('yamodule') && strpos($this->request_uri, 'module/yamodule/')) {
            $this->request_uri = iconv('windows-1251', 'UTF-8', $this->request_uri);
        }
    }
}
