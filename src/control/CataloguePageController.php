<?php

namespace ilateral\SilverStripe\CataloguePage\Model;

use Product;
use PageController;
use SilverStripe\ORM\DataList;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Control\Director;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use ilateral\SilverStripe\CataloguePage\Model\CataloguePage;

class CataloguePageController extends PageController
{
    
    private static $allowed_actions = array(
        "product"
    );
    
    /**
     * Set up the "restful" URLs
     *
     * @config
     * @var array
     */
    private static $url_handlers = array(
        '$Action/$ID' => 'handleAction',
    );

    public function init()
    {
        parent::init();
    }
    
    public function PaginatedChildren($length = 12)
    {
        return new PaginatedList($this->Children(), $this->request);
    }
    
    public function getCompiledProducts($page_length = 30)
    {
        $products = false;
        $product_class = Config::inst()->get(
            CataloguePage::class,
            'product_class'
        );

        if ($this->Categories()->exists() && $this->CompileProducts) {
            $cats = $this->Categories()->column('ID');

            $filter = [
                'Categories.ID' => $cats,
                'Disabled' => 0
            ];
    
            $this->extend('updateCompiledProductsFilter', $filter);
            
            $raw_products = DataList::create($product_class)
                ->filter(
                    $filter
                );

            $this->extend('updateCompiledProductsList', $raw_products);

            $products = new PaginatedList($raw_products, $this->getRequest());
            $products->setPageLength($page_length);
        }

        $this->extend('updateCompiledProducts', $products);

        return $products;
    }
    
    public function product($request)
    {
        // Shift the current url up one and get the URL segment
        $request->shiftAllParams();
        $urlsegment = $request->param('URLSegment');
        $product_class = Config::inst()->get(
            CataloguePage::class,
            'product_class'
        );
        
        // Setup our filter and get a product
        $filter = array(
            'URLSegment' => $urlsegment,
            'Disabled' => 0
        );
        
        $object = $product_class::get()->filter($filter)->first();
        
        if (!$object) {
            return $this->httpError(404);
        }

        $this->customise(
            [
                'Product' => $object
            ]
        );

        return $this->render();
    }
    
    /**
     * Get the appropriate {@link CatalogueProductController} or
     * {@link CatalogueProductController} for handling the relevent
     * object.
     *
     * @param $object Either Product or Category object
     * @param string $action
     * @return CatalogueController
     */
    protected static function controller_for($object, $action = null)
    {
        $controller_class = Config::inst()->get(
            CataloguePage::class,
            'base_product_controller'
        );
        
        $controller = null;

        if (isset($controller_class) && class_exists($controller_class)) {
            $controller = $controller_class;
        }
        
        if (!$controller) {
            $ancestry = ClassInfo::ancestry($object->ClassName);
            
            while ($class = array_pop($ancestry)) {
                if (class_exists($class . "Controller")) {
                    break;
                }
            }
            
            // Find the controller we need, or revert to a default
            if ($class !== null) {
                $controller = "{$class}Controller";
            }
        }

        if ($action && class_exists($controller . '_' . ucfirst($action))) {
            $controller = $controller . '_' . ucfirst($action);
        }

        if (!class_exists($controller)) {
            $controller = self::class;
        }
        
        return Injector::inst()->create($controller, $object);
    }
    
    
    /**
     * @param SS_HTTPRequest $request
     * @param $model
     *
     * @return HTMLText|SS_HTTPResponse
     */
    protected function handleAction($request, $model)
    {
        //we return nested controllers, so the parsed URL params need to be discarded for the subsequent controllers
        // to work
        $request->shiftAllParams();
        
        return parent::handleAction($request, $model);
    }
}
