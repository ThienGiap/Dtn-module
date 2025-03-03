<?php

namespace Dtn\Office\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class EmployeeLoadBefore implements ObserverInterface
{
    protected $_logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $employee = $observer->getObject();
        $this->_logger->info('Employee before load.');
    }
}