<?php

declare(strict_types=1);

namespace MageMastery\PageListWidget\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CmsPageDropdown implements OptionSourceInterface
{
    protected $pageRepository;
    protected $searchCriteriaBuilder;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function toOptionArray(): array
    {
        $options = [];
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $pages = $this->pageRepository->getList($searchCriteria)->getItems();

        foreach ($pages as $page) {
            $options[] = [
                'value' => $page->getId(),
                'label' => $page->getTitle()
            ];
        }

        return $options;
    }
}
