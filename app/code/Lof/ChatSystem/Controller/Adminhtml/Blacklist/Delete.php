<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 *
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Controller\Adminhtml\Blacklist;

class Delete extends \Lof\ChatSystem\Controller\Adminhtml\Blacklist
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('blacklist_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->blacklistFactory->create();
                $model->load($id);
                $model->delete();
                // display success blacklist
                $this->messageManager->addSuccess(__('You deleted the blacklist.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error blacklist
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/', ['blacklist_id' => $id]);
            }
        }
        // display error blacklist
        $this->messageManager->addError(__('We can\'t find a blacklist to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
     /**
      * {@inheritdoc}
      */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_ChatSystem::blacklist_delete');
    }
}
