<?php

class UtilityHelperTest
{

    const MODE = 'Q';
    const NAME = 'SdkTestFirstName SdkTestLastName';
    const PTOK = '0007380568572514';
    //last four numbers of credit card
    const LAST4 = '2514';
    const VERS = '0700';
    const EMAIL = 'sdkTest@kountsdktestdomain.com';
    const SITE = 'DEFAULT';
    const CURR = 'USD';
    const TOTL = 123456;
    const CASH = 4444;
    const FRMT = 'JSON';
    const UAGT = 'Mozilla/5.0(Macintosh; Intel Mac OSX 10_9_5)AppleWebKit/537.36(KHTML, like Gecko)Chrome/37.0.2062.124Safari/537.36';

    //Billing street address - Line 1
    const B2A1 = '1234 North B2A1 Tree Lane South';
    //Billing street address - Line 2
    const B2A2 = '';
    //Billing address - City
    const B2CI = 'Albuquerque';
    //Billing address - State/Province
    const B2ST = 'NM';
    //Billing address - Counry Code
    const B2CC = 'US';
    //Billing address - Postal Code
    const B2PC = '87101';
    //Billing address - Phone Number
    const B2PN = '555-867-5309';

    //Shipping Address - Name of Recipient
    const S2NM = 'SdkShipToFN SdkShipToLN';
    //Shipping Address - Email address of Recipient
    const S2EM = 'sdkTestShipToEmail@kountsdktestdomain.com';
    //Shipping Address Recipient address - Line 1
    const S2A1 = '567 West S2A1 Court North';
    //Shipping Address Recipient address - Line 2
    const S2A2 = '';
    //Shipping Address Recipient - City
    const S2CI = 'Gnome';
    //Shipping Address Recipient - State/Province
    const S2ST = 'AK';
    //Shipping Address Recipient - Counry Code
    const S2CC = 'US';
    //Shipping Address Recipient - Postal Code
    const S2PC = '99762';
    //Shipping Address Recipient - Phone Number
    const S2PN = '555-777-1212';

    const PTYP = 'CARD';
    const IPAD = '131.206.45.21';
    const MACK = 'Y';
    const AUTH = 'A';
    const AVSZ = 'M';
    const AVST = 'M';
    const CVVR = 'M';

    //Cart Items
    const PROD_TYPE_0 = 'SPORTING_GOODS';
    const PROD_ITEM_0 = 'SG999999';
    const PROD_DESC_0 = '3000 CANDLEPOWER PLASMA FLASHLIGHT';
    const PROD_QUANT_0 = 2;
    const PROD_PRICE_0 = 68990;

