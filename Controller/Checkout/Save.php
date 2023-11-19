<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_PoNumberOnCheckout
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\PoNumberOnCheckout\Controller\Checkout;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Quote\Model\QuoteRepository;

/**
 * class Save
 */
class Save implements \Magento\Framework\App\ActionInterface
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var QuoteRepository
     */
    private $quoteRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Session $checkoutSession
     * @param QuoteRepository $quoteRepository
     * @param RequestInterface $request
     */
    public function __construct(
        Session         $checkoutSession,
        QuoteRepository $quoteRepository,
        RequestInterface $request
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->quoteRepository = $quoteRepository;
        $this->request = $request;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $poNumber = $this->request->getParam('po_number');
            if($poNumber !=="undefined" && $poNumber) {
                $quoteId = $this->checkoutSession->getQuoteId();
                $quote = $this->quoteRepository->get($quoteId);
                $quote->setPoNumber($poNumber);
                $this->quoteRepository->save($quote);
            }
        } catch (\Exception $e) {
            throw new \Exception(__($e->getMessage()));
        }
    }
}
