<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\{App\Action, App\Action\Context, Model\View\Result\Redirect};
use Magebit\Faq\Model\QuestionRepository;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

/**
 * Delete CMS page action.
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
//    const ADMIN_RESOURCE = 'Magebit_Faq::page_delete';
    const ADMIN_RESOURCE = 'Magebit_Faq::question';

    /**
     * @var QuestionRepository
     */
    private readonly QuestionRepository $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        Context            $context,
        QuestionRepository $questionRepository
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return Redirect|ResponseInterface|ResultInterface
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $model = $this->questionRepository->get($id);
            $this->questionRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('The %question has been deleted.', ['question' => $model->getQuestion()]));

            return $resultRedirect->setPath('*/*/');
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
