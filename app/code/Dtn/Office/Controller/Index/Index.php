<?php

namespace Dtn\Office\Controller\Department;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Index extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    public function __construct(
        protected Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        echo 'You are viewing url dtn/department/test';
        exit;
    }
}