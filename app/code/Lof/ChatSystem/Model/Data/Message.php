<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Model\Data;

use Lof\ChatSystem\Api\Data\MessageInterface;

class Message extends \Magento\Framework\Api\AbstractExtensibleObject implements MessageInterface
{

    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId()
    {
        return $this->_get(self::MESSAGE_ID);
    }

    /**
     * Set message_id
     * @param string $messageId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setMessageId($messageId)
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
    }

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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setChatId($chatId)
    {
        return $this->setData(self::CHAT_ID, $chatId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\ChatSystem\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\ChatSystem\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\ChatSystem\Api\Data\MessageExtensionInterface $extensionAttributes
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setSellerId($sellerId)
    {
        return $this->setData(self::SELLER_ID, $sellerId);
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setIsRead($isRead)
    {
        return $this->setData(self::IS_READ, $isRead);
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setUserName($userName)
    {
        return $this->setData(self::USER_NAME, $userName);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get body_msg
     * @return string|null
     */
    public function getBodyMsg()
    {
        return $this->_get(self::BODY_MSG);
    }

    /**
     * Set body_msg
     * @param string $bodyMsg
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     */
    public function setBodyMsg($bodyMsg)
    {
        return $this->setData(self::BODY_MSG, $bodyMsg);
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
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
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
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
}

