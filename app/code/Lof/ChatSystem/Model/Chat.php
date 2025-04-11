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
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\ChatSystem\Model;

use Lof\ChatSystem\Api\Data\ChatInterface;
use Lof\ChatSystem\Api\Data\ChatInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
/**
 * CMS block model
 *
 * @method \Magento\Cms\Model\ResourceModel\Block _getResource()
 * @method \Magento\Cms\Model\ResourceModel\Block getResource()
 */
class Chat extends \Magento\Framework\Model\AbstractModel
{	
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $chatDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'lof_chatsystem_chat';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ChatInterfaceFactory $chatDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Lof\ChatSystem\Model\ResourceModel\Chat $resource
     * @param \Lof\ChatSystem\Model\ResourceModel\Chat\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ChatInterfaceFactory $chatDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Lof\ChatSystem\Model\ResourceModel\Chat $resource,
        \Lof\ChatSystem\Model\ResourceModel\Chat\Collection $resourceCollection,
        array $data = []
    ) {
        $this->chatDataFactory = $chatDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Retrieve chat model with chat data
     * @return ChatInterface
     */
    public function getDataModel()
    {
        $chatData = $this->getData();
        
        $chatDataObject = $this->chatDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $chatDataObject,
            $chatData,
            ChatInterface::class
        );
        
        return $chatDataObject;
    }
}
