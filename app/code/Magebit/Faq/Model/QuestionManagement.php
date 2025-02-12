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

use Magebit\Faq\Api\QuestionManagementInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;

class QuestionManagement implements QuestionManagementInterface
{
    /**
     * @var QuestionRepository
     */
    private QuestionRepository $questionRepository;

    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @throws NoSuchEntityException
     * @throws AlreadyExistsException
     */
    public function enableQuestion($id): bool
    {
        $question = $this->questionRepository->get($id);
        $question->setStatus(1);
        $this->questionRepository->save($question);
        return true;
    }

    /**
     * @throws NoSuchEntityException
     * @throws AlreadyExistsException
     */
    public function disableQuestion($id): bool
    {
        $question = $this->questionRepository->get($id);
        $question->setStatus(0);
        $this->questionRepository->save($question);
        return true;
    }
}
