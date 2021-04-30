<?php

namespace Cap\Brand\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;

class LinkProducts extends Action
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
