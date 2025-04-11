<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @chat   Landofcoder
 * @package    Lof_ChatSystem
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\ChatSystem\Controller\Adminhtml\Chat;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Lof\ChatSystem\Model\ResourceModel\ChatMessage\CollectionFactory;
use Lof\ChatSystem\Model\ResourceModel\Chat\CollectionFactory as ChatCollectionFactory;

class MassCleanlog extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    protected $helper;

    protected $_date;

    protected $chatCollectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Lof\ChatSystem\Helper\Data $helper
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param ChatCollectionFactory $chatCollectionFactory
     */
    public function __construct(
        
        Context $context, 
        Filter $filter, 
        CollectionFactory $collectionFactory,
        \Lof\ChatSystem\Helper\Data $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        ChatCollectionFactory $chatCollectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->chatCollectionFactory = $chatCollectionFactory;
        $this->helper = $helper;
        $this->_date = $date;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $chatCollection = $this->filter->getCollection($this->chatCollectionFactory->create());
        $chat_ids = [];
        foreach ($chatCollection as $chat) {
            $chat_ids[] = $chat->getId();
        }
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter("chat_id", ["in" => $chat_ids]);

        $clean_older_day = $this->helper->getConfig("system/clean_older_day");
        if($clean_older_day){
            $current_date = $this->_date->gmtDate();
            $currentDateTime = strtotime($current_date);
            $clean_older_day = '- '.(int)$clean_older_day.' days';//2021-05-20 04:35:35
            $olderDate = date('Y-m-d H:i:s',strtotime($clean_older_day, $currentDateTime));
            $collection->addFieldToFilter('created_at', ['lteq' => $olderDate]);
        }
        $collectionSize = $collection->getSize();
        if($collectionSize){
            foreach ($collection as $chatMessage) {
                $chatMessage->delete();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_ChatSystem::chat_delete');
    }
}
