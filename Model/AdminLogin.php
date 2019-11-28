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
use Magento\Framework\Api\DataObjectHelper;
use HS\LoginAsCustomer\Api\Data\AdminLoginInterface;

class AdminLogin extends \Magento\Framework\Model\AbstractModel
{
    protected $dataObjectHelper;

    protected $_eventPrefix = 'hs_login_as_customer_adminlogin';
    protected $adminloginDataFactory;

    /**
     * @param \Magento\Framework\Model\Context                              $context
     * @param \Magento\Framework\Registry                                   $registry
     * @param AdminLoginInterfaceFactory                                    $adminloginDataFactory
     * @param DataObjectHelper                                              $dataObjectHelper
     * @param \HS\LoginAsCustomer\Model\ResourceModel\AdminLogin            $resource
     * @param \HS\LoginAsCustomer\Model\ResourceModel\AdminLogin\Collection $resourceCollection
     * @param array                                                         $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        AdminLoginInterfaceFactory $adminloginDataFactory,
        DataObjectHelper $dataObjectHelper,
        \HS\LoginAsCustomer\Model\ResourceModel\AdminLogin $resource,
        \HS\LoginAsCustomer\Model\ResourceModel\AdminLogin\Collection $resourceCollection,
        array $data = []
    ) {
        $this->adminloginDataFactory = $adminloginDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve adminlogin model with adminlogin data.
     *
     * @return AdminLoginInterface
     */
    public function getDataModel()
    {
        $adminloginData = $this->getData();

        $adminloginDataObject = $this->adminloginDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $adminloginDataObject,
            $adminloginData,
            AdminLoginInterface::class
        );

        return $adminloginDataObject;
    }
}
