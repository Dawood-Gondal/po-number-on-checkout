<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PoNumberOnCheckout
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PoNumberOnCheckout\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class addingPONumberToExtensionAttributes for adding
 * extension attributes in order(s) get api
 */
class AddingPONumberToExtensionAttributes
{
    private OrderExtensionFactory $extensionFactory;

    /**
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(
        OrderExtensionFactory $extensionFactory
    ) {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $order
    ) {
        $this->loadExtensionAttributes($order);
        return $order;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface   $subject,
        OrderSearchResultInterface $searchResult
    ) {
        $orders = $searchResult->getItems();
        foreach ($orders as $order) {
            $this->loadExtensionAttributes($order);
        }
        return $searchResult;
    }

    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $entity
     * @return void
     */
    public function beforeSave(
        OrderRepositoryInterface $subject,
        OrderInterface           $entity
    ) {
        $extensionAttributes = $entity->getExtensionAttributes() ?: $this->extensionFactory->create();
        if ($extensionAttributes !== null && $extensionAttributes->getPoNumber() !== null) {
            $entity->setPoNumber($extensionAttributes->getPoNumber());
        }
    }

    /**
     * @param $order
     * @return void
     */
    private function loadExtensionAttributes($order)
    {
        $poNumber = $order->getData('po_number');
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ?: $this->extensionFactory->create();
        $extensionAttributes->setPoNumber($poNumber);
        $order->setExtensionAttributes($extensionAttributes);
    }
}
