<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ChatRepositoryInterface
{

    /**
     * Save Chat
     * @param \Lof\ChatSystem\Api\Data\ChatInterface $chat
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\ChatSystem\Api\Data\ChatInterface $chat
    );

    /**
     * Retrieve Chat
     * @param string $chatId
     * @return \Lof\ChatSystem\Api\Data\ChatInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($chatId);

    /**
     * Retrieve Chat matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\ChatSystem\Api\Data\ChatSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Chat
     * @param \Lof\ChatSystem\Api\Data\ChatInterface $chat
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\ChatSystem\Api\Data\ChatInterface $chat
    );

    /**
     * Delete Chat by ID
     * @param string $chatId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($chatId);

    /**
     * Admin user send message
     * @param \Lof\ChatSystem\Api\Data\MessageInterface $message
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendAdminChatMessage(\Lof\ChatSystem\Api\Data\MessageInterface $message);

    /**
     * get customer message
     * @param int $customerId
     * @return \Lof\ChatSystem\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMyChat($customerId);

    /**
     * Customer send message
     * @param int $customerId
     * @param \Lof\ChatSystem\Api\Data\MessageInterface $message
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendCustomerChatMessage($customerId, \Lof\ChatSystem\Api\Data\MessageInterface $message);

}

