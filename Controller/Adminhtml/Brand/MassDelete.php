<?php

namespace Cap\Brand\Controller\Adminhtml\Brand;

use Cap\Brand\Api\BrandRepositoryInterface;
use Cap\Brand\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;

class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var BrandRepositoryInterface
     */
    protected $brandRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param BrandRepositoryInterface $brandRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        BrandRepositoryInterface $brandRepository,
        LoggerInterface $logger
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->brandRepository = $brandRepository;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $brandDeleted = 0;
        $brandDeletedError = 0;

        /** @var \Cap\Brand\Api\Data\BrandInterface $brand */
        foreach ($collection->getItems() as $brand) {
            try {
                $this->brandRepository->delete($brand);
                $brandDeleted++;
            } catch (LocalizedException $e) {
                $this->logger->error($e->getLogMessage());
                $brandDeletedError++;
            }
        }

        if ($brandDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $brandDeleted)
            );
        }

        if ($brandDeletedError) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $brandDeletedError
                )
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                                   ->setPath('cap_brand/brand/index');
    }
}
