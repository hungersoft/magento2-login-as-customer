<?php
/**
 * @category  HS
 *
 * @copyright Copyright (c) 2015 Hungersoft (http://www.hungersoft.com)
 * @license   http://www.hungersoft.com/license.txt Hungersoft General License
 */

namespace HS\LoginAsCustomer\Observer;

use HS\All\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Register implements ObserverInterface
{
    /**
     * @var Data
     */
    private $helper;

    /**
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Register extension.
     *
     * @param  Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->helper->register('HS_LoginAsCustomer', '1.0.0', 'confirm');
    }
}
