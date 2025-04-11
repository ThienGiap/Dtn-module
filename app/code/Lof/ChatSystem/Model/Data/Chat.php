<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Model\Data;

use Lof\ChatSystem\Api\Data\ChatInterface;

class Chat extends \Magento\Framework\Api\AbstractExtensibleObject implements ChatInterface
{

    /**
     * Get chat_id
     * @return string|null
     */
    public function getChatId()
    {
        return $this->_get(self::CHAT_ID);
    }

    /**
     * Set chat_id
     * @param string $chatId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setChatId($chatId)
    {
        return $this->setData(self::CHAT_ID, $chatId);
    }

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId()
    {
        return $this->_get(self::USER_ID);
    }

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\ChatSystem\Api\Data\ChatExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\ChatSystem\Api\Data\ChatExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\ChatSystem\Api\Data\ChatExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId()
    {
        return $this->_get(self::SELLER_ID);
    }

    /**
     * Set seller_id
     * @param string $sellerId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setSellerId($sellerId)
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->_get(self::CUSTOMER_EMAIL);
    }

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get customer_name
     * @return string|null
     */
    public function getCustomerName()
    {
        return $this->_get(self::CUSTOMER_NAME);
    }

    /**
     * Set customer_name
     * @param string $customerName
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
    }

    /**
     * Get user_name
     * @return string|null
     */
    public function getUserName()
    {
        return $this->_get(self::USER_NAME);
    }

    /**
     * Set user_name
     * @param string $userName
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setUserName($userName)
    {
        return $this->setData(self::USER_NAME, $userName);
    }

    /**
     * Get is_read
     * @return string|null
     */
    public function getIsRead()
    {
        return $this->_get(self::IS_READ);
    }

    /**
     * Set is_read
     * @param string $isRead
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setIsRead($isRead)
    {
        return $this->setData(self::IS_READ, $isRead);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->_get(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get ip
     * @return string|null
     */
    public function getIp()
    {
        return $this->_get(self::IP);
    }

    /**
     * Set ip
     * @param string $ip
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setIp($ip)
    {
        return $this->setData(self::IP, $ip);
    }

    /**
     * Get current_url
     * @return string|null
     */
    public function getCurrentUrl()
    {
        return $this->_get(self::CURRENT_URL);
    }

    /**
     * Set current_url
     * @param string $currentUrl
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setCurrentUrl($currentUrl)
    {
        return $this->setData(self::CURRENT_URL, $currentUrl);
    }

    /**
     * Get number_message
     * @return string|null
     */
    public function getNumberMessage()
    {
        return $this->_get(self::NUMBER_MESSAGE);
    }

    /**
     * Set number_message
     * @param string $numberMessage
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setNumberMessage($numberMessage)
    {
        return $this->setData(self::NUMBER_MESSAGE, $numberMessage);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get answered
     * @return string|null
     */
    public function getAnswered()
    {
        return $this->_get(self::ANSWERED);
    }

    /**
     * Set answered
     * @param string $answered
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     */
    public function setAnswered($answered)
    {
        return $this->setData(self::ANSWERED, $answered);
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->_get(self::SESSION_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setSessionId($session_id)
    {
        return $this->setData(self::SESSION_ID, $session_id);
    }
}

