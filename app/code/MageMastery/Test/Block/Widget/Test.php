<?php

namespace MageMastery\Test\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Test extends Template implements BlockInterface
{
    protected $_template = "widget/Stock.phtml";
}

