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

use Exception;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterfaceFactory;
use Magebit\Faq\Model\ResourceModel\Question as ResourceModel;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var ResourceModel
     */
    private ResourceModel $questionResource;

    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var QuestionSearchResultsInterfaceFactory
     */
    private QuestionSearchResultsInterfaceFactory $searchResultsFactory;

    /**
     * @param QuestionFactory $questionFactory
     * @param CollectionFactory $collectionFactory
     * @param ResourceModel $questionResource
     * @param CollectionProcessorInterface $collectionProcessor
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        QuestionFactory $questionFactory,
        CollectionFactory $collectionFactory,
        ResourceModel $questionResource,
        CollectionProcessorInterface $collectionProcessor,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->questionFactory = $questionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->questionResource = $questionResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param int $id
     * @return QuestionInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id): QuestionInterface
    {
        $question = $this->questionFactory->create();
        $this->questionResource->load($question, $id);

        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with ID "%1" does not exist.', $id));
        }

        return $question;
    }

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws AlreadyExistsException
     * @throws Exception
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        try {
            $this->questionResource->save($question);
        } catch (AlreadyExistsException $exception) {
            throw new AlreadyExistsException(__('Question with the same ID "%1" already exists.', $question->getId()));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $question;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param QuestionInterface $question
     * @return bool
     * @throws StateException
     */
    public function delete(QuestionInterface $question): bool
    {
        try {
            $this->questionResource->delete($question);
        } catch (Exception $exception) {
            throw new StateException(__('Unable to remove question %1', $question->getId()));
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     * @throws StateException
     */
    public function deleteById($id): bool
    {
        try {
            $question = $this->get($id);
            $this->questionResource->delete($question);
        } catch (Exception $exception) {
            throw new StateException(__('Unable to remove question %1', $question->getId()));
        }

        return true;
    }
}