    //Non-constant variables :
    private $sessionId = '';
    private $uniq = '';
    private $orderNum = '';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->setUp();
    }

    protected function setUp()
    {
        $sessionId = $this->sessionId = substr(md5(rand()), 0, 32);
        $uniq = $this->uniq = mb_strimwidth($this->sessionId, 0, 20);
        $orderNum = $this->orderNum = mb_strimwidth($uniq, 0, 10);
    }

    public function getArraySettings()
    {
        $configReader = Kount_Util_ConfigFileReader::instance();

        $configKey = $configReader->getConfigSetting('CONFIG_KEY') != '$CONFIG_KEY' ?
            $configReader->getConfigSetting('CONFIG_KEY') : base64_decode(getenv("RIS_CONFIG_KEY_BASE64"));
        $configKey = str_replace(PHP_EOL, '', $configKey);

        $apiKey = $configReader->getConfigSetting('API_KEY') != '$API_KEY' ?
            $configReader->getConfigSetting('API_KEY') : getenv("RIS_SDK_SANDBOX_API_KEY");

        $merchantId = $configReader->getConfigSetting('MERCHANT_ID') != '$MERCHANT_ID' ?
            $configReader->getConfigSetting('MERCHANT_ID') : getenv("RIS_SDK_SANDBOX_MERCHANT_ID");

        $clientId = $configReader->getConfigSetting('PF_CLIENT_ID') != 'PF_CLIENT_ID' ?
            $configReader->getConfigSetting('PF_CLIENT_ID') : getenv("PF_CLIENT_ID");

        $isMigrationModeEnabled = empty($configReader->getConfigSetting('MIGRATION_MODE_ENABLED')) ?
            getenv("MIGRATION_MODE_ENABLED") : strtolower(trim($configReader->getConfigSetting('MIGRATION_MODE_ENABLED'))) == 'true';

        $pfAuthEndpoint = $configReader->getConfigSetting('PF_AUTH_ENDPOINT') != '$PF_AUTH_ENDPOINT' ?
            $configReader->getConfigSetting('PF_AUTH_ENDPOINT') : getenv("PF_AUTH_ENDPOINT");

        $pfApiEndpoint = $configReader->getConfigSetting('PF_API_ENDPOINT') != '$PF_API_ENDPOINT' ?
            $configReader->getConfigSetting('PF_API_ENDPOINT') : getenv("PF_API_ENDPOINT");

        $pfApiKey = $configReader->getConfigSetting('PF_API_KEY') != 'PF_API_KEY' ?
            $configReader->getConfigSetting('PF_API_KEY') : getenv("PF_API_KEY");

        $settings = new Kount_Ris_ArraySettings([
            'CONFIG_KEY' => $configKey,
            'MERCHANT_ID' => $merchantId,
            'URL' => 'https://risk.test.kount.net',
            'API_KEY' => $apiKey,
            'VERS' => '0720',
            'CONNECT_TIMEOUT' => '30',
            'SDK' => 'PHP',
            'SDK_VERSION' => "Sdk-Ris-PHP-0.0.0",
            'PEM_CERTIFICATE' => '/path/to/certificate.pem',
            'PEM_KEY_FILE' => '/path/to/keyfile.pem',
            'PEM_PASS_PHRASE' => 'passphrase',
            'MIGRATION_MODE_ENABLED' => $isMigrationModeEnabled,
            'PF_CLIENT_ID' => $clientId,
            'PF_AUTH_URL' => $pfAuthEndpoint,
            'PF_API_URL' => $pfApiEndpoint,
            'PF_API_KEY' => $pfApiKey,
        ]);

        return $settings;
    }

    public function createInquiry()
    {
        $settings = $this->getArraySettings();
        $inquiry = new Kount_Ris_Request_Inquiry($settings);

        $inquiry->setName(self::NAME);
        $inquiry->setMode(self::MODE);
        $inquiry->setEmail(self::EMAIL);
        $inquiry->setBillingAddress(self::B2A1, self::B2A2, self::B2CI, self::B2ST, self::B2PC, self::B2CC);
        $inquiry->setBillingPhoneNumber(self::B2PN);
        $inquiry->setSessionId($this->sessionId);
        $inquiry->setUnique($this->uniq);
        $inquiry->setOrderNumber($this->orderNum);

        $inquiry->setShippingName(self::S2NM);
        $inquiry->setShippingEmail(self::S2EM);
        $inquiry->setShippingPhoneNumber(self::S2PN);
        $inquiry->setShippingAddress(self::S2A1, self::S2A2, self::S2CI, self::S2ST, self::S2PC, self::S2CC);

        $inquiry->setTotal(self::TOTL);
        $inquiry->setCash(self::CASH);
        $inquiry->setIpAddress(self::IPAD);

        $inquiry->setMack(self::MACK);
        $inquiry->setAuth(self::AUTH);
        $inquiry->setAvst(self::AVST);
        $inquiry->setAvsz(self::AVSZ);
        $inquiry->setCvvr(self::CVVR);

        $inquiry->setWebsite(self::SITE);
        $inquiry->setCurrency(self::CURR);
        $inquiry->setPayment(self::PTYP, self::PTOK);

        //Create a cartItem
        $cart = new Kount_Ris_Data_CartItem(
            self::PROD_TYPE_0,
            self::PROD_ITEM_0,
            self::PROD_DESC_0,
            self::PROD_QUANT_0,
            self::PROD_PRICE_0
        );

        $inquiry->setCart(array($cart));

        return $inquiry;
    }
}
