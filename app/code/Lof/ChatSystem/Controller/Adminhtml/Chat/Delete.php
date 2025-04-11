<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_ChatSystem
 * @copyright  Copyright (c) 2018 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\ChatSystem\Controller\Adminhtml\Chat;

class Delete extends \Magento\Backend\App\Action
{
    protected $chatFactory;
    protected $chatMessageFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Lof\ChatSystem\Model\ChatFactory $chatFactory
     * @param \Lof\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context, 
        \Lof\ChatSystem\Model\ChatFactory $chatFactory,
        \Lof\ChatSystem\Model\ChatMessageFactory $chatMessageFactory
    )
    {
        $this->chatFactory = $chatFactory;
        $this->chatMessageFactory = $chatMessageFactory;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('chat_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->chatFactory->create();
                $model->load($id);
                $model->delete();

                $collection = $this->chatMessageFactory->create()->getCollection();
                $collection->addFieldToFilter("chat_id", $id);
                foreach ($collection as $chatMessage) {
                    $chatMessage->delete();
                }

                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Chat.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['chat_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Chat to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

