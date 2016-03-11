<?php
namespace Yoma\FeedFinder\Controller\Index;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class Fetch extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->request = $request;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->categoryFactory = $categoryFactory;
        $this->_storeManager = $storeManager;
    }

    /**
     * Initialize requested category object
     *
     * @return \Magento\Catalog\Model\Category
     */
    protected function _initCategory()
    {
        $category = $this->request->getPostValue('category');
        if (!$category) {
            return false;
        }

        try {
            $category = $this->categoryFactory->create()->loadByAttribute('url_key',$category);
        } catch (NoSuchEntityException $e) {
            return false;
        }

        $category->setStoreId($this->_storeManager->getStore()->getId());
        return $category;
    }


    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {

        $result = $this->resultJsonFactory->create();
        $category = $this->_initCategory();

        if($category){
            $products = $this->_getCategoryProducts($category)->load();
            $productData = array();
            foreach($products as $product){

                $productData[] = $this->getProduct($product);
            }
        }

        return $result->setData($productData);
    }

    protected function _getCategory($value,$context = 'url_key')
    {
        $category = $this->categoryFactory->create();
            $category->loadByAttribute($context,$value);
        return $category;
    }

    protected function _getCategoryProducts($category) {

        $products = $category->getProductCollection();
        $products->addAttributeToSelect('*');
        return $products;
    }

    protected function getProduct($product){
        return array(
            'image' => $product->getSmallImage(),
            'name' => $product->getName(),
            'description' => $product->getShortDescription(),
            'url' => $product->getProductUrl(),
        );

    }
}

?>