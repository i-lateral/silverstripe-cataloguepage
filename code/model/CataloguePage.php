<?php

class CataloguePage extends Page {

    /**
     * @var string
     */
    private static $icon = "cataloguepage/images/catalogue.png";
    
	/**
	 * @var string
	 */
	private static $description = 'Display product categories (and their products) on a page.';
    
    private static $many_many = array(
        "Categories" => "CatalogueCategory"
    );
    
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
