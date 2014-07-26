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
use NotificationCenter\Model\Notification as IsotopeNotification;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Notification extends Installer
{

    /**
     * Install Notifications
     *
     * @param boolean
     * @return int
     */
    public static function install($blnTruncate=false)
    {
        $objDB          = \Database::getInstance();
        $strTable       = IsotopeNotification::getTable();
    
        if($blnTruncate) {
            static::truncate($strTable);
        }
        
        //Default Notification
        $arrSet = array
        (
            'tstamp'             => time(),
            'title'              => 'Isotope Order Status Notification',
            'type'               => 'iso_order_status_change',
            'iso_collectionTpl'  => 'iso_collection_default',
            'iso_orderCollectionBy'=> 'asc_id',
            'iso_gallery'        => $GLOBALS['ISO_INSTALLER']['gallery']['cart'],
            'iso_document'       => 0,
            'auto_installed'     => 1,
        );
        
        $intNotificationID = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                              ->set($arrSet)
                                              ->executeUncached()
                                              ->insertId;
                                                                
    
        return $intNotificationID;
    }

}