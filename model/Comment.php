<?php

namespace Model;

require_once 'exceptions/StringTooLongException.php';

class Comment
{
    private $author;
    private $post;

    public function __construct(string $author, string $post)
    {
        $this->author = $author;
        $this->post = $post;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getPost(): string
    {
        return $this->post;
    }
}
