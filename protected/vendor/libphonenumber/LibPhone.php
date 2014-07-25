<?php
 
namespace libphonenumber;
 
require_once 'PhoneNumberUtil.php';
require_once 'CountryCodeToRegionCodeMap.php';
require_once 'PhoneNumber.php';
require_once 'PhoneMetadata.php';
require_once 'PhoneNumberDesc.php';
require_once 'NumberFormat.php';
require_once 'Matcher.php';
require_once 'CountryCodeSource.php';
require_once 'PhoneNumberType.php';
require_once 'PhoneNumberFormat.php';
 
class LibPhone
{
        protected $_phoneNumber;
        protected $_regionCode;
        protected $_phoneUtil;
        protected $_numberProto;
 
        /**
         *
         * @param string $phoneNumber
         * @param string $regionCode
         */
        public function __construct($phoneNumber = '', $regionCode = 'US')
        {
                $this->_phoneUtil = PhoneNumberUtil::getInstance();
                $this->setRegionCode($regionCode);
               
                if (!empty($phoneNumber)) {
                        $this->setPhoneNumber($phoneNumber);
                } else {
                        $this->_numberProto = null;
                }
        }
 
        /**
         * Checks is region supported by lib
         *
         * @param string $regionCode
         * @return boolean
         */
        protected function _isRegionSupported($regionCode)
        {
                return in_array($regionCode, $this->_phoneUtil->getSupportedRegions());
        }
       
        /**
         * Region code setter
         *
         * @param string $regionCode
         */
        public function setRegionCode($regionCode)
        {
                if ($this->_isRegionSupported($regionCode)) {
                        $this->_regionCode = $regionCode;
                } else {
                        throw new \Exception('Region code "'. $regionCode . '" is not supported!');
                }
               
                return $this;
        }
       
        /**
         * Phone number setter, also parses number for further usage
         *
         * @param string $phoneNumber
         */
        public function setPhoneNumber($phoneNumber)
        {
                $this->_phoneNumber = $phoneNumber;
                $this->_numberProto =
                                $this->_phoneUtil->parseAndKeepRawInput($this->_phoneNumber, $this->_regionCode);
               
                return $this;
        }
       
        /**
         * Checking the number is valid or not  
         *
         * @return boolean
         */
        public function validate()
        {
                return $this->_phoneUtil->isValidNumber($this->_numberProto);
        }
       
        /**
         * Return international format
         *
         * @return string
         */
        public function toInternational()
        {
                return $this->_phoneUtil->format($this->_numberProto, PhoneNumberFormat::INTERNATIONAL);
        }
 
        /**
         * Return national format
         *
         * @return string
         */
        public function toNational()
        {
                return $this->_phoneUtil->format($this->_numberProto, PhoneNumberFormat::NATIONAL);
        }
 
        /**
         * Return E164 (http://en.wikipedia.org/wiki/E.164) format
         *
         * @return string
         */
        public function toE164()
        {
                return $this->_phoneUtil->format($this->_numberProto, PhoneNumberFormat::E164);
        }
 
        /**
         * Out of country calling number
         *
         * @param string $region
         * @return string
         */
        public function toOutOfCountryCallingNumber($region)
        {
                return $this->_phoneUtil->formatOutOfCountryCallingNumber($this->_numberProto, $region);
        }
 
}



