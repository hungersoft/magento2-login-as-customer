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

namespace HS\LoginAsCustomer\Block\Adminhtml;

use Magento\Backend\Block\Widget\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\AuthorizationInterface;

abstract class GenericLoginAsCustomerButton extends Container
{
    /**
     * Authorization.
     *
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * Core registry.
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * Customer id.
     *
     * @var int
     */
    protected $customerId = null;

    /**
     * @param Context  $context
     * @param Registry $registry
     * @param array    $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AuthorizationInterface $authorization,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->authorization = $authorization;

        parent::__construct($context, $data);
    }

    /**
     * Block constructor adds buttons.
     */
    protected function _construct()
    {
        if ($this->isAllowed() && $this->getCustomerId()) {
            $this->addButton(
                'login_as_customer_button',
                $this->getButtonData()
            );
        }

        parent::_construct();
    }

    /**
     * Return button attributes array.
     */
    public function getButtonData()
    {
        return [
            'label' => __('Login As Customer'),
            'on_click' => sprintf("window.open('%s')", $this->getLoginUrl()),
            'class' => 'view',
            'sort_order' => 20,
        ];
    }

    /**
     * Return product frontend url depends on active store.
     *
     * @return mixed
     */
    private function getLoginUrl()
    {
        return $this->_urlBuilder->getUrl(
            'hs_login_as_customer/adminlogin/login',
            [
                'customer_id' => $this->getCustomerId(),
            ]
        );
    }

    /**
     * Return whether button is allowed to be displayed.
     *
     * @return bool
     */
    private function isAllowed()
    {
        return $this->authorization->isAllowed('HS_LoginAsCustomer::login_as_customer_button');
    }

    /**
     * Get customer id.
     *
     * @var int
     */
    abstract protected function getCustomerId();
}
