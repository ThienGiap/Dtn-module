<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 *
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\ChatSystem\Controller\Adminhtml\Chat;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Clear extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    protected $helper;

    protected $chatMessageFactory;

    protected $_date;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Lof\ChatSystem\Helper\Data $helper
     * @param \Lof\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Lof\ChatSystem\Helper\Data $helper,
        \Lof\ChatSystem\Model\ChatMessageFactory $chatMessageFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        parent::__construct($context);
        $this->helper = $helper;
        $this->_date = $date;
        $this->resultPageFactory = $resultPageFactory;
        $this->chatMessageFactory = $chatMessageFactory;
    }
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_ChatSystem::chat');
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
       /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();   
        try {
            // init model and delete
            $collection = $this->chatMessageFactory->create()->getCollection();
            $clean_older_day = $this->helper->getConfig("system/clean_older_day");
            if($clean_older_day){
                $current_date = $this->_date->gmtDate();
                $currentDateTime = strtotime($current_date);
                $clean_older_day = '- '.(int)$clean_older_day.' days';//2021-05-20 04:35:35
                $olderDate = date('Y-m-d H:i:s',strtotime($clean_older_day, $currentDateTime));
                $collection->addFieldToFilter('created_at', ['lteq' => $olderDate]);
            }
            $totals = $collection->count();
            foreach ($collection as $key => $model) {
                $model->delete();
             }
            // display success message
            $this->messageManager->addSuccess(__('You clear the message chat. Clean %1 records', $totals));
            // go to grid
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            // display error message
            $this->messageManager->addError($e->getMessage());
            // go back to edit form
            return $resultRedirect->setPath('*/*/index');
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a message chat to clear.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
