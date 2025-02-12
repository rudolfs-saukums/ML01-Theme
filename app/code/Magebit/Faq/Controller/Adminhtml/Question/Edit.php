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

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\QuestionRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action
{
    /**
     * @see _isAllowed()
     */
    const string ADMIN_RESOURCE = 'Magebit_Faq::page_edit';

    /**
     * @var QuestionRepository
     */
    private QuestionRepository $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('id');
        $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        if ($id) {
            try {
                $question = $this->questionRepository->get((int)$id);
                /** @var Page $result */
                $result->setActiveMenu('Magebit_Faq::question')->addBreadcrumb(__('Edit question'), __('Question'));
                $result->getConfig()->getTitle()->prepend(__('Edit Question: %question', ['question' => $question->getQuestion()]));
            } catch (NoSuchEntityException $e) {
                /** @var Redirect $result */
                $this->messageManager->addErrorMessage(__('Question with id %value does not exist', ['value' => $id]));
                $result->setPath('*/*');
            }
        }

        return $result;
    }
}
