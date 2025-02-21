<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dtn\Office\Block\Adminhtml\Employee\Edit;

use Magento\Backend\Block\Widget\Context;
use Dtn\Office\Model\EmployeeFactory;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var EmployeeFactory
     */
    protected $employeeFactory;

    /**
     * @param Context $context
     * @param EmployeeFactory $employeeFactory
     */
    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory
    ) {
        $this->context = $context;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getEmployeeId()
    {
        $id = $this->context->getRequest()->getParam('employee_id');
        $banner = $this->employeeFactory->create()->load($id);
        if ($banner->getId())
            return $id;
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
