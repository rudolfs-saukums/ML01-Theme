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

use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Description extends Template
{
    /**
     * @var Product|null
     */
    protected ?Product $_product = null;

    /**
     * @var Registry|null
     */
    protected ?Registry $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $registry;
    }

    /**
     * Get the product from the registry
     *
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }

    /**
     * Get the list of attributes to display
     *
     * @return array
     */
    public function getFilteredAttributes(): array
    {
        $product = $this->getProduct();
        if (!$product) {
            return [];
        }

        $attributeCodes = ['dimensions', 'color_custom', 'material_custom'];

        $displayAttributes = [];
        $processedCodes = [];

        foreach ($attributeCodes as $attributeCode) {
            $attribute = $product->getResource()->getAttribute($attributeCode);
            if ($attribute && $product->getData($attributeCode)) {
                $displayAttributes[] = [
                    'label' => $attribute->getStoreLabel(),
                    'value' => $product->getData($attributeCode),
                ];
                $processedCodes[] = $attributeCode;
            }
            if (count($displayAttributes) >= 3) {
                return $displayAttributes;
            }
        }

        $allAttributes = $product->getAttributes();
        foreach ($allAttributes as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            if (in_array($attributeCode, $processedCodes)) {
                continue;
            }
            $value = $product->getData($attributeCode);
            if ($value) {
                $displayAttributes[] = [
                    'label' => $attribute->getStoreLabel(),
                    'value' => is_array($value) ? implode(', ', $value) : $value,
                ];
                $processedCodes[] = $attributeCode;
            }
            if (count($displayAttributes) >= 3) {
                break;
            }
        }

        return $displayAttributes;
    }
}

