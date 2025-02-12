<?php
/**
 * @copyright Copyright (c) 2025 Magebit (https://magebit.com/)
 * @author    <info@magebit.com>
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\View\Element\{Template, Template\Context};
use Magento\Framework\Api\{SearchCriteriaBuilderFactory, SortOrderBuilder};

class QuestionList extends Template
{
    /**
     * @var QuestionRepositoryInterface
     */
    private QuestionRepositoryInterface $questionRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private SearchCriteriaBuilderFactory $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Context                      $context,
        QuestionRepositoryInterface  $questionRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return array|null
     */
    public function getFaqItems(): ?array
    {
        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('ASC')->create();
        $searchCriteriaBuilder = $this->searchCriteriaBuilder->create();
        $searchCriteria = $searchCriteriaBuilder->addFilter('status', 1)->setSortOrders([$sortOrder])->create();
        $questions = $this->questionRepository->getList($searchCriteria)->getItems();
        if(is_countable($questions) && count($questions) > 0){
            return $questions;
        }

        return null;
    }
}
