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
use Dtn\Office\Api\EmployeeRepositoryInterface;

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

    protected $employeeRepository;

    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        EmployeeFactory $employeeFactory,
        EmployeeRepositoryInterface $employeeRepository,
        \Magento\Framework\Registry $registry
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->employeeFactory = $employeeFactory;
        $this->employeeRepository = $employeeRepository;
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
                $data = $postItems[(string)$employeeId];
                $email = $data['email'] ?? null;

                // Check if email already exists for another employee
                $existingEmployee = $this->employeeRepository->getByEmail($email);
                if ($existingEmployee && $existingEmployee->getId() != $employeeId) {
                    throw new \Exception(__('Email "%1" is already exists.', $email));
                }

                // Load employee using repository
                $employee = $this->employeeRepository->getById($employeeId);

                // Set data and save via repository
                $employee->setData($data);
                $this->employeeRepository->save($employee);
            } catch (\Exception $e) {
                $messages[] = $e->getMessage();
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

}
