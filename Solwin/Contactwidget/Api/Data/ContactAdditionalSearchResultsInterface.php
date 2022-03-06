<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Solwin\Contactwidget\Api\Data;

interface ContactAdditionalSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get ContactAdditional list.
     * @return \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

