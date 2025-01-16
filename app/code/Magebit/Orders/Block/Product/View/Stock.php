<?php

namespace Magebit\Orders\Block\Product\View;

use Magento\Framework\View\Element\Template;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Registry;

class Stock extends Template
{
    /**
     * @var StockStateInterface
     */
    protected $stockState;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param StockStateInterface $stockState
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        StockStateInterface $stockState,
        Registry $registry,
        array $data = []
    ) {
        $this->stockState = $stockState;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get the available stock quantity for the current product
     *
     * @return int
     */
    public function getAvailableStock()
    {
        $product = $this->coreRegistry->registry('product');
        if ($product) {
            return (int) $this->stockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
        }
        return 0;
    }
}
