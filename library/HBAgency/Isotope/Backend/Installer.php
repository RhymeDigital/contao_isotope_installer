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
 
namespace HBAgency\Isotope\Backend;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Installer extends \Controller
{

	/**
	 * Run the installer
	 */
	public static function install($blnTruncate=false)
	{
	    $GLOBALS['ISO_INSTALLER'] = array();
	    $arrCache = &$GLOBALS['ISO_INSTALLER'];
	    
		$arrCache['gallery']        = Installer\Gallery::install($blnTruncate);
		$arrCache['document']       = Installer\Document::install($blnTruncate);
		$arrCache['notification']   = Installer\Notification::install($blnTruncate);
		$arrCache['gateway']        = Installer\Gateway::install($blnTruncate);
		$arrCache['message']        = Installer\Message::install($blnTruncate);
		$arrCache['language']       = Installer\Language::install($blnTruncate);
		$arrCache['config']         = Installer\StoreConfig::install($blnTruncate);
	}
		
	/**
	 * Truncate a table
	 */
	protected static function truncate($strTable)
	{
		//Check if it exists
		if(\Database::getInstance()->tableExists($strTable)) {
			\Database::getInstance()->executeUncached("DELETE FROM $strTable WHERE auto_installed=1");
		}
	}

}