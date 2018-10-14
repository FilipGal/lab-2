<?php

namespace Model;

require_once 'Comment.php';

class SubmissionModel
{
    private $db;

    public function __construct(\Model\DatabaseModel $db)
    {
        $this->db = $db;
    }

    public function postSubmission(string $post, string $author)
    {
        mysqli_query($this->db->connect(), $this->insertPostQuery($post, $author));
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    private function insertPostQuery(string $post, string $author)
    {
        if (strlen($post) > 75) {
            throw new \StringTooLongException();
        } else {
            return "INSERT INTO posts (post, author) VALUES ('$post', '$author')";
        }
    }

    public function fetchPosts()
    {
        $query = \mysqli_query($this->db->connect(), "SELECT * FROM posts");
        $comment = array();
        while ($result = $query->fetch_assoc()) {
            array_push($comment, new \Model\Comment($result['author'], $result['post']));
        }
        return $comment;
    }
}
