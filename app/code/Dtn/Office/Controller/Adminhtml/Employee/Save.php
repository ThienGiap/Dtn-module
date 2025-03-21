<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Dtn\Office\Api\EmployeeRepositoryInterface;
use Dtn\Office\Model\EmployeeFactory;

/**
 * Save CMS page action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Dtn_Office::save';

    protected $dataProcessor;
    protected $dataPersistor;
    protected $employeeRepository;
    protected $employeeFactory;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeFactory $employeeFactory
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            // Optimize data
            if (empty($data['employee_id'])) {
                $data['employee_id'] = null;
            }
            if (empty($data['images'])) {
                $data['images'] = null;
            } elseif ($data['images'][0] && $data['images'][0]['name']) {
                $data['image'] = $data['images'][0]['name'];
            } else {
                $data['image'] = null;
            }

            $id = $this->getRequest()->getParam('employee_id');
            // Load existing employee or create new
            if ($id) {
                $employee = $this->employeeRepository->getById($id);
            } else {
                $employee = $this->employeeFactory->create();
            }

            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                $this->dataPersistor->set('employee', $data);
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['employee_id' => $employee->getId(), '_current' => true]);
            }

            // Update employee
            $employee->setData($data);

            // Save data to database
            try {
                $this->employeeRepository->save($employee);
                $this->messageManager->addSuccess(__('You saved the employee.'));
                $this->dataPersistor->clear('employee');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['employee_id' => $employee->getId(), '_current' => true]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the employee.'));
            }

            $this->dataPersistor->set('employee', $data);
            return $resultRedirect->setPath('*/*/edit', ['employee_id' => $this->getRequest()->getParam('employee_id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}
