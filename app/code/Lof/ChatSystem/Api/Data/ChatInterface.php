<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Api\Data;

interface ChatInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ANSWERED = 'answered';
    const CUSTOMER_EMAIL = 'customer_email';
    const USER_NAME = 'user_name';
    const CREATED_AT = 'created_at';
    const CUSTOMER_ID = 'customer_id';
    const IS_READ = 'is_read';
    const IP = 'ip';
    const CUSTOMER_NAME = 'customer_name';
    const CURRENT_URL = 'current_url';
    const CHAT_ID = 'chat_id';
    const SELLER_ID = 'seller_id';
    const STATUS = 'status';
    const USER_ID = 'user_id';
    const UPDATED_AT = 'updated_at';
    const NUMBER_MESSAGE = 'number_message';
    const SESSION_ID = 'session_id';

    /**
     * Get chat_id
     * @return string|null
     */
    public function getChatId();

    /**
     * Set chat_id
     * @param string $chatId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setChatId($chatId);

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId();

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setUserId($userId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\ChatSystem\Api\Data\ChatExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\ChatSystem\Api\Data\ChatExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\ChatSystem\Api\Data\ChatExtensionInterface $extensionAttributes
    );

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();

    /**
     * Set seller_id
     * @param string $sellerId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setSellerId($sellerId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
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
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
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
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCustomerName($customerName);

    /**
     * Get user_name
     * @return string|null
     */
    public function getUserName();

    /**
     * Set user_name
     * @param string $userName
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setUserName($userName);

    /**
     * Get is_read
     * @return string|null
     */
    public function getIsRead();

    /**
     * Set is_read
     * @param string $isRead
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setIsRead($isRead);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
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
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
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

    /**
     * Get number_message
     * @return string|null
     */
    public function getNumberMessage();

    /**
     * Set number_message
     * @param string $numberMessage
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setNumberMessage($numberMessage);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setStatus($status);

    /**
     * Get answered
     * @return string|null
     */
    public function getAnswered();

    /**
     * Set answered
     * @param string $answered
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setAnswered($answered);

    /**
     * Get session_id
     * @return string|null
     */
    public function getSessionId();

    /**
     * Set session_id
     * @param string $session_id
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setSessionId($session_id);
}

