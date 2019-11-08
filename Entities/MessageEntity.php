<?php
declare(strict_types=1);

namespace Entities;
class MessageEntity {
    private $author;
    private $epoch = '';
    private $recipient;
    private $content;

    public function __construct(string $recipient, string $author, string $content ) {
        $this->recipient = $recipient;
        $this->author  = $author;
        $this->content = $content;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getRecipient() {
        return $this->recipient;
    }

    public function getContent() {
        return $this->content;
    }

    public function getEpoch() {
        return $this->epoch;
    }

    public function setEpoch(string $epoch) {
        $this->epoch = $epoch;
    }


}