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
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\ChatSystem\Controller\Adminhtml\Chat;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Display Hello on screen
 */
class Msglog extends \Magento\Framework\App\Action\Action
{
    protected $_cacheTypeList;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Lof\ChatSystem\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    protected $_message;

    protected $chat;
    protected $_chatModelFactory;

    protected $resultPageFactory;
    protected $_coreRegistry;
    protected $_customerSession;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\ChatSystem\Helper\Data $helper,
        \Lof\ChatSystem\Model\ChatMessage $message,
        \Lof\ChatSystem\Model\Chat $chat,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, 
        \Magento\Customer\Model\Session $customerSession,
        \Lof\ChatSystem\Model\ChatFactory $chatModelFactory
    ) {
        $this->chat = $chat;
        $this->resultPageFactory    = $resultPageFactory;
        $this->_helper              = $helper;
        $this->_message             = $message;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry        = $registry;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_customerSession     = $customerSession;
        $this->_request             = $context->getRequest();
        $this->_chatModelFactory    = $chatModelFactory;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    { 
        $id = $this->getRequest()->getParam('chat_id');
        $chat = $this->_chatModelFactory->create()->load($id);

        if($this->_customerSession->getCustomer()->getEmail()) {
            $message = $this->_message->getCollection()->addFieldToFilter('customer_email',$this->_customerSession->getCustomer()->getEmail());
        } else {
           $message = $this->_message->getCollection()->addFieldToFilter('chat_id',$id); 
        }

        foreach ($message->getData() as $key => $_message) {

            $date_sent = $_message['created_at'];
            $day_sent = substr($date_sent, 8, 2); 
            $month_sent = substr($date_sent, 5, 2); 
            $year_sent = substr($date_sent, 0, 4); 
            $hour_sent = substr($date_sent, 11, 2); 
            $min_sent = substr($date_sent, 14, 2); 
            $body_msg = $this->_helper->xss_clean($_message['body_msg']);
            if ($_message['user_id'])
            {
                echo '
                    <div class="msg-user">
                        <p>'.$body_msg.'</p>
                        <div class="info-msg-user">
                            '.__("You").'
                        </div>
                    </div>
                    
                ';
            } else {
                echo '
                <div class="msg">
                    <p>'.$body_msg.'</p>
                    <div class="info-msg">';
                    if($chat->getData('ip')) {
                        echo __('Guest');
                    } else {
                        echo $_message['customer_name'];
                    }
                echo '</div>
                </div>
            ';
            }
        }
        exit;
          
    }
}