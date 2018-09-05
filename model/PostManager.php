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

    public function count($addWhere = [])
    {
        $query = 'SELECT COUNT(*) FROM '.$this->dbName.' WHERE ';

        $query = $this->createQuery($addWhere, $query);

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }

        $req->execute();

        return $req->fetchColumn();
    }

    public function delete($addWhere)
    {
        $query = 'DELETE FROM '.$this->dbName.' WHERE ';

        $query = $this->createQuery($addWhere, $query);

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }
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

    public function getAll($addWhere)
    {
        $posts = [];

        $query = 'SELECT '.$this->dbName.'.id, articleId, authorId, content, addDate, editDate, edited, reported, moderated, moderationId, login as authorName, avatar, moderationMessage
                FROM '.$this->dbName.'
                LEFT JOIN user ON authorId = user.id
                LEFT JOIN moderation ON moderationId = moderation.id
                WHERE ';

        $query = $this->createQuery($addWhere, $query);

        $query .= ' ORDER BY addDate DESC';

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }

        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            if(is_null($data['authorName'])) {$data['authorId'] = 0; $data['authorName'] = 'Invité'; $data['avatar'] = '0.jpg';}

            $posts[] = new Post($data);
        }

        return $posts;
    }

    public function getReported()
    {
        $posts = [];

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->query('SELECT '.$this->dbName.'.id, articleId, authorId, content, addDate, editDate, edited, reported, moderated, moderationId, login as authorName
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
