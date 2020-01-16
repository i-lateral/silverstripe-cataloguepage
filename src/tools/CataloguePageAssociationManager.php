<?php

namespace ilateral\SilverStripe\CataloguePage\Tools;

use SilverStripe\Dev\Debug;
use SilverStripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use ilateral\SilverStripe\CataloguePage\Model\CataloguePage;
use ilateral\SilverStripe\CataloguePage\Extensions\CataloguePageProductExtension;

class CataloguePageAssociationManager
{
    
    public static function setup()
    {
        // Setup manually mapping of products to a catalogue page
        $product_class = Config::inst()->get(
            CataloguePage::class,
            'product_class'
        );
        $category_class = Config::inst()->get(
            CataloguePage::class,
            'category_class'
        );

        $new = [
            "Products" => $product_class,
            "Categories" => $category_class
        ];

        // Setup many many associations
        Config::modify()->merge(
            CataloguePage::class,
            'many_many',
            $new
        );

        // Setup many many associations
        Config::modify()->merge(
            CataloguePage::class,
            'many_many_extraFields',
            [
                'Products' => array('SortOrder' => 'Int'),
                'Categories' => array('SortOrder' => 'Int')
            ]
        );

        if (class_exists($product_class)) {
            Config::modify()->merge(
                $product_class,
                'extensions',
                [
                    CataloguePageProductExtension::class
                ]
            );

            // Setup inverse
            Config::modify()->merge(
                $product_class,
                'belongs_many_many',
                [
                    "CataloguePages" => CataloguePage::class
                ]
            );
        }
        
        if (class_exists($category_class)) {
            Config::modify()->merge(
                $category_class,
                'belongs_many_many',
                [
                    "CataloguePages" => CataloguePage::class
                ]
            );
        }
    }
}
