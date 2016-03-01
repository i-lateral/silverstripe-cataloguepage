<?php

class CataloguePageAssociationManager {

    public static function setup() {
        // Setup manually mapping of products to a catalogue page
        $product_class = CataloguePage::config()->product_class;
        $category_class = CataloguePage::config()->category_class;

        // Setup many many associations
        CataloguePage::config()->many_many = array(
            "Products" => $product_class,
            "Categories" => $category_class
        );

        // Setup inverse
        $product_class::config()->belongs_many_many = array(
            "CataloguePages" => "CataloguePage"
        );

        $category_class::config()->belongs_many_many = array(
            "CataloguePages" => "CataloguePage"
        );
    }

}
