<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Api\Data\{QuestionInterface, QuestionSearchResultsInterface, QuestionSearchResultsInterfaceFactory};
use Magebit\Faq\Model\ResourceModel\{Question as QuestionResource, Question\CollectionFactory};
use Magento\Framework\Api\{SearchCriteria\CollectionProcessorInterface, SearchCriteriaInterface};
use Magento\Framework\Exception\{AlreadyExistsException, NoSuchEntityException, StateException};

class QuestionRepository implements QuestionRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private QuestionResource $questionResource;
    private QuestionFactory $questionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private QuestionSearchResultsInterfaceFactory $searchResultsFactory;

    public function __construct(
        QuestionFactory $questionFactory,
        CollectionFactory $collectionFactory,
        QuestionResource $questionResource,
        CollectionProcessorInterface $collectionProcessor,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->questionFactory = $questionFactory;
        $this->collectionFactory = $collectionFactory;
        $this->questionResource = $questionResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function get(int $id): QuestionInterface
    {
        $question = $this->questionFactory->create();
        $this->questionResource->load($question, $id);

        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with ID "%1" does not exist.', $id));
        }

        return $question;
    }

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

    public function save(QuestionInterface $question): QuestionInterface
    {
        try {
            $this->questionResource->save($question);
        } catch (AlreadyExistsException $exception) {
            throw new AlreadyExistsException(__('Question with the same ID "%1" already exists.', $question->getId()));
        }

        return $question;
    }

    public function delete(QuestionInterface $question): bool
    {
        try {
            $this->questionResource->delete($question);
        } catch (Exception $exception) {
            throw new StateException(__('Unable to remove question %1', $question->getId()));
        }

        return true;
    }

    public function deleteById(int $id): bool
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
