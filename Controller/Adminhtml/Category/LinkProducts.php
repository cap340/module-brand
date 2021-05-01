<?php

namespace Cap\Brand\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;

//todo: remove after test complete

class LinkProducts extends Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
