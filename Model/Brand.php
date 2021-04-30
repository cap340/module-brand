<?php
declare(strict_types=1);

namespace Cap\Brand\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Cap\Brand\Api\Data\BrandInterface;
use Cap\Brand\Api\Data\BrandInterfaceFactory;
use Cap\Brand\Model\ResourceModel\Brand\Collection;

class Brand extends AbstractModel
{
    /**#@+
     * Brand's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'cap_brand';

    /**
     * @var BrandInterfaceFactory
     */
    protected $brandDataFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param BrandInterfaceFactory $brandDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\Brand $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        BrandInterfaceFactory $brandDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\Brand $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->brandDataFactory = $brandDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve brand model with brand data
     * @return BrandInterface
     */
    public function getDataModel()
    {
        $brandData = $this->getData();

        $brandDataObject = $this->brandDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $brandDataObject,
            $brandData,
            BrandInterface::class
        );

        return $brandDataObject;
    }

    /**
     * Prepare brand's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
