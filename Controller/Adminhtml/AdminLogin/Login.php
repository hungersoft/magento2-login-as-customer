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

namespace HS\LoginAsCustomer\Controller\Adminhtml\AdminLogin;

use Magento\Framework\Url;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;
use HS\LoginAsCustomer\Api\Data\AdminLoginInterface;
use HS\LoginAsCustomer\Api\AdminLoginRepositoryInterface;
use HS\LoginAsCustomer\Api\Data\AdminLoginInterfaceFactory;
use HS\LoginAsCustomer\Helper\Data as LoginAsCustomerHelper;
use HS\LoginAsCustomer\Model\Session as LoginAsCustomerSession;

class Login extends Action
{
    /**
     * @var LoginAsCustomerHelper
     */
    private $helper;

    /**
     * @var LoginAsCustomerSession
     */
    private $loginAsCustomerSession;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Url
     */
    private $url;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var AdminLoginInterfaceFactory
     */
    private $adminloginDataFactory;

    /**
     * @var AdminLoginRepositoryInterface
     */
    private $adminLoginRepository;

    /**
     * @param Context                       $context
     * @param LoginAsCustomerHelper         $helper
     * @param LoginAsCustomerSession        $loginAsCustomerSession
     * @param CustomerFactory               $customerFactory
     * @param StoreManagerInterface         $storeManager
     * @param Url                           $url
     * @param AdminLoginInterfaceFactory    $adminloginDataFactory
     * @param DataObjectHelper              $dataObjectHelper
     * @param AdminLoginRepositoryInterface $adminLoginRepository
     */
    public function __construct(
        Context $context,
        LoginAsCustomerHelper $helper,
        LoginAsCustomerSession $loginAsCustomerSession,
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        Url $url,
        AdminLoginInterfaceFactory $adminloginDataFactory,
        DataObjectHelper $dataObjectHelper,
        AdminLoginRepositoryInterface $adminLoginRepository
    ) {
        $this->url = $url;
        $this->helper = $helper;
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->loginAsCustomerSession = $loginAsCustomerSession;
        $this->adminloginDataFactory = $adminloginDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->adminLoginRepository = $adminLoginRepository;

        parent::__construct($context);
    }

    /**
     * Index action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$this->helper->isEnabled()) {
            $this->messageManager->addErrorMessage(__(
                'Hungersoft LoginAsCustomer is not enabled.'
            ));

            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        $customerId = $this->getRequest()->getParam('customer_id');
        $storeId = $this->getRequest()->getParam('store_id');
        // if (!$storeId && $this->helper->isEnabledManualStoreviewSelection()) {
        //     return $resultRedirect->setPath(
        //         'hs_login_as_customer/adminlogin/storeview',
        //         [
        //             'customer_id' => $customerId,
        //         ]
        //     );
        // }

        $customer = $this->customerFactory->create()->load($customerId);
        if (!$customer->getId()) {
            $this->messageManager->addErrorMessage(__(
                'Customer with ID no longer exists'
            ));

            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        $this->loginAsCustomerSession->setCustomerId($customer->getId());

        $adminloginData = [
            'admin_user_id' => $this->_auth->getUser()->getId(),
            'customer_id' => $customer->getId(),
        ];

        $adminloginDataObject = $this->adminloginDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $adminloginDataObject,
            $adminloginData,
            AdminLoginInterface::class
        );

        $this->adminLoginRepository->save($adminloginDataObject);

        return $resultRedirect->setUrl(
            $this->url->setScope($this->getStore($customer)
        )->getUrl(
            'hs_login_as_customer/login'
        ));
    }

    /**
     * Get store view to login to.
     *
     * @param Customer $customer
     *
     * @return int
     */
    private function getStore($customer)
    {
        $storeId = $storeId ?? $customer->getStoreId();
        if ($storeId) {
            $store = $this->storeManager->getStore($storeId);
        } else {
            $store = $this->storeManager->getDefaultStoreView();
        }

        return $store;
    }
}
