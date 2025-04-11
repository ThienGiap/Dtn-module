<?php

namespace Dtn\Office\Block\DtnWidget;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Theme\Block\Html\Pager;

class EmployeeWidget extends Template implements BlockInterface
{

    protected $employeeCollectionFactory;

    public function __construct(
        Template\Context $context,
        array $data,
        CollectionFactory $employeeCollectionFactory
    ) {
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

        // Pagination setup
        $page = (int)$this->getRequest()->getParam('p', 1);
        $pageSize = (int)$this->getRequest()->getParam('limit', 5);

        $collection->getSelect()->joinLeft(
            ['dept' => 'dtn_department'],
            'main_table.department_id = dept.department_id',
            ['department_name' => 'dept.name']
        );

        $collection->setOrder('employee_id', 'DESC');

        $collection->setPageSize($pageSize)->setCurPage($page);

        // Get enabled images
        $employees = $collection->getData();

        // Set data
        $this->setData('employees', $employees);
        $this->setData(
            'mediaURL',
            $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'dtn/employee/images/'
        );

        // Return to View
        return parent::_beforeToHtml();
    }

    public function getPagerHtml()
    {
        $pager = $this->getLayout()->createBlock(Pager::class, 'dtn.employee.pager');
        $pager->setAvailableLimit([5 => 5, 10 => 10, 20 => 20, 50 => 50]);
        $pager->setCollection($this->employeeCollectionFactory->create());
        return $pager->toHtml();
    }
}
