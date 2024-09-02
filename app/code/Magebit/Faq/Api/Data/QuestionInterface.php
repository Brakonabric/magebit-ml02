<?php
namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    const ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    public function getId();
    public function getQuestion();
    public function setQuestion(string $question): void;
    public function getAnswer();
    public function setAnswer(string $answer): void;
    public function getStatus();
    public function setStatus(int $status): void;
    public function getPosition();
    public function setPosition(int $position): void;
    public function getUpdatedAt();
}
