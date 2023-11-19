<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PoNumberOnCheckout
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PoNumberOnCheckout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

/**
 * class QuoteToOrder
 */
class QuoteToOrder implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        /* @var Order $order */
        $order = $observer->getEvent()->getOrder();

        /* @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        if ($quote->hasData("po_number")) {
            $order->setData(
                "po_number",
                $quote->getData("po_number")
            );
        }
        return $this;
    }
}
