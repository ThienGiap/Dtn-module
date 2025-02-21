<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Dtn\Office\Model\DepartmentFactory;

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
    protected $departmentFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        DepartmentFactory $departmentFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->departmentFactory = $departmentFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);

        foreach (array_keys($postItems) as $departmentId) {
            try {
                $department = $this->departmentFactory->create();
                $department->load($departmentId);
                $department->setData($postItems[(string)$departmentId]);
                $department->save();
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