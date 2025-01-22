<?php
/**
 * @copyright Copyright (c) 2025 Magebit (https://magebit.com/)
 * @author    <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Magebit\Orders\Block\Product\View;

use Magento\Framework\View\Element\Template;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;

class Stock extends Template
{
    /**
     * @var StockStateInterface
     */
    protected StockStateInterface $stockState;

    /**
     * @var Registry
     */
    protected Registry $coreRegistry;

    /**
     * Constructor
     *
     * @param Context $context
     * @param StockStateInterface $stockState
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
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
    public function getAvailableStock(): int
    {
        $product = $this->coreRegistry->registry('product');
        if ($product) {
            return (int) $this->stockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
        }

        return 0;
    }
}
