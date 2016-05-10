Sitewards ImportImageMemoryLeakFix
==================================

Issue
-----

Product import with images easily goes over 4Gb on memory with just couple hundreds of products.
The reason for this is that the image model is never properly destoried.

Fix
---

Use a different image processor than `Varien_Image`.
Add a `destruct` method into this new processor and register it on shutdown.
Rewrite `Mage_Catalog_Helper_Image` to change the method `validateUploadFile`.
Call new processor, call destruct and then return the mime type of the image.
