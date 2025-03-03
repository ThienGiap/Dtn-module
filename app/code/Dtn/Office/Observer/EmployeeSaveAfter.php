<?php

namespace Dtn\Office\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Backend\Model\Auth as AuthSession;
use Psr\Log\LoggerInterface;

class EmployeeSaveAfter implements ObserverInterface
{
    protected $_logger;
    protected $authSession;

    public function __construct(LoggerInterface $logger, AuthSession $authSession)
    {
        $this->_logger = $logger;
        $this->authSession = $authSession;
    }

    public function execute(Observer $observer)
    {
        $employee = $observer->getObject();
        $this->_logger->info('Employee after save.');
        // $this->authSession->logout();
    }
}