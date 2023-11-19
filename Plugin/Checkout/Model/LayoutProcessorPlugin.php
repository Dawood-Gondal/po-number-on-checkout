<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PoNumberOnCheckout
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PoNumberOnCheckout\Plugin\Checkout\Model;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

/**
 *  added purchase order field before place order button
 */
class LayoutProcessorPlugin
{
    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ) {
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']
        ['payments-list']['children']['before-place-order']['children']['po'] = [
            'component' => 'M2Commerce_PoNumberOnCheckout/js/view/poNumber',
            'dataScope' => 'checkoutPoNumber',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'sortOrder' => 0,
        ];
        return $jsLayout;
    }
}
