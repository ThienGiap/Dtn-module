<?php
/**
 * Copyright © landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\ChatSystem\Api\Data;

interface MessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Message list.
     * @return \Lof\ChatSystem\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set chat_id list.
     * @param \Lof\ChatSystem\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

