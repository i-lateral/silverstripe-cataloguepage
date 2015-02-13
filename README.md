# Silverstripe CataloguePage Module

A custom page type that allows mapping of multiple catalogue categories
to a page in the CMS that then renders them (and their products) into a
template.

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

Once the page is created, you should have a "Categories" tab in the CMS,
use this to add categories that will be displayed on this page.
