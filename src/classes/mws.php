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

class Mws
{
    public $CertPem;
    public $PkeyPem;
    public $shopId;
    public $demo = false;
    public $txt_request;
    public $txt_respond;
    public $sum = 0;

    public function addReturn($data)
    {
        Db::getInstance()->query("INSERT INTO `"._DB_PREFIX_."mws_return` (`".implode("`,`", array_keys($data))."`)
            VALUES ('".implode("','", array_values($data))."')");
    }

    public function getSuccessReturns($inv)
    {
        $order_query = Db::getInstance()->ExecuteS(
            "SELECT *
            FROM `"._DB_PREFIX_."mws_return` o
            WHERE o.invoice_id = '".$inv."'
            ORDER BY `date` DESC"
        );

        $sum = 0;
        if (count($order_query)) {
            $returns = array_filter(
                $order_query,
                function ($row) {
                    return ($row['status'] == '0');
                }
            );

            if ($returns) {
                foreach ($returns as $item) {
                    $sum += $item['amount'];
                }
            }

            $this->sum = $sum;
            return $returns;
        }

        return false;
    }

    public static function upload()
    {
        $json = array();
        if (!empty($_FILES['file']['name'])) {
            if (Tools::substr($_FILES['file']['name'], -4) != '.cer') {
                $json['error'] = 'Разрешены только cer';
            }
            if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
                $json['error'] = $_FILES['file']['error'];
            }
            if (filesize($_FILES['file']['tmp_name'])>2048) {
                $json['error'] = 'Файл не должен превышать 2048 байт';
            }
        } else {
            $json['error'] = 'Ошибка загрузки файла!';
        }
        if (!isset($json['error'])) {
            $cert = Tools::file_get_contents($_FILES['file']['tmp_name']);
            Configuration::updateValue('yamodule_mws_cert', $cert);
        }

        die(Tools::jsonEncode($json));
    }

    public function request($oper, $param, $sign = true, $is_xml = true, $fields = array())
    {
        $level = true;
        $prepare = $this->getDefaultArray($oper, $fields, $level);
        $data = array_merge($prepare, $param);
        $xml = $this->sendRequest($oper, $data, $sign, $is_xml);
        $this->txt_respond = $xml;
        $info = $this->parseXML($xml, $fields, $level);
        return (array) $info;
    }

