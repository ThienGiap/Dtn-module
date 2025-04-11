<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Api\Data;

interface MessageInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CUSTOMER_EMAIL = 'customer_email';
    const CREATED_AT = 'created_at';
    const USER_NAME = 'user_name';
    const CUSTOMER_ID = 'customer_id';
    const IS_READ = 'is_read';
    const CUSTOMER_NAME = 'customer_name';
    const MESSAGE_ID = 'message_id';
    const BODY_MSG = 'body_msg';
    const SELLER_ID = 'seller_id';
    const CHAT_ID = 'chat_id';
    const NAME = 'name';
    const USER_ID = 'user_id';
    const UPDATED_AT = 'updated_at';
    const IP = 'ip';
    const CURRENT_URL = 'current_url';


    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set message_id
     * @param string $messageId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setMessageId($messageId);

    /**
     * Get chat_id
     * @return string|null
     */
    public function getChatId();

    /**
     * Set chat_id
     * @param string $chatId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setChatId($chatId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\ChatSystem\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\ChatSystem\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\ChatSystem\Api\Data\MessageExtensionInterface $extensionAttributes
    );

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();

    /**
     * Set seller_id
     * @param string $sellerId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setSellerId($sellerId);

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId();

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setUserId($userId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get customer_name
     * @return string|null
     */
    public function getCustomerName();

    /**
     * Set customer_name
     * @param string $customerName
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setCustomerName($customerName);

    /**
     * Get is_read
     * @return string|null
     */
    public function getIsRead();

    /**
     * Set is_read
     * @param string $isRead
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setIsRead($isRead);

    /**
     * Get user_name
     * @return string|null
     */
    public function getUserName();

    /**
     * Set user_name
     * @param string $userName
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setUserName($userName);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setName($name);

    /**
     * Get body_msg
     * @return string|null
     */
    public function getBodyMsg();

    /**
     * Set body_msg
     * @param string $bodyMsg
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setBodyMsg($bodyMsg);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get ip
     * @return string|null
     */
    public function getIp();

    /**
     * Set ip
     * @param string $ip
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setIp($ip);

    /**
     * Get current_url
     * @return string|null
     */
    public function getCurrentUrl();

    /**
     * Set current_url
     * @param string $currentUrl
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCurrentUrl($currentUrl);
}

