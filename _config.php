<?php

use ilateral\SilverStripe\CataloguePage\Model\CataloguePage;
use ilateral\SilverStripe\CataloguePage\Tools\CataloguePageAssociationManager;

if(class_exists("GoogleSitemap")) {
    GoogleSitemap::register_dataobject('CatalogueProduct');
}

CataloguePageAssociationManager::setup();
