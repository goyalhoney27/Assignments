<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Solwin\Contactwidget\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Solwin\Contactwidget\Api\ContactAdditionalRepositoryInterface;
use Solwin\Contactwidget\Api\Data\ContactAdditionalInterface;
use Solwin\Contactwidget\Api\Data\ContactAdditionalInterfaceFactory;
use Solwin\Contactwidget\Api\Data\ContactAdditionalSearchResultsInterfaceFactory;
use Solwin\Contactwidget\Model\ResourceModel\ContactAdditional as ResourceContactAdditional;
use Solwin\Contactwidget\Model\ResourceModel\ContactAdditional\CollectionFactory as ContactAdditionalCollectionFactory;

class ContactAdditionalRepository implements ContactAdditionalRepositoryInterface
{

    /**
     * @var ContactAdditionalCollectionFactory
     */
    protected $contactAdditionalCollectionFactory;

    /**
     * @var ResourceContactAdditional
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ContactAdditional
     */
    protected $searchResultsFactory;

    /**
     * @var ContactAdditionalInterfaceFactory
     */
    protected $contactAdditionalFactory;


    /**
     * @param ResourceContactAdditional $resource
     * @param ContactAdditionalInterfaceFactory $contactAdditionalFactory
     * @param ContactAdditionalCollectionFactory $contactAdditionalCollectionFactory
     * @param ContactAdditionalSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceContactAdditional $resource,
        ContactAdditionalInterfaceFactory $contactAdditionalFactory,
        ContactAdditionalCollectionFactory $contactAdditionalCollectionFactory,
        ContactAdditionalSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->contactAdditionalFactory = $contactAdditionalFactory;
        $this->contactAdditionalCollectionFactory = $contactAdditionalCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        ContactAdditionalInterface $contactAdditional
    ) {
        try {
            $this->resource->save($contactAdditional);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the contactAdditional: %1',
                $exception->getMessage()
            ));
        }
        return $contactAdditional;
    }

    /**
     * @inheritDoc
     */
    public function get($contactAdditionalId)
    {
        $contactAdditional = $this->contactAdditionalFactory->create();
        $this->resource->load($contactAdditional, $contactAdditionalId);
        if (!$contactAdditional->getId()) {
            throw new NoSuchEntityException(__('ContactAdditional with id "%1" does not exist.', $contactAdditionalId));
        }
        return $contactAdditional;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->contactAdditionalCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(
        ContactAdditionalInterface $contactAdditional
    ) {
        try {
            $contactAdditionalModel = $this->contactAdditionalFactory->create();
            $this->resource->load($contactAdditionalModel, $contactAdditional->getContactadditionalId());
            $this->resource->delete($contactAdditionalModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the ContactAdditional: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($contactAdditionalId)
    {
        return $this->delete($this->get($contactAdditionalId));
    }
}

