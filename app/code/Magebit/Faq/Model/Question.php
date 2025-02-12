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
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel\Question::class);
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->getData(self::ID);
    }

    /**
     * @return mixed
     */
    public function getQuestion(): mixed
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * @param $question
     * @return void
     */
    public function setQuestion($question): void
    {
        $this->setData(self::QUESTION, $question);
    }

    /**
     * @return mixed
     */
    public function getAnswers(): mixed
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * @param $answers
     * @return void
     */
    public function setAnswers($answers): void
    {
        $this->setData(self::ANSWER, $answers);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->_getData(self::STATUS);
    }

    /**
     * @param int $status
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @return mixed
     */
    public function getPosition(): mixed
    {
        return $this->getData(self::POSITION);
    }

    /**
     * @param $position
     * @return void
     */
    public function setPosition($position): void
    {
        $this->setData(self::POSITION, $position);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt(): mixed
    {
        return $this->getData(self::UPDATED_AT);
    }
}
