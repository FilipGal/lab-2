<?php

namespace Model;

require_once 'Comment.php';

class SubmissionModel
{
    private $db;
    private $requestUri = 'REQUEST_URI';
    private const MAX_LENGTH_SUBMISSION = 75;

    public function __construct(\Model\DatabaseModel $db)
    {
        $this->db = $db;
    }

    public function postSubmission(string $post, string $author): void
    {
        mysqli_query($this->db->connect(), $this->insertSubmissionQuery($post, $author));
        $this->postRedirect();
    }

    private function postRedirect()
    {
        header("Location: " . $_SERVER[$this->requestUri]);
        exit();
    }

    private function insertSubmissionQuery(string $post, string $author): string
    {
        if (strlen($post) > self::MAX_LENGTH_SUBMISSION) {
            throw new \StringTooLongException();
        } else {
            return "INSERT INTO posts (post, author) VALUES ('$post', '$author')";
        }
    }

    public function fetchPosts(): array
    {
        $query = \mysqli_query($this->db->connect(), "SELECT * FROM posts");
        $comment = array();
        while ($result = $query->fetch_assoc()) {
            array_push($comment, new \Model\Comment($result['author'], $result['post']));
        }
        return $comment;
    }
}
