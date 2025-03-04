<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Delete CMS page action.
 */
class Delete extends \Magento\Backend\App\Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dtn_Office::delete';

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('department_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Dtn\Office\Model\Department');
                $model->load($id);               
                $id = $model->getId();
                $model->delete();
                
                // display success message
                $this->messageManager->addSuccess(__('The department has been deleted.'));
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['department_id' => $id]);
            }
        }
        
        // display error message
        $this->messageManager->addError(__('We can\'t find a department to delete.'));
        
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
