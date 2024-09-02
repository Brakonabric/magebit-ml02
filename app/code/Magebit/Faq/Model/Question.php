<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 */

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements IdentityInterface, QuestionInterface
{
    const CACHE_TAG = 'magebit_faq';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'magebit_faq';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init('Magebit\Faq\Model\ResourceModel\Question');
    }

    /**
     * Get identities for cache tagging
     *
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get default values
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return [];
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    public function setQuestion(string $question): void
    {
        $this->setData(self::QUESTION, $question);
    }

    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    public function setAnswer(string $answer): void
    {
        $this->setData(self::ANSWER, $answer);
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus(int $status): void
    {
        $this->setData(self::STATUS, $status);
    }

    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    public function setPosition(int $position): void
    {
        $this->setData(self::POSITION, $position);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }
}
