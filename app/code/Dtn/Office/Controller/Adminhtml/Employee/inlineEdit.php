<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Dtn\Office\Model\EmployeeFactory;

class InlineEdit extends \Magento\Backend\App\Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dtn_Office::save';

    protected $_coreRegistry;
    protected $jsonFactory;
    protected $employeeFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        EmployeeFactory $employeeFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->employeeFactory = $employeeFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);

        foreach (array_keys($postItems) as $employeeId) {
            try {
                $employee = $this->employeeFactory->create();
                $employee->load($employeeId);
                $employee->setData($postItems[(string)$employeeId]);
                $employee->save();
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong');
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}