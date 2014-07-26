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
use Isotope\Model\Document as IsotopeDocument;


/**
 * Install all the basics for an Isotope store to save the two hours of setup
 *
 * @copyright  HBAgency 2014
 * @author     Blair Winans <bwinans@hbagency.com>
 * @author     Adam Fisher <afisher@hbagency.com>
 * @package    IsotopeInstaller
 */
class Document extends Installer
{

    /**
     * Install Documents for invoices/etc
     * @param boolean
     * @return int
     */
    public static function install($blnTruncate=false)
    {
        $objDB          = \Database::getInstance();
        $strTable       = IsotopeDocument::getTable();
    
        if($blnTruncate) {
            static::truncate($strTable);
        }
        
        //Invoice Document
        $arrInvoiceSet = array
        (
            'tstamp'             => time(),
            'name'               => 'Default Invoice',
            'type'               => 'standard',
            'documentTitle'      => 'Invoice # ##collection_document_number##',
            'fileTitle'          => 'invoice_##collection_document_number##',
            'documentTpl'        => 'iso_document_default',
            'collectionTpl'      => 'iso_collection_default',
            'orderCollectionBy'  => 'asc_id',
            'gallery'            => $GLOBALS['ISO_INSTALLER']['gallery']['cart'],
            'auto_installed'     => 1,
        );
        
        $intDocument = $objDB->prepare("INSERT INTO ".$strTable." %s")
                                              ->set($arrInvoiceSet)
                                              ->executeUncached()
                                              ->insertId;
                                                                
    
        return $intDocument;
    }

}