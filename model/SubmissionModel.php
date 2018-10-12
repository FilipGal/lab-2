<?php

namespace Model;

class SubmissionModel
{
    private $db;

    public function __construct(\Model\DatabaseModel $db)
    {
        $this->db = $db;
        echo $this->displayPosts();
    }

    public function postSubmission()
    {
        try {
            return mysqli_query($this->db->connect(), $this->insertPostQuery());
        } catch (\Exception $e) {
            return $e;
        }
    }

    private function insertPostQuery(string $post)
    {
        return "INSERT INTO posts (post) VALUES ('$post')";
    }

    public function displayPosts()
    {
        $query = \mysqli_query($this->db->connect(), "SELECT * FROM posts");
        $posts = array();
        while ($row = \mysqli_fetch_array($query)) {
            $posts = $row;
        }

        var_dump($posts);
    }

}
