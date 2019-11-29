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
use Magento\Store\Model\App\Emulation;
use Magento\Framework\AuthorizationInterface;

class LoginAsCustomerButton extends Container
{
    /**
     * Core registry.
     *
     * @var Registry
     */
    private $coreRegistry = null;

    /**
     * App Emulator.
     *
     * @var Emulation
     */
    private $emulation;

    /**
     * Authorization.
     *
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * Order.
     *
     * @var \Magento\Sales|Model|Order
     */
    private $order;

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
        $this->order = $this->getOrder();
        if ($this->order && $this->isAllowed() && $this->order->getCustomerId()) {
            $this->addButton(
                'login_as_customer_button',
                $this->getButtonData()
            );
        }

        parent::_construct();
    }

    /**
     * Get current order.
     *
     * @return \Mage\Sales\Model|Order
     */
    private function getOrder()
    {
        $object = $this->coreRegistry->registry($this->getRegistry());
        if ($this->getRegistry() === 'current_order') {
            return $object;
        }

        return $object->getOrder();
    }

    /**
     * Return button attributes array.
     */
    public function getButtonData()
    {
        return [
            'label' => __('Login As Customer'),
            'on_click' => sprintf("window.open('%s')", $this->_getLoginUrl()),
            'class' => 'view',
            'sort_order' => 20,
        ];
    }
    /**
     * Return product frontend url depends on active store.
     *
     * @return mixed
     */
    private function _getLoginUrl()
    {
        return $this->_urlBuilder->getUrl(
            'hs_login_as_customer/adminlogin/index',
            [
                'customer_id' => $this->order->getCustomerId(),
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
}
