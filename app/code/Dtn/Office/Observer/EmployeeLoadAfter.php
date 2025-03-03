<?php

namespace Dtn\Office\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class EmployeeLoadAfter implements ObserverInterface
{
    protected $_logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $employee = $observer->getDtnOfficeEmployee();
        if ($employee) {
            $this->_logger->info('Employee loaded: ');
        } else {
            $this->_logger->info('No employee object found');
        }
    }
}