<?php

namespace ilateral\SilverStripe\CataloguePage\Model;

use Page;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverCommerce\CatalogueAdmin\Forms\GridField\GridFieldConfig_CatalogueRelated;

class CataloguePage extends Page
{
    private static $table_name = 'CataloguePage';
    
    /**
     * Config variable to define what product class we are loading by
     * default
     *
     * @var string
     * @config
     */
    private static $product_class;
    
    /**
     * Config variable to define what controller will be used to display
     * a product
     *
     * @var string
     * @config
     */
    private static $base_product_controller;
    
    /**
     * Config variable to define what category class we are loading by
     * default
     *
     * @var string
     * @config
     */
    private static $category_class;

    /**
     * @var string
     */
    private static $icon = "resources/silverstripe/cataloguepage/client/dist/img/catalogue.png";
    
    /**
     * @var string
     */
    private static $description = 'Display all products or products in selected categories on a page.';
    
    private static $allowed_children = array();
    
    private static $db = array(
        'CategoryChildren' => 'Boolean',
        'CompileProducts' => 'Boolean',
        'ProductChildren' => 'Boolean'
    );

    private static $defaults = array(
        'CategoryChildren' => false,
        'ProductChildren' => false
    );

    /**
     * Spoof the standard CMS "Children" function to return either
     * related products or categories
     *
     * @return SSList
     */
    public function Children()
    {
        if ($this->Products()->exists() && $this->ProductChildren) {
            return $this->SortedProducts();
        } elseif ($this->Categories()->exists() && $this->CategoryChildren) {
            return $this->SortedCategories();
        } else {
            return ArrayList::create();
        }
    }

    /**
     * Get a list of sorted products (sorted by sort order)
     *
     * @return ManyManyList
     */
    public function SortedProducts()
    {
        return $this->Products()->sort("Sortorder");
    }
    
    /**
     * Get a list of sorted cateogories (sorted by sort order)
     *
     * @return ManyManyList
     */
    public function SortedCategories()
    {
        return $this->Categories()->sort("Sortorder");
    }
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->addFieldToTab(
            'Root.Products',
            GridField::create(
                _t("CataloguePage.Products", "Products"),
                "",
                $this->Products(),
                new GridFieldConfig_CatalogueRelated(
                    $this->config()->product_class,
                    null,
                    "SortOrder"
                )
            )
        );
        
        $fields->addFieldToTab(
            'Root.Categories',
            GridField::create(
                _t("CataloguePage.Categories", "Categories"),
                "",
                $this->Categories(),
                new GridFieldConfig_CatalogueRelated(
                    $this->config()->category_class,
                    null,
                    "SortOrder"
                )
            )
        );
        
        return $fields;
    }

    public function getSettingsFields()
    {
        $fields = parent::getSettingsFields();

        $fields->addFieldsToTab(
            'Root.Settings',
            array(
                CheckboxField::create(
                    'ProductChildren',
                    'Show products as children'
                ),
                CheckboxField::create(
                    'CategoryChildren',
                    'Show categories as children'
                ),
                CheckboxField::create(
                    'CompileProducts',
                    'Show all products as a single list'
                )
            )
        );

        return $fields;
    }

    /**
     * Collate selected descendants of this page.
     *
     * {@link $condition} will be evaluated on each descendant, and if it is succeeds, that item will be added to the
     * $collator array.
     *
     * @param string $condition The PHP condition to be evaluated. The page will be called $item
     * @param array  $collator  An array, passed by reference, to collect all of the matching descendants.
     * @return bool
     */
    public function collateDescendants($condition, &$collator)
    {
        return false;
    }
}
