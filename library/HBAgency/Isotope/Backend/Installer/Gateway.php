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
use NotificationCenter\Model\Gateway as IsotopeGateway;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Gateway extends Installer
{

    /**
     * Install Gateway
     *
     * @param boolean
     * @return int
     */
    public static function install($blnTruncate=false)
    {
        $objDB          = \Database::getInstance();
        $strTable       = IsotopeGateway::getTable();
    
        if($blnTruncate) {
            static::truncate($strTable);
        }
        
        //Default Gateway
        $arrSet = array
        (
            'tstamp'             => time(),
            'title'              => 'Email',
            'type'               => 'email',
            'auto_installed'     => 1,
        );
        
        $intGatewayID = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                              ->set($arrSet)
                                              ->executeUncached()
                                              ->insertId;
                                                                
    
        return $intGatewayID;
    }

}