<?php

namespace Dtn\Office\Block\DtnWidget;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;

class EmployeeWidget extends Template implements BlockInterface
{

    protected $employeeCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        CollectionFactory $employeeCollectionFactory)
    {
        $this->setTemplate('widget.phtml');
        $this->employeeCollectionFactory = $employeeCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Set data to View
     */
    protected function _beforeToHtml()
    {
        // Init collection
        $collection = $this->employeeCollectionFactory->create();

        $collection->getSelect()->joinLeft(
            ['dept' => 'dtn_department'],
            'main_table.department_id = dept.department_id',
            ['department_name' => 'dept.name']
        );

        $collection->setOrder('employee_id', 'DESC');

        // Get enabled images
        $employees = $collection->getData();

        // Set data
        $this->setData('employees', $employees);
        $this->setData('mediaURL', $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'dtn/employee/images/');

        // Return to View
        return parent::_beforeToHtml();
    }
}