<?php

namespace model;

use \model\entity\Post;

class PostManager extends Manager
{
    public function addPost(Post $post)
    {
   		$req = $this->db->prepare('INSERT INTO '.$this->dbName.'(articleId, authorId, content, addDate) VALUES(:articleId, :authorId, :content, NOW())');
        $req->bindValue(':articleId', $post->articleId(), \PDO::PARAM_INT);
   		$req->bindValue(':authorId', $post->authorId(), \PDO::PARAM_INT);
   		$req->bindValue(':content', $post->content());
   		$req->execute();

        return $this->db->lastInsertId();
    }

    public function count($addWhere = null)
    {
        return $this->db->query('SELECT COUNT(*) FROM '.$this->dbName.''.$addWhere)->fetchColumn();
    }

    public function delete($postId)
    {
        $req = $this->db->prepare('DELETE FROM '.$this->dbName.' WHERE id = :id');
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);
        $req->execute();
    }

    public function editPost(Post $post)
    {
        $req = $this->db->prepare('UPDATE '.$this->dbName.' SET content = :content, editDate = NOW(), edited = :edited, reported = :reported, moderated = :moderated, moderationId = :moderationId WHERE id = :id');
        $req->bindValue(':id', $post->id(), \PDO::PARAM_INT);
        $req->bindValue(':edited', $post->edited(), \PDO::PARAM_INT);
        $req->bindValue(':reported', $post->reported(), \PDO::PARAM_INT);
        $req->bindValue(':moderated', $post->moderated(), \PDO::PARAM_INT);
        $req->bindValue(':moderationId', $post->moderationId(), \PDO::PARAM_INT);
        $req->bindValue(':content', $post->content());
        $req->execute();
    }

    public function get($postId)
    {
        $req = $this->db->prepare('SELECT id, articleId, authorId, content, edited, reported, moderated, moderationId FROM '.$this->dbName.' WHERE id = :id');
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new Post($data):'';
    }

    public function getAll($articleId)
    {
        $posts = [];

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->prepare('SELECT '.$this->dbName.'.id, articleId, authorId, content, DATE_FORMAT(addDate, \'%d %M %Y à %H:%i:%s\') AS addDateFr, edited, reported, moderated, moderationId, login as authorName, moderationMessage
                FROM '.$this->dbName.'
                LEFT JOIN user ON authorId = user.id
                LEFT JOIN moderation ON moderationId = moderation.id
                WHERE articleId = :articleId
                ORDER BY addDate DESC');
        $req->bindValue(':articleId', $articleId, \PDO::PARAM_INT);
        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $posts[] = new Post($data);
        }

        return $posts;
    }

    public function getReported()
    {
        $posts = [];

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->query('SELECT '.$this->dbName.'.id, articleId, authorId, content, DATE_FORMAT(addDate, \'%d %M %Y à %H:%i:%s\') AS addDateFr, edited, reported, moderated, moderationId, login as authorName
                FROM '.$this->dbName.'
                LEFT JOIN user ON authorId = user.id
                WHERE reported = 1
                ORDER BY addDate DESC');

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $posts[] = new Post($data);
        }

        return $posts;
    }
}
