<?php

class CataloguePage extends Page
{
    
    /**
     * Config variable to define what product class we are loading by
     * default
     * 
     * @var string
     * @config
     */
    private static $product_class = "Product";
    
    /**
     * Config variable to define what controller will be used to display
     * a product
     * 
     * @var string
     * @config
     */
    private static $base_product_controller = "CatalogueProductController";
    
    /**
     * Config variable to define what category class we are loading by
     * default
     * 
     * @var string
     * @config
     */
    private static $category_class = "Category";

    /**
     * @var string
     */
    private static $icon = "cataloguepage/images/catalogue.png";
    
    /**
     * @var string
     */
    private static $description = 'Display all products or products in selected categories on a page.';
    
    private static $allowed_children = array();
    
    /**
     * Spoof the standard CMS "Children" function to return either
     * related products or categories
     *
     * @return SSList
     */
    public function Children()
    {
        if($this->Products()->exists()) {
            return $this->SortedProducts();
        } elseif($this->Categories()->exists()) {
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
}
