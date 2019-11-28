<?php
/**
 * Copyright 2019 Hungersoft (http://www.hungersoft.com).
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace HS\LoginAsCustomer\Model;

use HS\LoginAsCustomer\Api\Data\AdminLoginInterfaceFactory;
use HS\LoginAsCustomer\Api\Data\AdminLoginSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use HS\LoginAsCustomer\Model\ResourceModel\AdminLogin as ResourceAdminLogin;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use HS\LoginAsCustomer\Model\ResourceModel\AdminLogin\CollectionFactory as AdminLoginCollectionFactory;
use HS\LoginAsCustomer\Api\AdminLoginRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class AdminLoginRepository implements AdminLoginRepositoryInterface
{
    protected $dataObjectHelper;

    protected $adminLoginCollectionFactory;

    private $storeManager;

    protected $searchResultsFactory;

    protected $dataObjectProcessor;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $resource;

    protected $adminLoginFactory;

    protected $dataAdminLoginFactory;

    /**
     * @param ResourceAdminLogin                      $resource
     * @param AdminLoginFactory                       $adminLoginFactory
     * @param AdminLoginInterfaceFactory              $dataAdminLoginFactory
     * @param AdminLoginCollectionFactory             $adminLoginCollectionFactory
     * @param AdminLoginSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper                        $dataObjectHelper
     * @param DataObjectProcessor                     $dataObjectProcessor
     * @param StoreManagerInterface                   $storeManager
     * @param CollectionProcessorInterface            $collectionProcessor
     * @param JoinProcessorInterface                  $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter           $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceAdminLogin $resource,
        AdminLoginFactory $adminLoginFactory,
        AdminLoginInterfaceFactory $dataAdminLoginFactory,
        AdminLoginCollectionFactory $adminLoginCollectionFactory,
        AdminLoginSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->adminLoginFactory = $adminLoginFactory;
        $this->adminLoginCollectionFactory = $adminLoginCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAdminLoginFactory = $dataAdminLoginFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \HS\LoginAsCustomer\Api\Data\AdminLoginInterface $adminLogin
    ) {
        /* if (empty($adminLogin->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $adminLogin->setStoreId($storeId);
        } */

        $adminLoginData = $this->extensibleDataObjectConverter->toNestedArray(
            $adminLogin,
            [],
            \HS\LoginAsCustomer\Api\Data\AdminLoginInterface::class
        );

        $adminLoginModel = $this->adminLoginFactory->create()->setData($adminLoginData);

        try {
            $this->resource->save($adminLoginModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the adminLogin: %1',
                $exception->getMessage()
            ));
        }

        return $adminLoginModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($adminLoginId)
    {
        $adminLogin = $this->adminLoginFactory->create();
        $this->resource->load($adminLogin, $adminLoginId);
        if (!$adminLogin->getId()) {
            throw new NoSuchEntityException(__('AdminLogin with id "%1" does not exist.', $adminLoginId));
        }

        return $adminLogin->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->adminLoginCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \HS\LoginAsCustomer\Api\Data\AdminLoginInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \HS\LoginAsCustomer\Api\Data\AdminLoginInterface $adminLogin
    ) {
        try {
            $adminLoginModel = $this->adminLoginFactory->create();
            $this->resource->load($adminLoginModel, $adminLogin->getAdminloginId());
            $this->resource->delete($adminLoginModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the AdminLogin: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($adminLoginId)
    {
        return $this->delete($this->get($adminLoginId));
    }
}
