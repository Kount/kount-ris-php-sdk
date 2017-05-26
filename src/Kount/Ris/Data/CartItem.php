<?php
/**
 * CarItem.php file containing Kount_Ris_Data_CartItem data class.
 */

/**
 * RIS shopping cart item data class.
 *
 * @package Kount_Ris
 * @subpackage Data
 * @author Kount <custserv@kount.com>
 * @version $Id: Exception.php 228 2009-10-26 18:04:59Z mmn $
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_Data_CartItem {

  /**
   * Product type
   *
   * @var string
   */
  protected $productType;

  /**
   * Item name
   *
   * @var string
   */
  protected $itemName;

  /**
   * Item name
   *
   * @var string
   */
  protected $description;

  /**
   * Quantity
   *
   * @var int
   */
  protected $quantity;

  /**
   * Price of item in pennies
   *
   * @var int
   */
  protected $price;

  /**
   * Construct a response object
   *
   * @param string $productType The product type
   * @param string $itemName The item name
   * @param string $description The description of the item
   * @param string $quantity The quantity
   * @param string $price The price of the item
   */
  public function __construct ($productType, $itemName, $description,
      $quantity, $price) {
    $this->productType = $productType;
    $this->itemName = $itemName;
    $this->description = $description;
    $this->quantity = $quantity;
    $this->price = $price;
  }

  /**
   * Get the product type
   *
   * @return string
   */
  public function getProductType () {
    return $this->productType;
  }

  /**
   * Get the item name
   *
   * @return string
   */
  public function getItemName () {
    return $this->itemName;
  }

  /**
   * Get the description
   *
   * @return string
   */
  public function getDescription () {
    return $this->description;
  }

  /**
   * Get the quantity
   *
   * @return int
   */
  public function getQuantity () {
    return $this->quantity;
  }

  /**
   * Get the price
   *
   * @return int
   */
  public function getPrice () {
    return $this->price;
  }

  /**
   * Set the product type
   *
   * @param string $productType Product type
   * @return this
   */
  public function setProductType ($productType) {
    $this->productType = $productType;
    return $this;
  }

  /**
   * Set the item name
   *
   * @param string $itemName Item name
   * @return this
   */
  public function setItemName ($itemName) {
    $this->itemName = $itemName;
    return $this;
  }

  /**
   * Set the description
   *
   * @param string $description Description of the item
   * @return this
   */
  public function setDescription ($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Set the quantity
   *
   * @param int $quantity Quantity
   * @return this
   */
  public function setQuantity ($quantity) {
    $this->quantity = $quantity;
    return $this;
  }

  /**
   * Set the price
   *
   * @param int $price Price of the item
   * @return this
   */
  public function setPrice ($price) {
    $this->price = $price;
    return $this;
  }

} // Kount_Ris_Data_CartItem
