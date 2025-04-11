<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface MessageRepositoryInterface
{

    /**
     * Save Message
     * @param \Lof\ChatSystem\Api\Data\MessageInterface $message
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\ChatSystem\Api\Data\MessageInterface $message
    );

    /**
     * Retrieve Message
     * @param string $messageId
     * @return \Lof\ChatSystem\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($messageId);

    /**
     * Retrieve Message matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\ChatSystem\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Message
     * @param \Lof\ChatSystem\Api\Data\MessageInterface $message
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\ChatSystem\Api\Data\MessageInterface $message
    );

    /**
     * Delete Message by ID
     * @param string $messageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($messageId);
}

