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
class Kount_Ris_Request_Inquiry extends Kount_Ris_Request {

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
  const SHIP_2ND  = '2D';

  /**
   * Standard shipping
   * @var string
   * @see setShipType()
   */
  const SHIP_STD  = 'ST';


  /**
   * Inquiry constructor. Sets the RIS mode to "Inquiry" ("Q"), sets currency to "USD",
   * sets the PHP SDK identifier.
   *
   * @param Kount_Ris_Settings $settings Configuration settings
   */
  public function __construct ($settings = null) {
    parent::__construct($settings);
    // defaults
    $this->setMode(self::MODE_Q);
    $this->setCurrency('USD');
    $this->setParm('SDK', 'PHP');
    $this->setParm('SDK_VERSION', 'Sdk-Ris-Php-0631-20150506T1139');
  }


  /**
   * Set the date of birth in the format YYYY-MM-DD.
   *
   * @param string $dob Date of birth
   * @return this
   */
  public function setDateOfBirth ($dob) {
    $this->data['DOB'] = $dob;
    return $this;
  }


  /**
   * Set the customer's gender. Either M(male) or F(female).
   *
   * @param string $gender Gender ("M" or "F")
   * @return this
   */
  public function setGender ($gender) {
    $this->data['GENDER'] = $gender;
    return $this;
  }

  /**
   * Set the value of a named user defined field.
   *
   * @param string $label The user defined field label
   * @param string $value The user defined field value
   * @return this
   */
  public function setUserDefinedField ($label, $value) {
    $index = "UDF[{$label}]";
    $this->data[$index] = $value;
    return $this;
  }

  /**
   * Set the inquiry mode
   * Acceptable values are: "Q", "P", "W", "J"
   *
   * @param string $mode RIS inquiry mode (Q/P)
   * @throws Kount_Ris_IllegalArgumentException when $mode doesn't mach any of the defined inquiry modes.
   * @return this
   */
  public function setMode ($mode) {
    if ((self::MODE_Q != $mode) && (self::MODE_P != $mode) &&
        (self::MODE_W != $mode) && (self::MODE_J != $mode)) {
      throw new Kount_Ris_IllegalArgumentException(
          "Invalid RIS inquiry mode [{$mode}]. Must be 'Q', 'P', 'W' or 'J'");
    }
    $this->data['MODE'] = $mode;
    return $this;
  }

  /**
   * Set the three character ISO-4217 currency code.
   *
   * @param string $currency Three character currency code. For
   *    example USD: US Dollar, EUR: Euro.
   * @return this
   */
  public function setCurrency ($currency) {
    $this->data['CURR'] = $currency;
    return $this;
  }

  /**
   * Set the total amount in lowest possible denomination of currency.
   *
   * @param int $total Transaction amount in pennies of currency.
   * @return this
   */
  public function setTotal ($total) {
    $this->data['TOTL'] = $total;
    return $this;
  }

  /**
   * Set the IP address of the client.
   *
   * @param string $ipAddress IP Address of the client
   * @return this
   */
  public function setIpAddress ($ipAddress) {
    $this->data['IPAD'] = $ipAddress;
    return $this;
  }

  /**
   * Set the email address of the client.
   *
   * @param string $email Email address of the client
   * @return this
   */
  public function setEmail ($email) {
    $this->data['EMAL'] = $email;
    return $this;
  }

  /**
   * Set the ANI (Automatic Identification Number) received for the phone
   * transaction.
   *
   * @param string $anid ANI of the client
   * @return this
   */
  public function setAnid ($anid) {
    $this->data['ANID'] = $anid;
    return $this;
  }

  /**
   * Set the name of the client.
   *
   * @param string $name Name of the client or company
   * @return this
   */
  public function setName ($name) {
    $this->data['NAME'] = $name;
    return $this;
  }

