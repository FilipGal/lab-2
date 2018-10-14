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

    public function postSubmission(string $post)
    {
        return mysqli_query($this->db->connect(), $this->insertPostQuery($post));

    }

    private function insertPostQuery(string $post)
    {
        if (strlen($post) > 75) {
            throw new \StringTooLongException();
        } else {
            return "INSERT INTO posts (post) VALUES ('$post')";
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
