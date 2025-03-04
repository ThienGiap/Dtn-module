<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Dtn\Office\Api\EmployeeRepositoryInterface;
use Magento\Backend\App\Action;

/**
 * Delete CMS page action.
 */
class Delete extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dtn_Office::delete';

    /**
     * @var EmployeeRepositoryInterface
     */
    protected $employeeRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        EmployeeRepositoryInterface $employeeRepository,
    ) {
        $this->employeeRepository = $employeeRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('employee_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $this->employeeRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccess(__('The employee has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['employee_id' => $id]);
            }
        }

        // display error message
        $this->messageManager->addError(__('We can\'t find a employee to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
