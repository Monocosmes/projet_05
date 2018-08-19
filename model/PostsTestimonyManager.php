<?php

namespace model;

use \model\entity\PostArticle;

class PostsTestimonyManager extends Manager
{
    public function addPost(PostArticle $postTestimony)
    {
   		$req = $this->db->prepare('INSERT INTO poststestimony(testimonyId, authorId, content, addDate) VALUES(:testimonyId, :authorId, :content, NOW())');
        $req->bindValue(':testimonyId', $postTestimony->articleId(), \PDO::PARAM_INT);
   		$req->bindValue(':authorId', $postTestimony->authorId(), \PDO::PARAM_INT);
   		$req->bindValue(':content', $postTestimony->content());
   		$req->execute();

        return $this->db->lastInsertId();
    }

    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM poststestimony')->fetchColumn();
    }

    public function delete($postId)
    {
        $req = $this->db->prepare('DELETE FROM poststestimony WHERE id = :id');
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);
        $req->execute();
    }

    public function editPost(PostArticle $postTestimony)
    {
        $req = $this->db->prepare('UPDATE poststestimony SET content = :content, editDate = NOW(), edited = :edited, reported = :reported WHERE id = :id');
        $req->bindValue(':id', $postTestimony->id(), \PDO::PARAM_INT);
        $req->bindValue(':edited', $postTestimony->edited(), \PDO::PARAM_INT);
        $req->bindValue(':reported', $postTestimony->reported(), \PDO::PARAM_INT);
        $req->bindValue(':content', $postTestimony->content());
        $req->execute();
    }

    public function get($postId)
    {
        $req = $this->db->prepare('SELECT id, testimonyId AS articleId, authorId, content, edited, reported FROM poststestimony WHERE id = :id');
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new PostArticle($data):'';
    }

    public function getAll($testimonyId)
    {
        $postTestimonies = null;

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->prepare('SELECT poststestimony.id, testimonyId AS articleId, authorId, content, DATE_FORMAT(addDate, \'%d %M %Y à %H:%i:%s\') AS addDateFr, edited, reported, login as authorName
                FROM poststestimony
                LEFT JOIN user ON authorId = user.id
                WHERE testimonyId = :testimonyId
                ORDER BY addDate DESC');
        $req->bindValue(':testimonyId', $testimonyId, \PDO::PARAM_INT);
        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $postTestimonies[] = new PostArticle($data);
        }

        return $postTestimonies;
    }    
}