    public static function outputCsr()
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=csr_for_yamoney.csr');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        die(Configuration::get('yamodule_mws_csr'));
    }

    public static function generateCsr()
    {
        $pkey="";
        $csr="";
        $sign = self::genCsrPKey(
            array(
                "countryName" => "RU",
                "stateOrProvinceName" => "Russia",
                "localityName" => "Moscow",
                "commonName" => "/business/ps/yacms-".Configuration::get('YA_ORG_SHOPID'),
            ),
            $pkey,
            $csr
        );

        Configuration::updateValue('yamodule_mws_pkey', $pkey);
        Configuration::updateValue('yamodule_mws_csr', $csr);
        Configuration::updateValue('yamodule_mws_csr_sign', $sign);
        Configuration::updateValue('yamodule_mws_cert', '');
    }

    public static function genCsrPKey($dn, &$privKey, &$csr_export)
    {
        $config = array(
             "digest_alg" => "sha1",
             "private_key_bits" => 2048,
             "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $dn_full = array_merge(array(
             "countryName" => "RU",
             "stateOrProvinceName" => "Russia",
             "localityName" => ".",
             "organizationalUnitName" => "."
        ), $dn);
        $res = openssl_pkey_new($config);
        $csr_origin = openssl_csr_new($dn_full, $res);
        $csr_full = "";
        openssl_pkey_export($res, $privKey);
        openssl_csr_export($csr_origin, $csr_export);
        
        openssl_csr_export($csr_origin, $csr_full, false);
        preg_match('"Signature Algorithm\: (.*)-----BEGIN"ims', $csr_full, $sign);
        $sign = str_replace("\t", "", $sign);
        if ($sign) {
            $sign = $sign[1];
            $a = explode("\n", $sign);
            unset($a[0]);
            $sign = str_replace("         ", "", trim(join("\n", $a)));
        }
        return $sign;
    }

    private function getDefaultArray($command, &$fields, &$level)
    {
        $defArray=array();
        $defArray['shopId'] = $this->shopId;
        $defArray['requestDT'] = date('c');
        
        switch ($command) {
            case 'listOrders':
            case 'listReturns':
                $fields = array('orderNumber','invoiceId','orderSumAmount', 'paymentType');
                $defArray['outputFields'] = implode(';', $fields);
                $level = true;
                break;
            case 'returnPayment':
                $defArray['currency'] = $this->getCurrencyCode();
                $defArray['clientOrderId'] = $this->getClientOrderId();
                $fields = array('status','error','techMessage','clientOrderId');
                $level = false;
                break;
        }
        return $defArray;
    }

    private function getClientOrderId()
    {
        return '010'.microtime(true);
    }
    
    private function getCurrencyCode()
    {
        return ($this->demo) ? '10643' : '643';
    }
    
    private function getUrlMws($command)
    {
        $demo = ($this->demo)?'-demo':'';
        $port = ($this->demo)?':8083':'';
        $url_server="https://penelope$demo.yamoney.ru$port/webservice/mws/api/".$command;
        return $url_server;
    }
    
    private function sendRequest($url, $data, $crypt = true, $xml = true)
    {
        $data = ($xml)?$this->createXml($data, $url):$data;
        $this->txt_request = $data;
        $send_data = ($crypt)? $this->signPkcs7($data):http_build_query($data);
        return $this->post($url, $send_data);
    }

    private function post($url, $xml)
    {
        $ch = curl_init($this->getUrlMws($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLCERT, $this->rwTmpFile($this->CertPem));
        curl_setopt($ch, CURLOPT_SSLKEY, $this->rwTmpFile($this->PkeyPem));
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
    
    private function parseXML($xml, $attr = array(), $level = true)
    {
        $answer=array();
        $doc = new DOMDocument();
        @$doc->loadXML($xml);
        if (empty($doc->firstChild)) {
            return false;
        }
        $order_xml=($level)?$doc->firstChild->firstChild:$doc->firstChild;
        foreach ($attr as $name) {
            if (method_exists($order_xml, 'hasAttribute') && $order_xml->hasAttribute($name)) {
                $answer[$name]=$order_xml->getAttributeNode($name)->value;
            } else {
                $answer[$name]='';
            }
        }
        return $answer;
    }
    
    private function createXml($array, $operation)
    {
        $domDocument = new DOMDocument('1.0', 'UTF-8');
        $domElement = $domDocument->createElement($operation."Request");
        foreach ($array as $name => $val) {
            $domAttribute = $domDocument->createAttribute($name);
            $domAttribute->value = $val;
            $domElement->appendChild($domAttribute);
            $domDocument->appendChild($domElement);
        }
        return (string) $domDocument->saveXML();
    }
    
    private function signPkcs7($xml)
    {
        $dataFile = $this->rwTmpFile($xml);
        $signedFile = $this->rwTmpFile();
        if (openssl_pkcs7_sign(
            $dataFile,
            $signedFile,
            $this->CertPem,
            $this->PkeyPem,
            array(),
            PKCS7_NOCHAIN+PKCS7_NOCERTS
        )) {
            $signedData = explode("\n\n", Tools::file_get_contents($signedFile));
            return "-----BEGIN PKCS7-----\n".$signedData[1]."\n-----END PKCS7-----";
        }
    }
    private function rwTmpFile($data = null)
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'YaMWS');
        if ($data!==null) {
            file_put_contents($temp_file, $data);
        }
        return $temp_file;
    }
}
