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

namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    public const string STATUS = 'status';
    public const string ID = 'id';
    public const string UPDATED_AT = 'updated_at';
    public const string CATEGORY = 'category';
    public const string ANSWER = 'answer';
    public const string QUESTION = 'question';
    public const string POSITION = 'position';

    /**
     * @return mixed
     */
    public function getId(): mixed;

    /**
     * @return mixed
     */
    public function getQuestion(): mixed;

    /**
     * @param $question
     * @return void
     */
    public function setQuestion($question): void;

    /**
     * @return mixed
     */
    public function getAnswers(): mixed;

    /**
     * @param $answers
     * @return void
     */
    public function setAnswers($answers): void;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return void
     */
    public function setStatus(int $status): void;

    /**
     * @return mixed
     */
    public function getPosition(): mixed;

    /**
     * @param $position
     * @return void
     */
    public function setPosition($position): void;

    /**
     * @return mixed
     */
    public function getUpdatedAt(): mixed;
}
