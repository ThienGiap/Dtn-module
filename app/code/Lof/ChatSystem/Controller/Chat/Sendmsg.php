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
namespace Lof\ChatSystem\Controller\Chat;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Display Hello on screen
 */
class Sendmsg extends \Magento\Framework\App\Action\Action
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

    protected $_chat;

    protected $sender;

    protected $_chatModelFactory;

    protected $httpRequest;

    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    protected $remoteAddress;

    protected $blacklistFactory;

    protected $resultPageFactory;

    protected $_coreRegistry;

    protected $_customerSession;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\ChatSystem\Helper\Data $helper,
        \Lof\ChatSystem\Model\ChatMessage $message,
        \Lof\ChatSystem\Model\Sender $sender,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\ChatSystem\Model\ChatFactory $chatModelFactory,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Magento\Framework\App\Request\Http $httpRequest,
        \Lof\ChatSystem\Model\BlacklistFactory $blacklistFactory
    ) {
        $this->sender = $sender;
        $this->resultPageFactory    = $resultPageFactory;
        $this->_helper              = $helper;
        $this->_message             = $message;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry        = $registry;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_customerSession     = $customerSession;
        $this->_request             = $context->getRequest();
        $this->_chatModelFactory    = $chatModelFactory;
        $this->httpRequest          = $httpRequest;
        $this->remoteAddress        = $remoteAddress;
        $this->blacklistFactory     = $blacklistFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $data = $this->_request->getPostValue();
        $data['is_read'] = 1;
        $data['current_time'] = $this->_helper->getCurrentTime();

        if ($customer_email = $this->_customerSession->getCustomer()->getEmail()) {
            $customer_id = $this->_customerSession->getCustomerId();
            if (!isset($data["customer_id"]) || (empty($data["customer_id"]))) {
                $data["customer_id"] = (int)$customer_id;
            }
            if (!isset($data["customer_email"]) || ($data["customer_email"] != $customer_email)) {
                $data["customer_email"] = $customer_email;
            }
            if (!isset($data["customer_name"]) || (empty($data["customer_name"]))) {
                $data["customer_name"] =  $this->_customerSession->getCustomer()->getData("firstname").' '. $this->_customerSession->getCustomer()->getData("lastname");
            }
        }
        if (empty($data['customer_name'])) {
            $data['customer_name'] = __('Guest');
        }
        $data = $this->_helper->xss_clean_array($data);
        $enable_blacklist = $this->_helper->getConfig('chat/enable_blacklist');
        //check if enabled config blacklist, then check if ip in blacklist, then redirect it to home, else continue action
        if ($enable_blacklist) {
            $client_ip = $this->remoteAddress->getRemoteAddress();
            $blacklist_model = $this->blacklistFactory->create();
            if ($client_ip) {
                $blacklist_model->loadByIp($client_ip);
                if ((0 < $blacklist_model->getId()) && $blacklist_model->getStatus()) {

                    $responseData = [];
                    $responseData['message'] =
                        __('Your IP was blocked in our blacklist. So, we will not allow chat.');
                    $responseData['status'] = false;
                    $this->messageManager->addError(
                        __('Your IP was blocked in our blacklist. So, we will not allow chat.')
                    );
                    $this->getResponse()->representJson(
                        $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
                    );
                    return ;
                }
                if($customer_email = $this->_customerSession->getCustomer()->getEmail()) {
                    $customer_id = $this->_customerSession->getCustomerId();
                    if(!isset($data["customer_id"]) || ($data["customer_id"] != $customer_id)){
                        $data["customer_id"] = (int)$customer_id;
                    }
                    if(!isset($data["customer_email"]) || ($data["customer_email"] != $customer_email)){
                        $data["customer_email"] = $customer_email;
                    }
                    $blacklist_model->loadByCustomerId((int)$customer_id);
                    if ((0 < $blacklist_model->getId()) && $blacklist_model->getStatus()) {
                        $responseData = [];
                        $responseData['message'] =
                            __('Your Account was blocked in our blacklist. So, we will not allow chat.');
                        $responseData['status'] = false;
                        $this->messageManager->addError(
                            __('Your Account was blocked in our blacklist. So, we will not allow chat.')
                        );
                        $this->getResponse()->representJson(
                            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
                        );
                        return ;
                    }
                    $blacklist_model2 = $this->blacklistFactory->create();
                    $blacklist_model2->loadByEmail($customer_email);
                    if ((0 < $blacklist_model2->getId()) && $blacklist_model2->getStatus()) {
                        $responseData = [];
                        $responseData['message'] =
                            __('Your Email Address was blocked in our blacklist. So, we will not allow chat.');
                        $responseData['status'] = false;
                        $this->messageManager->addError(
                            __('Your sEmail Address was blocked in our blacklist. So, we will not allow chat.')
                        );
                        $this->getResponse()->representJson(
                            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
                        );
                        return ;
                    }
                }
            }
        }
        if (!empty($data) && !empty($data['body_msg'])) {

            $responseData = [];
            $message = $this->_message;
            try {
                $isNewChatThread = false;
                $chat_id = $this->_helper->getChatId($this->_chatModelFactory);
                if ($chat_id) {
                    $chat = $this->_chatModelFactory->create()->load((int)$chat_id);
                } else {
                    $chat = $this->_chatModelFactory->create()->load($this->_helper->getIp(), 'ip');
                    $isNewChatThread = true;
                }
                $data['chat_id'] = $chat->getId();
                $number_message = $chat->getData('number_message') + 1;
                $message
                    ->setData($data)
                    ->save();
                $enable_auto_assign_user = $this->_helper->getConfig('system/enable_auto_assign_user');
                $admin_user_id = $this->_helper->getConfig('system/admin_user_id');
                if ($enable_auto_assign_user && $admin_user_id) {
                    $data["user_id"] = (int)$admin_user_id;
                } else {
                    $data["user_id"] = 0;
                }
                $data["store"] = $this->storeManager->getStore()->getName();
                $this->_eventManager->dispatch(
                    'lof_chatsystem_new_message',
                    ['object' => $this, 'request' => $this->getRequest(), 'isNew' => $isNewChatThread, "data" => $data]
                );

                $chat
                    ->setData('user_id', (int)$data["user_id"])
                    ->setData('is_read',1)
                    ->setData('answered',1)
                    ->setData('status',1)
                    ->setData('number_message',$number_message)
                    ->setData('current_url',$data['current_url'])
                    ->setData('ip', $this->_helper->getIp())
                    ->setData('session_id', $this->_helper->getSessionId())
                    ->save();

                $this->_cacheTypeList->cleanType('full_page');

                if ($this->_helper->getConfig('email_settings/enable_email')) {
                    $chatId = $chat->getId();
                    if (!$data['chat_id'] || ($data['chat_id'] != $chatId)) { //only send email at first chat
                        $data['url'] = $data['current_url'];
                        $this->sender->sendEmailChat($data);
                    }
                }
            } catch(\Exception $e) {
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                return;
            }
        }
    }
}
