<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require '../../../initialize.php';


/**
 * Class TestInstall
 *
 * Main front end controller.
 * @copyright  Leo Feyer 2005-2013
 * @author     Leo Feyer <https://contao.org>
 * @package    Core
 */
class TestInstall extends \Frontend
{

    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Run the controller
     */
    public function run()
    {
        HBAgency\Isotope\Backend\Installer::install(true);
    }
    
}

/**
 * Instantiate the controller
 */
$objTestInstall = new TestInstall();
$objTestInstall->run();