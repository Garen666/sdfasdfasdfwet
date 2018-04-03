<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package SMSUtils
 */
class SMSUtils_SenderTurbosmsua implements SMSUtils_ISender {

    public function __construct($apiLogin, $apiPassword) {
        if (!class_exists('SoapClient')) {
            throw new SMSUtils_Exception('SOAPClient not found');
        }

        $this->_soapClient = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

        $this->_apiLogin = $apiLogin;
        $this->_apiPassword = $apiPassword;
    }


    /**
     * Отправить SMS-сообщение
     * @param string $sender
     * @param string $destination
     * @param string $text
     * @return mixed
     */

    public function send($sender, $destination, $text) {
        if (!$this->_authStatus) {
            $auth = array (
            'login' => $this->_apiLogin,
            'password' => $this->_apiPassword
            );
            $result = $this->_soapClient->Auth($auth);

            $this->_authStatus = true;
        }

         $sms = array (
         'sender' => $sender,
         'destination' => '+'.$destination,
         'text' => $text
         );

         $result = $this->_soapClient->SendSMS($sms);
         return $result->SendSMSResult;
    }

    private $_soapClient;

    private $_apiLogin;

    private $_apiPassword;

    private $_authStatus = false;

}