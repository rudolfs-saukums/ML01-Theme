<?php

namespace MageMastery\PageListWidget\Block\Page\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;

class PageList extends Template implements BlockInterface
{
    protected $_template = "widget/page_list_widget.phtml";

    public function __construct(
        protected PageCollectionFactory $pageCollectionFactory
        )
    {}

    public function getTitle(): string
    {
        $data = $this->getData("title");

        return $data;
    }
//
//    public function getSelectedPages(): array
//    {
//        $data = $this->getData("selected_pages");
//
//        return $data;
//    }
//
//    public function getPages()
//    {
//        $data = $this->getData("display_mode");
//
//        if ($data == "all_pages")
//        {
//            $pageCollection = $this->pageCollectionFactory->create();
//        }
//    }
}
