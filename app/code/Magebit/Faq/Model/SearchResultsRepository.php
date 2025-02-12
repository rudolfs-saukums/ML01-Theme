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

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\AbstractExtensibleObject;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;

class SearchResultsRepository extends SearchResults implements QuestionSearchResultsInterface
{
    /**
     * @return array|QuestionInterface[]|AbstractExtensibleObject[]
     */
    public function getItems(): array
    {
        return $this->_get('items') ?? [];
    }

    /**
     * @param array $items
     * @return void
     */
    public function setItems(array $items): void
    {
        $this->setData('items', $items);
    }

    /**
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria(): ?SearchCriteriaInterface
    {
        return $this->_get('search_criteria');
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return void
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria): void
    {
        $this->setData('search_criteria', $searchCriteria);
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return (int) $this->_get('total_count');
    }

    /**
     * @param $totalCount
     * @return void
     */
    public function setTotalCount($totalCount): void
    {
        $this->setData('total_count', $totalCount);
    }
}
