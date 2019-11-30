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

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use HS\LoginAsCustomer\Helper\Data as LoginAsCustomerHelper;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Url;

class Login extends Action
{
    /**
     * @var LoginAsCustomerHelper
     */
    private $helper;

    /**
     * @var CustomerSession
     */
    private $customerSession;

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
     * Token Model.
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    /**
     * @param Context               $context
     * @param LoginAsCustomerHelper $helper
     * @param CustomerSession       $customerSession
     * @param CustomerFactory       $customerFactory
     * @param StoreManagerInterface $storeManager
     * @param TokenModelFactory     $tokenModelFactory
     * @param Url                   $url
     */
    public function __construct(
        Context $context,
        LoginAsCustomerHelper $helper,
        CustomerSession $customerSession,
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        TokenModelFactory $tokenModelFactory,
        Url $url
    ) {
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->tokenModelFactory = $tokenModelFactory;

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
        if (!$storeId && $this->helper->isEnabledManualStoreviewSelection()) {
            return $resultRedirect->setPath(
                'hs_login_as_customer/adminlogin/storeview',
                [
                    'customer_id' => $customerId,
                ]
            );
        }

        $customer = $this->customerFactory->create()->load($customerId);
        if (!$customer->getId()) {
            $this->messageManager->addErrorMessage(__(
                'Customer with ID no longer exists'
            ));

            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        $storeId = $storeId ?? $customer->getStoreId();
        if ($storeId) {
            $store = $this->storeManager->getStore($storeId);
        } else {
            $store = $this->storeManager->getDefaultStoreView();
        }

        $this->customerSession->setAdminLoginCustomerId($customer->getId());

        return $resultRedirect->setUrl($this->url->setScope($store)->getUrl('hs_login_as_customer/login'));
    }
}
