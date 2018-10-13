<?php

namespace Model;

class Comment
{
    public function __construct(string $author, string $post)
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
