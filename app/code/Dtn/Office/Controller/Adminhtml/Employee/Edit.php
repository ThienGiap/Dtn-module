<?php

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Dtn\Office\Api\EmployeeRepositoryInterface;
use Dtn\Office\Model\EmployeeFactory;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dtn_Office::save';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var EmployeeRepositoryInterface
     */
    protected $employeeRepository;

    protected $employeeFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeFactory $employeeFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->employeeRepository = $employeeRepository;
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dtn_Office::dtn_manager');
        return $resultPage;
    }

    /**
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('employee_id');

        // 2. Initial checking
        if ($id) {
            $employee = $this->employeeRepository->getById($id);
            if (!$employee->getId()) {
                $this->messageManager->addError(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $employee = $this->employeeFactory->create();
        }

        $this->_coreRegistry->register('employee', $employee);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Employee'));
        $resultPage->getConfig()->getTitle()
            ->prepend($employee->getId() ? __('Edit Employee') : __('New Employee'));

        return $resultPage;
    }
}
