<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Solwin\Contactwidget\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ContactAdditionalRepositoryInterface
{

    /**
     * Save ContactAdditional
     * @param \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface $contactAdditional
     * @return \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface $contactAdditional
    );

    /**
     * Retrieve ContactAdditional
     * @param string $contactadditionalId
     * @return \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($contactadditionalId);

    /**
     * Retrieve ContactAdditional matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Solwin\Contactwidget\Api\Data\ContactAdditionalSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete ContactAdditional
     * @param \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface $contactAdditional
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Solwin\Contactwidget\Api\Data\ContactAdditionalInterface $contactAdditional
    );

    /**
     * Delete ContactAdditional by ID
     * @param string $contactadditionalId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($contactadditionalId);
}

