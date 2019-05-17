<?php


namespace Netzexpert\RandomReview\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var LayoutInterface  */
    protected $_layout;

    public function __construct(LayoutInterface $layout)
    {
        $this->_layout = $layout;
    }

    public function getConfig()
    {
        $myBlockId = "test_shipping_checkout"; // CMS Block Identifier
        //$myBlockId = 20; // CMS Block ID

        return [
            'checkout_review' => $this->_layout->createBlock('Netzexpert\RandomReview\Block\View')
                ->setTemplate('Netzexpert_RandomReview::view.phtml')
                ->toHtml()
        ];
    }

}