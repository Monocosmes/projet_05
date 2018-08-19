<?php

namespace model;

use \model\entity\PostArticle;

class PostsNewsManager extends Manager
{
    public function addPost(PostArticle $postNews)
    {
   		$req = $this->db->prepare('INSERT INTO postsnews(newsId, authorId, content, addDate) VALUES(:newsId, :authorId, :content, NOW())');
        $req->bindValue(':newsId', $postNews->articleId(), \PDO::PARAM_INT);
   		$req->bindValue(':authorId', $postNews->authorId(), \PDO::PARAM_INT);
   		$req->bindValue(':content', $postNews->content());
   		$req->execute();

        return $this->db->lastInsertId();
    }

    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM postsnews')->fetchColumn();
    }

    public function delete($postId)
    {
        $req = $this->db->prepare('DELETE FROM postsnews WHERE id = :id');
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);
        $req->execute();
    }

    public function editPost(PostArticle $postNews)
    {
        $req = $this->db->prepare('UPDATE postsnews SET content = :content, editDate = NOW(), edited = :edited, reported = :reported WHERE id = :id');
        $req->bindValue(':id', $postNews->id(), \PDO::PARAM_INT);
        $req->bindValue(':edited', $postNews->edited(), \PDO::PARAM_INT);
        $req->bindValue(':reported', $postNews->reported(), \PDO::PARAM_INT);
        $req->bindValue(':content', $postNews->content());
        $req->execute();
    }

    public function get($postId)
    {
        $req = $this->db->prepare('SELECT id, newsId AS articleId, authorId, content, edited, reported FROM postsnews WHERE id = :id');
        $req->bindValue(':id', $postId, \PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new PostArticle($data):'';
    }

    public function getAll($newsId)
    {
        $postNews = null;

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->prepare('SELECT postsnews.id, newsId AS articleId, authorId, content, DATE_FORMAT(addDate, \'%d %M %Y à %H:%i:%s\') AS addDateFr, edited, reported, login as authorName
                FROM postsnews
                LEFT JOIN user ON authorId = user.id
                WHERE newsId = :newsId
                ORDER BY addDate DESC');
        $req->bindValue(':newsId', $newsId, \PDO::PARAM_INT);
        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $postNews[] = new PostArticle($data);
        }

        return $postNews;
    }    
}
