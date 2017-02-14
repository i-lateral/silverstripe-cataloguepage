<?php

class CataloguePageCatalogueExtension extends DataExtension
{
    
    private static $belongs_many_many = array(
        "CataloguePages" => "CataloguePage"
    );
}
