<?php

/**
 * Inquiry.php file containing Kount_Ris_Request_Inquiry class.
 */

/**
 * Perform an initial inquiry request (MODE 'Q' or 'P') to RIS.
 * Contains specific methods for setting various inquiry properties.
 *
 * @package Kount_Ris
 * @subpackage Request
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_Request_Inquiry extends Kount_Ris_Request
{

    /**
     * Normal inquiry
     * @var string
     */
    const MODE_Q = 'Q';

    /**
     * Phone order inquiry
     * @var string
     */
    const MODE_P = 'P';

    /**
     * Kount Central normal inquiry with thresholds
     * @var string
     */
    const MODE_W = 'W';

    /**
     * Kount Central threshold-only inquiry
     * @var string
     */
    const MODE_J = 'J';


    /**
     * Gender male.
     * @var string
     * @see setGender()
     */
    const MALE = 'M';

    /**
     * Gender female.
     * @var string
     * @see setGender()
     */
    const FEMALE = 'F';


    /**
     * Same day shipping.
     * @var string
     * @see setShipType()
     */
    const SHIP_SAME = 'SD';

    /**
     * Next day shipping.
     * @var string
     * @see setShipType()
     */
    const SHIP_NEXT = 'ND';

    /**
     * Second day shipping.
     * @var string
     * @see setShipType()
     */
    const SHIP_2ND = '2D';

    /**
     * Standard shipping
     * @var string
     * @see setShipType()
     */
    const SHIP_STD = 'ST';

    /**
     * Delivery shipping.
     * @var string
     * @see setShipType()
     */
    const SHIP_DELIVERY = 'DE';

    /**
     * Pick-up shipping
     * @var string
     * @see setShipType()
     */
    const SHIP_PICKUP = 'PU';

    /**
     * Default currency type
     * @var string
     */
    const DEFAULT_CURRENCY = 'USD';

    /**
     * Inquiry constructor. Sets the RIS mode to "Inquiry" ("Q"), sets currency to "USD",
     * sets the PHP SDK identifier.
     *
     * @param Kount_Ris_Settings|string $settings Configuration settings
     */
    public function __construct($settings = null)
    {
        parent::__construct($settings);
        // defaults
        $this->setMode(self::MODE_Q);
        $this->setCurrency(self::DEFAULT_CURRENCY);
        $this->setParm('SDK', $this->settings->getSdk());
        $this->setParm('SDK_VERSION', $this->settings->getSdkVersion());
    }

    /**
     * Retrieve the array of data parameters sent to RIS.
     *
     * @return array of params
     */
    public function getParams()
    {
        return $this->data;
    }

    /**
     * Set the date of birth in the format YYYY-MM-DD.
     *
     * @param string $dob Date of birth
     * @return Kount_Ris_Request_Inquiry
     */
    public function setDateOfBirth($dob)
    {
        $this->data['DOB'] = $dob;
        return $this;
    }


    /**
     * Set the customer's gender. Either M(male) or F(female).
     *
     * @param string $gender Gender ("M" or "F")
     * @return Kount_Ris_Request_Inquiry
     */
    public function setGender($gender)
    {
        $this->data['GENDER'] = $gender;
        return $this;
    }

    /**
     * Set the value of a named user defined field.
     *
     * @param string $label The user defined field label
     * @param string $value The user defined field value
     * @return Kount_Ris_Request_Inquiry
     */
    public function setUserDefinedField($label, $value)
    {
        $index = "UDF[{$label}]";
        $this->data[$index] = $value;
        return $this;
    }

    /**
     * Set the inquiry mode
     * Acceptable values are: "Q", "P", "W", "J"
     *
     * @param string $mode RIS inquiry mode (Q/P)
     * @return Kount_Ris_Request_Inquiry
     * @throws Kount_Ris_IllegalArgumentException when $mode doesn't mach any of the defined inquiry modes.
     */
    public function setMode($mode)
    {
        $this->data['MODE'] = $mode;
        return $this;
    }

    /**
     * Set the three character ISO-4217 currency code.
     *
     * @param string $currency Three character currency code. For
     *    example USD: US Dollar, EUR: Euro.
     * @return Kount_Ris_Request_Inquiry
     */
    public function setCurrency($currency)
    {
        $this->data['CURR'] = $currency;
        return $this;
    }

    /**
     * Set the total amount in lowest possible denomination of currency.
     *
     * @param int $total Transaction amount in pennies of currency.
     * @return Kount_Ris_Request_Inquiry
     */
    public function setTotal($total)
    {
        $this->data['TOTL'] = $total;
        return $this;
    }

    /**
     * Set the IP address of the client.
     *
     * @param string $ipAddress IP Address of the client
     * @return Kount_Ris_Request_Inquiry
     */
    public function setIpAddress($ipAddress)
    {
        $this->data['IPAD'] = $ipAddress;
        return $this;
    }

    /**
     * Set the email address of the client.
     *
     * @param string $email Email address of the client
     * @return Kount_Ris_Request_Inquiry
     */
    public function setEmail($email)
    {
        $this->data['EMAL'] = $email;
        return $this;
    }

    /**
     * Set the ANI (Automatic Identification Number) received for the phone
     * transaction.
     *
     * @param string $anid ANI of the client
     * @return Kount_Ris_Request_Inquiry
     */
    public function setAnid($anid)
    {
        $this->data['ANID'] = $anid;
        return $this;
    }

    /**
     * Set the name of the client.
     *
     * @param string $name Name of the client or company
     * @return Kount_Ris_Request_Inquiry
     */
    public function setName($name)
    {
        $this->data['NAME'] = $name;
        return $this;
    }

    /**
     * Set the customer unique id or cookie
     *
     * @param string $unique Customer-unique ID or cookie set by merchant.
     * @return Kount_Ris_Request_Inquiry
     * @deprecated version 4.0.0 - 2009. Use Kount_Ris_Inquiry->setUnique()
     *   instead.
     */
    public function setUniqe($unique)
    {
        $this->logger->info('The method Kount_Ris_Inquiry->setUniqe() is " +
        "deprecated. Use Kount_Ris_Inquiry->setUnique() instead.');
        return $this->setUnique($unique);
    }

    /**
     * Set the customer unique id or cookie set by merchant.
     *
     * @param string $unique Customer-unique ID or cookie set by merchant.
     * @return Kount_Ris_Request_Inquiry
     */
    public function setUnique($unique)
    {
        $this->data['UNIQ'] = $unique;
        return $this;
    }

    /**
     * Set the unix epoc date when unique was first set.
     *
     * @param string $epoch Epoch when unique was set.
     * @return Kount_Ris_Request_Inquiry
     */
    public function setEpoch($epoch)
    {
        $this->data['EPOC'] = $epoch;
        return $this;
    }

    /**
     * Set cash amount of any feasible goods in the order
     *
     * @param int $cash Cash amount of any feasible goods
     * @return Kount_Ris_Request_Inquiry
     */
    public function setCash($cash)
    {
        $this->data['CASH'] = $cash;
        return $this;
    }

    /**
     * Set shipment type
     *
     * @param string $shipType Ship type
     * @return Kount_Ris_Request_Inquiry
     */
    public function setShipType($shipType)
    {
        $this->data['SHTP'] = $shipType;
        return $this;
    }

    /**
     * Set the billing address
     *
     * @param string $address1 Billing address 1
     * @param string $address2 Billing address 2
     * @param string $city Billing city
     * @param string $state Billing state
     * @param string $postalCode Billing postal code
     * @param string $country Billing country
     * @param string $premise Billing premise
     * @param string $street Billing street
     * @return Kount_Ris_Request_Inquiry
     */
    public function setBillingAddress(
        $address1,
        $address2,
        $city,
        $state,
        $postalCode,
        $country,
        $premise = null,
        $street = null
    )
    {
        $this->data['B2A1'] = $address1;
        $this->data['B2A2'] = $address2;
        $this->data['B2CI'] = $city;
        $this->data['B2ST'] = $state;
        $this->data['B2PC'] = $postalCode;
        $this->data['B2CC'] = $country;
        if ($premise != null) {
            $this->data['BPREMISE'] = $premise;
        }
        if ($street != null) {
            $this->data['BSTREET'] = $street;
        }
        return $this;
    }

    /**
     * Set the billing phone number
     *
     * @param string $phoneNumber Billing phone number
     * @return Kount_Ris_Request_Inquiry
     */
    public function setBillingPhoneNumber($phoneNumber)
    {
        $this->data['B2PN'] = $phoneNumber;
        return $this;
    }

    /**
     * Set the shipping address
     *
     * @param string $address1 Shipping address 1
     * @param string $address2 Shipping address 2
     * @param string $city Shipping city
     * @param string $state Shipping state
     * @param string $postalCode Shipping postal code
     * @param string $country Shipping country
     * @param string $premise Shipping premise
     * @param string $street Shipping street
     * @return Kount_Ris_Request_Inquiry
     */
    public function setShippingAddress(
        $address1,
        $address2,
        $city,
        $state,
        $postalCode,
        $country,
        $premise = null,
        $street = null
    )
    {
        $this->data['S2A1'] = $address1;
        $this->data['S2A2'] = $address2;
        $this->data['S2CI'] = $city;
        $this->data['S2ST'] = $state;
        $this->data['S2PC'] = $postalCode;
        $this->data['S2CC'] = $country;
        if ($premise != null) {
            $this->data['SPREMISE'] = $premise;
        }
        if ($street != null) {
            $this->data['SSTREET'] = $street;
        }
        return $this;
    }

    /**
     * Set the shipping phone number
     *
     * @param string $phoneNumber Shipping phone number
     * @return Kount_Ris_Request_Inquiry
     */
    public function setShippingPhoneNumber($phoneNumber)
    {
        $this->data['S2PN'] = $phoneNumber;
        return $this;
    }

    /**
     * Set the shipping name
     *
     * @param string $shipName Shipping name
     * @return Kount_Ris_Request_Inquiry
     */
    public function setShippingName($shipName)
    {
        $this->data['S2NM'] = $shipName;
        return $this;
    }

    /**
     * Set the shipping email
     *
     * @param string $shipEmail Shipping email
     * @return Kount_Ris_Request_Inquiry
     */
    public function setShippingEmail($shipEmail)
    {
        $this->data['S2EM'] = $shipEmail;
        return $this;
    }

    /**
     * Set the user agent string
     *
     * @param string $userAgent User agent string of the client
     * @return Kount_Ris_Request_Inquiry
     */
    public function setUserAgent($userAgent)
    {
        $this->data['UAGT'] = $userAgent;
        return $this;
    }

    /**
     * Set the website id (shortname) associated with this transaction
     *
     * @param string $site Website id
     * @return Kount_Ris_Request_Inquiry
     */
    public function setWebsite($site)
    {
        $this->data['SITE'] = $site;
        return $this;
    }

    /**
     * Set the shopping cart
     * @param array $cart Array of Kount_Ris_Data_CartItem objects
     * @return Kount_Ris_Request_Inquiry
     * @throws Kount_Ris_IllegalArgumentException when $cart is not an array and
     * when an item in the $cart is not of type Kount_Ris_Data_CartItem.
     *
     */
    public function setCart($cart)
    {

        for ($i = 0; $i < count($cart); $i++) {

            $this->data["PROD_TYPE[{$i}]"] = $cart[$i]->getProductType();
            $this->data["PROD_ITEM[{$i}]"] = $cart[$i]->getItemName();
            $this->data["PROD_DESC[{$i}]"] = $cart[$i]->getDescription();
            $this->data["PROD_QUANT[{$i}]"] = $cart[$i]->getQuantity();
            $this->data["PROD_PRICE[{$i}]"] = $cart[$i]->getPrice();
        }
        return $this;
    }
} // end Kount_Ris_Request_Inquiry
