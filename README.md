# Silverstripe CataloguePage Module

A custom page type that either allows:

Mapping of product objects (defined via config) to a CMS page

Or

Mapping of multiple categories to a page in the CMS that then
renders them (and their products) into a template.

The page type also includes a $PaginatedChildren variable to allow
automatically breaking up larger product lists into smaller pages.

## Installation

The easiest way to install this module is via composer:

    # composer require "silverstripe/cataloguepage"
    
Otherwise install and download this module to the "cataloguepage" folder
in your project root.

## Requirements

* Silverstripe Framework 3.1 +
* Silverstripe CMS 3.1 +
* Silverstripe Catalogue

## Usage

Setup the catalogue as normal (add categories and then add products to
them).

Then add a catalogue page.

Once the page is created, you should have "Products" and "Categories"
tabs in the CMS, use this to add categories that will be displayed on
this page.


**NOTE** If you are using the [catalogue module](https://github.com/i-lateral/silverstripe-catalogue)
then you will most likely want to disable the frontend catalogue routing
and tempaltes. This can be done via silverstripe config:

config.yml

    Catalogue:
      enable_frontend: false

_config.php
    
    Catalogue::config()->enable_frontend = false;

## Custom Product or Categories

To customise the Product and Category objects that are used via this
page, you will need to change the **"product_class"** and **"category_class"**
config variables on CataloguePage.

It is important to be aware that CataloguePage will attempt to hand over
the current request to a controller identified by the
**"base_product_controller"** config variable. You will need to ensure
that you create a conntroller that can render your product.


