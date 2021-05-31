<?php

namespace Cap\Brand\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Cap\Brand\Api\BrandRepositoryInterface;
use Cap\Brand\Helper\Data;
use Cap\Brand\Model\Brand;
use Cap\Brand\Model\ResourceModel\Brand\CollectionFactory;

class Brands extends Template implements BlockInterface
{
    /**
     * Path to template file in theme.
     *
     * @var string
     */
    protected $_template = "widget/brands.phtml";

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Featured constructor.
     *
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param Data $helper
     * @param BrandRepositoryInterface $brandRepository
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        Data $helper,
        BrandRepositoryInterface $brandRepository,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->helper = $helper;
        $this->brandRepository = $brandRepository;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return \Cap\Brand\Model\ResourceModel\Brand\Collection
     */
    public function getBrands()
    {
        $collection = $this->collectionFactory->create();

        return $collection->addFieldToSelect('*')
                          ->addFieldToFilter('is_active', 1);
    }

    /**
     * @param Brand $brand
     *
     * @return false|string
     */
    public function getBrandSmallImageUrl(Brand $brand)
    {
        try {
            $mediaUrl = $this->storeManager->getStore()
                                           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            return $mediaUrl . $brand->getData('small_image');
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * Returns Brand url from model.
     *
     * Need to get BrandInterface from Brand model as helper
     * method uses BrandInterface.
     *
     * @param Brand $brand
     *
     * @return false|string
     */
    public function getBrandUrl(Brand $brand)
    {
        try {
            $brandInterface = $this->brandRepository->get($brand->getId());

            return $this->helper->getBrandUrl($brandInterface);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * Returns multidimensional array with brands grouped by character as key.
     *
     * @return array
     */
    public function getBrandsGroupedByCharacter()
    {
        $array = [];
        foreach (range('A', 'Z') as $key => $char) {
            foreach ($this->getBrands() as $brand) {
                if (strtoupper(substr($brand->getData('title'), 0, 1)) == $char) {
                    $key = $char;
                    $array[$key][] = [
                        'title' => $brand->getData('title'),
                        'url' => $this->getBrandUrl($brand),
                        'small_image' => $this->getBrandSmallImageUrl($brand)
                    ];
                }
            }
        }

        return $array;
    }
}
