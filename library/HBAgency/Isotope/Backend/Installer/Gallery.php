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
use Isotope\Model\Gallery as IsotopeGallery;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Gallery extends Installer
{

    /**
     * Install Galleries for listing/detail/cart
     *
     * @param boolean
     * @return array
     */
    public static function install($blnTruncate=false)
    {
        $objDB          = \Database::getInstance();
        $strTable       = IsotopeGallery::getTable();
        $arrReturn      = array();
    
        if($blnTruncate) {
            static::truncate($strTable);
        }
        
        //Listing Gallery
        $arrListingSet = array
        (
            'tstamp'        => time(),
            'name'          => 'Default Listing Gallery',
            'type'          => 'standard',
            'anchor'        => 'reader',
            'main_size'     => array('200', '200', 'center_center'),
            'gallery_size'  => array('100', '100', 'center_center'),
            'auto_installed'=> 1,
        );
        
        $arrReturn['listing'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                              ->set($arrListingSet)
                                              ->executeUncached()
                                              ->insertId;
                                                                
        //Reader Gallery
        $arrReaderSet = array
        (
            'tstamp'        => time(),
            'name'          => 'Default Reader Gallery',
            'type'          => 'standard',
            'anchor'        => 'lightbox',
            'main_size'     => array('300', '300', 'proportional'),
            'gallery_size'  => array('100', '100', 'center_center'),
            'lightbox_size' => array('', '', 'proportional'),
            'lightbox_template'=> 'j_colorbox',
            'auto_installed'=> 1,
        );
        
        $arrReturn['reader'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                                                ->set($arrReaderSet)
                                                                ->executeUncached()
                                                                ->insertId;
                                                                
        //Cart Gallery
        $arrCartSet = array
        (
            'tstamp'        => time(),
            'name'          => 'Default Cart Gallery',
            'type'          => 'standard',
            'anchor'        => 'reader',
            'main_size'     => array('50', '50', 'proportional'),
            'gallery_size'  => array('50', '50', 'center_center'),
            'auto_installed'=> 1,   
        );
        
        $arrReturn['cart'] = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                           ->set($arrCartSet)
                                           ->executeUncached()
                                           ->insertId;
    
        return $arrReturn;
    }

}