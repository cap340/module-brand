<?php
declare(strict_types=1);

namespace Cap\Brand\Controller\Adminhtml\Brand;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Cap\Brand\Model\BrandRepository;

//todo: ACL

class Delete extends Action
{
    /**
     * @var BrandRepository
     */
    protected $brandRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param BrandRepository $brandRepository
     */
    public function __construct(
        Context $context,
        BrandRepository $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('brand_id');
        if ($id) {
            try {
                $this->brandRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the Brand.'));

                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (NoSuchEntityException | LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['brand_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Brand to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
