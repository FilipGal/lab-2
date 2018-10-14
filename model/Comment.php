<?php

namespace Model;

require_once 'exceptions/StringTooLongException.php';

class Comment
{
    public function __construct($author, $post)
    {
        $this->author = $author;
        $this->post = $post;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getPost()
    {
        return $this->post;
    }
}
