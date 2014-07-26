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
use NotificationCenter\Model\Message as IsotopeMessage;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Message extends Installer
{

    /**
     * Install Messages
     *
     * @param boolean
     * @return array
     */
    public static function install($blnTruncate=false)
    {
        $objDB          = \Database::getInstance();
        $strTable       = IsotopeMessage::getTable();
        $arrReturn      = array();
    
        if($blnTruncate) {
            static::truncate($strTable);
        }
        
        //Admin Message
        $arrAdminSet = array
        (
            'pid'                => $GLOBALS['ISO_INSTALLER']['notification'],
            'tstamp'             => time(),
            'title'              => 'Admin Email',
            'gateway'            => $GLOBALS['ISO_INSTALLER']['gateway'],
            'gateway_type'       => 'email',
            'email_priority'     => 3,
            'email_template'     => 'mail_default',
            'published'          => 1,
            'auto_installed'     => 1,
        );
        
        $arrReturn['admin'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                              ->set($arrAdminSet)
                                              ->executeUncached()
                                              ->insertId;
                                              
        //Customer Message
        $arrCustomerSet = array
        (
            'pid'                => $GLOBALS['ISO_INSTALLER']['notification'],
            'tstamp'             => time(),
            'title'              => 'Customer Email',
            'gateway'            => $GLOBALS['ISO_INSTALLER']['gateway'],
            'gateway_type'       => 'email',
            'email_priority'     => 3,
            'email_template'     => 'mail_default',
            'published'          => 1,
            'auto_installed'     => 1,
        );
                                              
        $arrReturn['customer'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                              ->set($arrCustomerSet)
                                              ->executeUncached()
                                              ->insertId;
                                                                
    
        return $arrReturn;
    }

}