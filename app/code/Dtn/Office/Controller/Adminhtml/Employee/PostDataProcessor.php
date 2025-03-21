<?php

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory as EmployeeCollectionFactory;

class PostDataProcessor
{

    protected $messageManager;

    protected $employeeCollectionFactory;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        EmployeeCollectionFactory $employeeCollectionFactory
    ) {
        $this->messageManager = $messageManager;
        $this->employeeCollectionFactory = $employeeCollectionFactory;
    }

    // Validate required columns
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'images' => __('Image'),
            'email' => __('Email'),
            'telephone' => __('Telephone'),
        ];
        $errorNo = true;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addError(
                    __('"%1" field is required', $requiredFields[$field])
                );
            }
        }

        if (!$this->isUnique('email', $data['email'], $data['employee_id'] ?? null)) {
            $this->messageManager->addError(__('Email "%1" is already exists.', $data['email']));
            $errorNo = false;
        }

        if (!$this->isUnique('telephone', $data['telephone'], $data['employee_id'] ?? null)) {
            $this->messageManager->addError(__('Phone number "%1" is already exists.', $data['telephone']));
            $errorNo = false;
        }

        return $errorNo;
    }

    private function isUnique($field, $value, $currentId = null)
    {
        $collection = $this->employeeCollectionFactory->create()->addFieldToFilter($field, $value);
        if ($currentId) {
            $collection->addFieldToFilter('employee_id', ['neq' => $currentId]);
        }
        return !$collection->getSize();
    }
}
