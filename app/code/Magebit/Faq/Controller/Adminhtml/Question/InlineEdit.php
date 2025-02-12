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

use Magebit\Faq\Model\QuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magebit\Faq\Model\ResourceModel\Question as DataResourceModel;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected JsonFactory $jsonFactory;
    /**
     * @var QuestionFactory
     */
    private QuestionFactory $dataFactory;
    /**
     * @var DataResourceModel
     */
    private DataResourceModel $dataResourceModel;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param QuestionFactory $dataFactory
     * @param DataResourceModel $dataResourceModel
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        QuestionFactory $dataFactory,
        DataResourceModel $dataResourceModel)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->dataFactory = $dataFactory;
        $this->dataResourceModel = $dataResourceModel;
    }

    /**
     * @return Json|ResultInterface|ResponseInterface
     */
    public function execute(): Json|ResultInterface|ResponseInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        if ($this->getRequest()->getParam('isAjax'))
        {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems))
            {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            }
            else
            {
                foreach (array_keys($postItems) as $modelid)
                {
                    $model = $this->dataFactory->create();
                    $this->dataResourceModel->load($model, $modelid);
                    try
                    {
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $this->dataResourceModel->save($model);
                    }
                    catch (\Exception $e)
                    {
                        $messages[] = "[Error : {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error]);
    }
}
