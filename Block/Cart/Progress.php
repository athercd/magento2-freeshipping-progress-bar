<?php
namespace Ather\FreeShippingProgressBar\Block\Cart;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Progress extends Template
{
    protected $_checkoutSession;
    protected $scopeConfig;
    
    public function __construct(
        Context $context,
        Session $checkoutSession,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }
    
    public function isEnabled()
    {
        return (bool)$this->scopeConfig->getValue('freeshippingprogressbar/general/enabled', ScopeInterface::SCOPE_STORE);
    }
    
    public function isShowOnMiniCart()
    {
        return (bool)$this->scopeConfig->getValue('freeshippingprogressbar/general/show_on_mini_cart', ScopeInterface::SCOPE_STORE);
    }
    
    public function isShowOnCartCheckout()
    {
        return (bool)$this->scopeConfig->getValue('freeshippingprogressbar/general/show_on_cart_checkout', ScopeInterface::SCOPE_STORE);
    }
    
    public function getStartAmount()
    {
        return (float)$this->scopeConfig->getValue('freeshippingprogressbar/general/start_amount', ScopeInterface::SCOPE_STORE);
    }
    
    public function getMinimumOrderTotal()
    {
        return (float)$this->scopeConfig->getValue('freeshippingprogressbar/general/minimum_order_total', ScopeInterface::SCOPE_STORE);
    }
    
    public function getCartTotal()
    {
        return (float)$this->_checkoutSession->getQuote()->getGrandTotal();
    }
    
    public function getCurrencyCode()
    {
        return $this->_storeManager->getStore()->getCurrentCurrencyCode();
    }
    
    public function isOrderEligibleForFreeShipping()
    {
        $cartTotal = $this->getCartTotal();
        $minimumOrderTotal = $this->getMinimumOrderTotal();
        return $cartTotal >= $minimumOrderTotal;
    }
}
