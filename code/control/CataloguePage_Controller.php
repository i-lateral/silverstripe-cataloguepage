<?php

class CataloguePage_Controller extends Page_Controller
{
    
    private static $allowed_actions = array();

    public function init()
    {
        parent::init();
    }
    
    public function PaginatedChildren($length = 12)
    {
        return new PaginatedList($this->Children(), $this->request);
    }
}
