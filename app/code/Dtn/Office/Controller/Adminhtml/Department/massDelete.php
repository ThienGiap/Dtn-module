<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Dtn\Office\Model\ResourceModel\Department\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{

    protected $filter;
    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // Get selected collection
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        // Delete collection
        foreach ($collection as $department) {
            $department->delete();
        }

        // Display success message
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        // Redirect to List page
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}