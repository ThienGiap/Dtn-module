<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dtn\Office\Block\Adminhtml\Department\Edit;

use Magento\Backend\Block\Widget\Context;
use Dtn\Office\Model\DepartmentFactory;

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
     * @var DepartmentFactory
     */
    protected $departmentFactory;

    /**
     * @param Context $context
     * @param DepartmentFactory $departmentFactory
     */
    public function __construct(
        Context $context,
        DepartmentFactory $departmentFactory
    ) {
        $this->context = $context;
        $this->departmentFactory = $departmentFactory;
    }

    /**
     * Return CMS page ID
     *
     * @return int|null
     */
    public function getDepartmentId()
    {
        $id = $this->context->getRequest()->getParam('department_id');
        $department = $this->departmentFactory->create()->load($id);
        if ($department->getId())
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