  /**
   * Set the customer unique id or cookie
   *
   * @param string $unique Customer-unique ID or cookie set by merchant.
   * @return this
   * @deprecated version 4.0.0 - 2009. Use Kount_Ris_Inquiry->setUnique()
   *   instead.
   */
  public function setUniqe ($unique) {
    $this->logger->info('The method Kount_Ris_Inquiry->setUniqe() is " +
        "deprecated. Use Kount_Ris_Inquiry->setUnique() instead.');
    return $this->setUnique($unique);
  }

  /**
   * Set the customer unique id or cookie set by merchant.
   *
   * @param string $unique Customer-unique ID or cookie set by merchant.
   * @return this
   */
  public function setUnique ($unique) {
    $this->data['UNIQ'] = $unique;
    return $this;
  }

  /**
   * Set the unix epoc date when unique was first set.
   *
   * @param string $epoch Epoch when unique was set.
   * @return this
   */
  public function setEpoch ($epoch) {
    $this->data['EPOC'] = $epoch;
    return $this;
  }

  /**
   * Set cash amount of any feasible goods in the order
   *
   * @param int $cash Cash amount of any feasible goods
   * @return this
   */
  public function setCash ($cash) {
    $this->data['CASH'] = $cash;
    return $this;
  }

  /**
   * Set shipment type
   *
   * @param string $shipType Ship type
   * @return this
   */
  public function setShipType ($shipType) {
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
   * @return this
   */
  public function setBillingAddress ($address1, $address2, $city, $state,
      $postalCode, $country, $premise = null, $street = null) {
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
   * @return this
   */
  public function setBillingPhoneNumber ($phoneNumber) {
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
   * @return this
   */
  public function setShippingAddress ($address1, $address2, $city, $state,
      $postalCode, $country, $premise = null, $street = null) {
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
   * @return this
   */
  public function setShippingPhoneNumber ($phoneNumber) {
    $this->data['S2PN'] = $phoneNumber;
    return $this;
  }

  /**
   * Set the shipping name
   *
   * @param string $shipName Shipping name
   * @return this
   */
  public function setShippingName ($shipName) {
    $this->data['S2NM'] = $shipName;
    return $this;
  }

  /**
   * Set the shipping email
   *
   * @param string $shipEmail Shipping email
   * @return this
   */
  public function setShippingEmail ($shipEmail) {
    $this->data['S2EM'] = $shipEmail;
    return $this;
  }

  /**
   * Set the user agent string
   *
   * @param string $userAgent User agent string of the client
   * @return this
   */
  public function setUserAgent ($userAgent) {
    $this->data['UAGT'] = $userAgent;
    return $this;
  }

  /**
   * Set the website id (shortname) associated with this transaction
   *
   * @param string $site Website id
   * @return this
   */
  public function setWebsite ($site) {
    $this->data['SITE'] = $site;
    return $this;
  }

  /**
   * Set the expiration month of a credit card.
   * Format: MM
   *
   * @param string $month Expiration month
   * @return this
   */
  public function setExpirationMonth ($month) {
    $this->data['CCMM'] = $month;
    return $this;
  }

  /**
   * Set the expiration year of a credit card.
   * Format: YYYY
   *
   * @param string $year Expiration year
   * @return this
   */
  public function setExpirationYear ($year) {
    $this->data['CCYY'] = $year;
    return $this;
  }

  /**
   * Set the shopping cart
   * @param array $cart Array of Kount_Ris_Data_CartItem objects
   * @throws Kount_Ris_IllegalArgumentException when $cart is not an array and
   * when an item in the $cart is not of type Kount_Ris_Data_CartItem.
   *
   * @return this
   */
  public function setCart ($cart) {
    if (!is_array($cart)) {
      throw new Kount_Ris_IllegalArgumentException("Cart must be an array");
    }
    for ($i = 0; $i < count($cart); $i++) {
      if ('Kount_Ris_Data_CartItem' != get_class($cart[$i])) {
        throw new Kount_Ris_IllegalArgumentException("Cart item #{$i} " .
            print_r($cart[$i], true) . " must be of type " .
            "Kount_Ris_Data_CartItem");
      }
      $this->data["PROD_TYPE[{$i}]"] = $cart[$i]->getProductType();
      $this->data["PROD_ITEM[{$i}]"] = $cart[$i]->getItemName();
      $this->data["PROD_DESC[{$i}]"] = $cart[$i]->getDescription();
      $this->data["PROD_QUANT[{$i}]"] = $cart[$i]->getQuantity();
      $this->data["PROD_PRICE[{$i}]"] = $cart[$i]->getPrice();
    }
    return $this;
  }

} // end Kount_Ris_Request_Inquiry
