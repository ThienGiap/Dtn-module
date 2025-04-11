<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Model;

use Lof\ChatSystem\Api\Data\MessageInterfaceFactory;
use Lof\ChatSystem\Api\Data\MessageSearchResultsInterfaceFactory;
use Lof\ChatSystem\Api\MessageRepositoryInterface;
use Lof\ChatSystem\Model\ResourceModel\ChatMessage as ResourceMessage;
use Lof\ChatSystem\Model\ResourceModel\ChatMessage\CollectionFactory as MessageCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Lof\ChatSystem\Model\ChatMessageFactory as MessageFactory;

class MessageRepository implements MessageRepositoryInterface
{

    protected $resource;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $messageFactory;

    private $storeManager;

    protected $dataMessageFactory;

    protected $dataObjectHelper;

    protected $messageCollectionFactory;

    protected $dataObjectProcessor;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    /**
     * @param ResourceMessage $resource
     * @param MessageFactory $messageFactory
     * @param MessageInterfaceFactory $dataMessageFactory
     * @param MessageCollectionFactory $messageCollectionFactory
     * @param MessageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceMessage $resource,
        MessageFactory $messageFactory,
        MessageInterfaceFactory $dataMessageFactory,
        MessageCollectionFactory $messageCollectionFactory,
        MessageSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->messageFactory = $messageFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataMessageFactory = $dataMessageFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Lof\ChatSystem\Api\Data\MessageInterface $message
    ) {
        /* if (empty($message->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $message->setStoreId($storeId);
        } */
        
        $messageData = $this->extensibleDataObjectConverter->toNestedArray(
            $message,
            [],
            \Lof\ChatSystem\Api\Data\MessageInterface::class
        );
        
        $messageModel = $this->messageFactory->create()->setData($messageData);
        
        try {
            $this->resource->save($messageModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the message: %1',
                $exception->getMessage()
            ));
        }
        return $messageModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($messageId)
    {
        $message = $this->messageFactory->create();
        $this->resource->load($message, $messageId);
        if (!$message->getId()) {
            throw new NoSuchEntityException(__('Message with id "%1" does not exist.', $messageId));
        }
        return $message->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->messageCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\ChatSystem\Api\Data\MessageInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Lof\ChatSystem\Api\Data\MessageInterface $message
    ) {
        try {
            $messageModel = $this->messageFactory->create();
            $this->resource->load($messageModel, $message->getMessageId());
            $this->resource->delete($messageModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Message: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($messageId)
    {
        return $this->delete($this->get($messageId));
    }
}

