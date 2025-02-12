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

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface QuestionRepositoryInterface
{
    /**
     * @param int $id
     * @return QuestionInterface
     */
    public function get(int $id): QuestionInterface;

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     */
    public function save(QuestionInterface $question): QuestionInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface;

    /**
     * @param QuestionInterface $question
     * @return bool
     */
    public function delete(QuestionInterface $question): bool;

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool;
}
