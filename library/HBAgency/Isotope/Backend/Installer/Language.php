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
use NotificationCenter\Model\Language as IsotopeLanguage;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Language extends Installer
{

	/**
	 * Install Gateway
	 */
	public static function install($blnTruncate=false)
	{
	    $objDB          = \Database::getInstance();
		$strTable       = IsotopeLanguage::getTable();
		$arrReturn      = array();
	
		if($blnTruncate) {
			static::truncate($strTable);
		}
		
		//Admin Language
		$arrAdminSet = array
		(
			'pid'                => $GLOBALS['ISO_INSTALLER']['message']['admin'],
			'tstamp'		     => time(),
			'gateway_type'		 => 'email',
			'language'	         => 'en',
			'fallback'	         => 1,
			'recipients'	     => 'info@defaultemail.com',
			'email_sender_name'	 => 'Default Sender',
			'email_sender_address'=> 'info@defaultemail.com',
			'email_subject'	     => 'Thank you for your order!',
			'email_mode'	     => 'textAndHtml',
			'email_text'	     => static::getText(),
			'email_html'	     => static::getHTML(),
			'auto_installed'     => 1,
		);
		
		$arrReturn['admin'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
											  ->set($arrAdminSet)
											  ->executeUncached()
                                              ->insertId;
                                              
        //Customer Message
		$arrCustomerSet = array
		(
			'pid'                => $GLOBALS['ISO_INSTALLER']['message']['customer'],
			'tstamp'		     => time(),
			'gateway_type'		 => 'email',
			'language'	         => 'en',
			'fallback'	         => 1,
			'recipients'	     => '##recipient_email##',
			'email_sender_name'	 => 'Default Sender',
			'email_sender_address'=> 'info@defaultemail.com',
			'email_subject'	     => 'Thank you for your order!',
			'email_mode'	     => 'textAndHtml',
			'email_text'	     => static::getText(),
			'email_html'	     => static::getHTML(),
			'auto_installed'     => 1,
		);
                                              
        $arrReturn['customer'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
											  ->set($arrCustomerSet)
											  ->executeUncached()
                                              ->insertId;
																
	
        return $arrReturn;
	}
	
	/**
	 * Text message
	 */
	protected static function getText()
	{
    	return "Thank you for your order!

{{date::m/d/Y}}

Thank you for your order!

Order ID: ##order_id##

Billing Information:
##billing_address_text##
Payment Method: ##payment_label##

Shipping Information:
##shipping_address_text##
Shipping Method: ##shipping_label##

Products:
##cart_text##";
	}
	
	/**
	 * HTML Message
	 */
	protected static function getHTML()
	{
    	return '<div style="padding: 25px;">
<p style="font-size: 120%;">Thank you for your order!</p>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="10">
<tbody>
<tr>
<td><strong>Order ID:</strong>[nbsp]##order_id##</td>
<td>{{date::m/d/Y}}</td>
</tr>
</tbody>
</table>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="10">
<tbody>
<tr>
<td valign="top">
<p><strong>Billing Information:</strong></p>
<p>##billing_address##</p>
<p><strong>Payment Method</strong>:[nbsp]##payment_label##</p>
</td>
<td valign="top">
<p><strong>Shipping Information:</strong></p>
<p>##shipping_address##</p>
<p><strong>Shipping Method:</strong> [nbsp]##shipping_label##[nbsp]</p>
</td>
</tr>
</tbody>
</table>
<p class="products">##cart_html##</p>
</div>';
	}

}