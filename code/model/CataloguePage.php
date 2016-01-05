<?php

class CataloguePage extends Page {
    
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
    
    public function Children() {
        if($this->Products()->exists())
            return $this->Products();
        elseif($this->Categories()->exists())
            return $this->Categories();
    }
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        $gridconfig = new GridFieldConfig_RelationEditor();
        
        $fields->addFieldToTab(
			'Root.Products',
			GridField::create(
                _t("CataloguePage.Products", "Products"),
                "",
                $this->Products(),
                $gridconfig
            )
		);
        
        $fields->addFieldToTab(
			'Root.Categories',
			GridField::create(
                _t("CataloguePage.Categories", "Categories"),
                "",
                $this->Categories(),
                $gridconfig
            )
		);
		
        return $fields;
    }
    
}
