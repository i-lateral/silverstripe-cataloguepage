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
     * @var string
     */
    private static $icon = "cataloguepage/images/catalogue.png";
    
	/**
	 * @var string
	 */
	private static $description = 'Display all products or products in selected categories on a page.';
    
    private static $many_many = array(
        "Categories" => "CatalogueCategory"
    );
    
    private static $allowed_children = array();
    
    public function Children() {
        if($this->Categories()->exists())
            return $this->Categories();
        else
            return $this->AllProducts();
    }
    
    public function AllProducts() {
        $class = $this->config()->product_class;
        return $class::get();
    }
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        $gridconfig = new GridFieldConfig_RelationEditor();
        
        $categoryfield = GridField::create(
			_t("CataloguePage.Categories", "Categories"),
			"",
            $this->Categories(),
            $gridconfig
        );
        
        $fields->addFieldToTab(
			'Root.Categories',
			$categoryfield
		);
		
        return $fields;
    }
    
}
