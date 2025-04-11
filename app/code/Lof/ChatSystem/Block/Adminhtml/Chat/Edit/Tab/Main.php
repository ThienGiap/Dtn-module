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
namespace Lof\ChatSystem\Block\Adminhtml\Chat\Edit\Tab;

class Main extends \Magento\Framework\View\Element\Template
{
     /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    protected $_template = 'Lof_ChatSystem::chat/chat.phtml';

    protected $_columnDate = 'main_table.created_at';

      /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    protected $authSession;

    protected $messsage;

    protected $_chatModelFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Lof\ChatSystem\Model\ChatMessage $messsage,
        \Lof\ChatSystem\Model\ChatFactory $chatModelFactory
    ) {
        parent::__construct($context);
        $this->_coreRegistry = $registry;
        $this->formKey   = $context->getFormKey();
        $this->authSession = $authSession;
        $this->messsage = $messsage;
        $this->_chatModelFactory = $chatModelFactory;
    }

    public function getCurrentChat() {
        return $this->_coreRegistry->registry('lofchatsystem_chat');
    }
    public function getFormKey() {
        return $this->formKey->getFormKey();
    }

    public function getUser() {
        $user = $this->authSession->getUser();
        return $user;
    }
    public function isRead() {
        $chat = $this->_chatModelFactory->create()->load($this->getCurrentChat()->getData('chat_id'));
        //$messsage = $objectManager->create('Lof\ChatSystem\Model\ChatMessage')->load()->getCollection(); 
        $messsage = $this->messsage->getCollection()->addFieldToFilter('chat_id',$this->getCurrentChat()->getData('chat_id'))->addFieldToFilter('is_read',1);
        foreach ($messsage as $key => $_messsage) {
            $_messsage->setData('is_read',0)->save();
        }
        
        $chat->setData('is_read',0)->save();

        return;
    }
}
