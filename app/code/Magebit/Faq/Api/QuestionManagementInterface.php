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

interface QuestionManagementInterface
{
    /**
     * @param int $id
     * @return bool
     */
    function enableQuestion (int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    function disableQuestion (int $id): bool;
}
