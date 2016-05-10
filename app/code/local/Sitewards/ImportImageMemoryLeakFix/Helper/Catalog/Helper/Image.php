<?php
/**
 * @category    Sitewards
 * @package     Sitewards_ImportImageMemoryLeakFix
 * @copyright   Copyright (c) Sitewards GmbH (http://www.sitewards.com/)
 */
class Sitewards_ImportImageMemoryLeakFix_Helper_Catalog_Helper_Image extends Mage_Catalog_Helper_Image
{
    /**
     * Check - is this file an image
     *
     * Difference from original method - we destroy the image object here,
     * i.e. we are not wasting memory, without that fix product import with images
     * easily goes over 4Gb on memory with just couple hundreds of products.
     *
     * @param string $sFilePath
     *
     * @return bool
     * @throws Mage_Core_Exception
     */
    public function validateUploadFile($sFilePath) {
        if (!getimagesize($sFilePath)) {
            Mage::throwException($this->__('Disallowed file type.'));
        }

        /** @var Sitewards_ImportImageMemoryLeakFix_Model_Destructable_Image $oImageProcessor */
        $oImageProcessor = Mage::getModel('sitewards_importimagememoryleakfix/destructable_image', $sFilePath);
        $sMimeType       = $oImageProcessor->getMimeType();
        $oImageProcessor->destruct();

        return $sMimeType !== null;
    }
}
