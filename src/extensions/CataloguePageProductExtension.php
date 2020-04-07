<?php

namespace ilateral\SilverStripe\CataloguePage\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;
use ilateral\SilverStripe\CataloguePage\Model\CataloguePage;

class CataloguePageProductExtension extends DataExtension
{
    private static $db = [
        "URLSegment" => "Varchar"
    ];
    
    public function updateRelativeLink(&$base, $action)
    {
        $page = null;

        // Try to find the current product's page
        if ($this->owner->CataloguePages()->exists()) {
            $page = $this->owner->CataloguePages()->first();
        } elseif ($category = $this->owner->Categories()->first()) {
            if ($category->CataloguePages()->exists()) {
                $page = $category->CataloguePages()->first();
            }
        }
        
        // If no page has been found, revert to a default
        if (!$page) {
            $page = CataloguePage::get()->first();
        }

        if ($page) {
            $link = Controller::join_links(
                $page->RelativeLink("product"),
                $this->owner->URLSegment,
                $action
            );

            $base = $link;

            return $link;
        }
        return $base;
    }
    
    public function updateAncestors($ancestors, $include_parent)
    {
        
        // Check if there is a catalogue page with this product
        $page = CataloguePage::get()
            ->filter("Products.ID", $this->owner->ID)
            ->first();
        
        if (!$page) {
            // Else check we have a product in a category that matches
            $categories = $this->owner->Categories();
            $page = null;
            
            // Find the first category page we have mapped
            foreach ($categories as $category) {
                if (!$page && $category->CataloguePages()->exists()) {
                    $page = $category->CataloguePages()->first();
                }
            }
        }
        
        if ($page) {
            // Clear all ancestors
            foreach ($ancestors as $ancestor) {
                $ancestors->remove($ancestor);
            }
            
            if ($include_parent) {
                $ancestors->push($page);
            }
            
            while ($page = $page->getParent()) {
                $ancestors->push($page);
            }
        }
    }

    public function updateCMSFields(FieldList $fields)
    {
        $parent = null;
        $parent_link = null;
    
        $parent = $this
            ->owner
            ->CataloguePages()
            ->first();

        if ($parent) {
            $parent_link = $parent->RelativeLink();
        }
        
        $baseLink = Controller::join_links(
            Director::absoluteBaseURL(),
            $parent_link
        );

        // If URL field already exists (say was added by catalogue frontend)
        $url_field = $fields->dataFieldByName("URLSegment");

        if (empty($url_field) || (!empty($url_field) && !is_a($url_field, SiteTreeURLSegmentField::class))) {
            $url_field = SiteTreeURLSegmentField::create(
                "URLSegment",
                $this->owner->fieldLabel('URLSegment')
            );
        }

        $url_field->setURLPrefix($baseLink);
        $base_field = null;

        if ($fields->dataFieldByName("Content")) {
            $base_field = "Content";
        }
        $fields->addFieldToTab(
            "Root.Main",
            $url_field,
            $base_field
        );
    }

    public function onBeforeWrite()
    {
        // Only call on first creation, ir if title is changed
        if ($this->owner->isChanged('Title') || !$this->owner->URLSegment) {
            // Set the URL Segment, so it can be accessed via the controller
            $filter = URLSegmentFilter::create();
            $t = $filter->filter($this->owner->Title);
            // Fallback to generic name if path is empty (= no valid, convertable characters)
            if (!$t || $t == '-' || $t == '-1') {
                $t = "{$this->owner->ID}";
            }

            // Ensure that this object has a non-conflicting URLSegment value.
            $existing_cats = CataloguePage::get()->filter('URLSegment', $t)->count();
            $existing_products = $this->owner->ClassName::get()->filter('URLSegment', $t)->count();
            $existing_pages = SiteTree::get()->filter('URLSegment', $t)->count();
            $count = (int)$existing_cats + (int)$existing_products + (int)$existing_pages;
            $this->owner->URLSegment = ($count) ? $t . '-' . ($count + 1) : $t;
        }
    }
}
