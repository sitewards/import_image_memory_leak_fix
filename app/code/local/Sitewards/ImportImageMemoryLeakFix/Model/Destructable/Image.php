<?php
/**
 * @category    Sitewards
 * @package     Sitewards_ImportImageMemoryLeakFix
 * @copyright   Copyright (c) Sitewards GmbH (http://www.sitewards.com/)
 */
class Sitewards_ImportImageMemoryLeakFix_Model_Destructable_Image extends Varien_Image
{
    /**
     * Constructor,
     * difference from original constructor - we register a destructor here.
     *
     * @param string $sFileName
     * @param Varien_Image_Adapter $oAdapter Default value is GD2
     */
    public function __construct($sFileName = null, $oAdapter = Varien_Image_Adapter::ADAPTER_GD2)
    {
        parent::__construct($sFileName, $oAdapter);

        // Initialize shutdown function
        register_shutdown_function(array($this, 'destruct'));
    }

    /**
     * Destroy object image on shutdown
     */
    public function destruct()
    {
        $oAdapter = $this->_getAdapter();
        if (method_exists($oAdapter, 'destruct')) {
            $oAdapter->destruct();
        } else {
            Mage::log('Image can not be destructed properly, adapter doesn\'t support the method.');
        }
    }
}
