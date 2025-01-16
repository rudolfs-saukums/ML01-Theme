<?php

namespace Magebit\Orders\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Description extends Template
{
    protected $_product = null;

    protected $_coreRegistry = null;

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
    public function getProduct()
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

