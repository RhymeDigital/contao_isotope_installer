<?php

/**
 * Isotope Installer for Contao CMS
 *
 * Copyright (c) 2014 HBAgency
 *
 * @package IsotopeInstaller
 * @link    http://www.hbagency.com
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
 
namespace HBAgency\Isotope\Backend\Installer;

use HBAgency\Isotope\Backend\Installer;
use Isotope\Model\Config as IsotopeConfig;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class StoreConfig extends Installer
{

	/**
	 * Install Documents for invoices/etc
	 */
	public static function install($blnTruncate=false)
	{
	    $objDB          = \Database::getInstance();
		$strTable       = IsotopeConfig::getTable();
	
		if($blnTruncate) {
			static::truncate($strTable);
		}
		
		//Default Config
		$arrSet = array
		(
			'tstamp'		     => time(),
			'name'			     => 'Default Store Config',
			'label'			     => 'Default Store Config',
			'fallback'           => 1,
			'subdivision'        => 'US-MA',
			'country'            => 'us',
			'address_fields'     => static::getAddressFields(),
			'billing_country'    => 'us',
			'shipping_country'   => 'us',
			'billing_countries'  => array('us'),
			'shipping_countries' => array('us'),
			'limitMemberCountries'=> 1,
			'priceRoundPrecision'=> 2,
			'priceRoundIncrement'=> 0.01,
			'cartMinSubtotal'    => 0.00,
			'currency'           => 'USD',
			'currencySymbol'     => 1,
			'currencyPosition'   => 'left',
			'currencyFormat'     => '10,000.00',
			'priceCalculateFactor' => 1,
			'priceCalculateMode' => 'mul',
			'orderPrefix'        => date('Y'),
			'orderDigits'        => 4,
			'orderstatus_new'    => 2,
			'orderstatus_error'  => 4,
			'newProductPeriod'   => array('unit'=>'days', 'value'=> 30),
			'auto_installed'     => 1,
		);
		
		$intConfigID = $objDB->prepare("INSERT INTO ".$strTable." %s")
											  ->set($arrSet)
											  ->executeUncached()
                                              ->insertId;
																
	
        return $intConfigID;
	}
    
    /**
	 * Build the address fields
	 */
	public static function getAddressFields()
	{
	    $arrAddressFields = array
        (
            'label' => array
            (   
                'name' => 'label', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>0
            ),
            'gender' => array
            (
                'name' => 'gender', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>1
            ),
            'salutation' => array
            (
                'name' => 'salutation', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>2
            ),
            'firstname' => array
            (
                'name' => 'firstname', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>3
            ),
            'lastname' => array
            (
                'name' => 'lastname', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>4
            ),
            'dateOfBirth' => array
            (
                'name'=>'dateOfBirth', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>5
            ),
            'company' => array
            (
                'name' => 'company', 'billing' => 'enabled', 'shipping' => 'enabled', 'position'=>6
            ),
            'vat_no' => array
            (
                'name' => 'vat_no', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>7
            ),
            'street_1' => array
            (
                'name' => 'street_1', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>8
            ),
            'street_2' => array
            (
                'name' => 'street_2', 'billing' => 'enabled', 'shipping' => 'enabled', 'position'=>9
            ),
            'street_3' => array
            (
                'name' => 'street_3', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>10
            ),
            'city' => array
            (
                'name' => 'city', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>11
            ),
            'subdivision' => array
            ( 
                'name' => 'subdivision', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>12
            ),
            'postal' => array
            (
                'name' => 'postal', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>13
            ),
            'country' => array
            (
                'name' => 'country', 'billing' => 'mandatory', 'shipping' => 'mandatory', 'position'=>14
            ),
            'phone' => array
            (
                'name' => 'phone', 'billing' => 'mandatory', 'shipping' => 'enabled', 'position'=>15
            ),
            'email' => array
            (
                'name' => 'email', 'billing' => 'mandatory', 'shipping' => 'disabled', 'position'=>16
            ),
            'isDefaultBilling' => array
            (
                'name' => 'isDefaultBilling', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>17
            ),
            'isDefaultShipping' => array
            (
                'name' => 'isDefaultShipping', 'billing' => 'disabled', 'shipping' => 'disabled', 'position'=>18
            ),
        );
        
        return $arrAddressFields;
	}
}