<?php

namespace model;

use \model\entity\Testimony;

class TestimonyManager extends Manager
{
    public function addTestimony(Testimony $testimony)
    {
        $req = $this->db->prepare('INSERT INTO testimony(categoryId, authorId, title, content, addDate, editDate, published) VALUES(:categoryId, :authorId, :title, :content, NOW(), NOW(), :published)');
        $req->bindValue(':categoryId', $testimony->categoryId(), \PDO::PARAM_INT);
        $req->bindValue(':authorId', $testimony->authorId(), \PDO::PARAM_INT);
        $req->bindValue(':title', $testimony->title());
        $req->bindValue(':content', $testimony->content());
        $req->bindValue(':published', (int) $testimony->published(), \PDO::PARAM_INT);
        $req->execute();

        return $this->db->lastInsertId();
    }

    public function count($addWhere = [])
    {
        $query = 'SELECT COUNT(*) FROM testimony WHERE ';

        $query = $this->createQuery($addWhere, $query);

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }

        $req->execute();

        return $req->fetchColumn();
    }

    public function delete($testimonyId)
    {
        $req = $this->db->prepare('DELETE FROM testimony WHERE id = :id');
        $req->bindValue(':id', $testimonyId, \PDO::PARAM_INT);
        $req->execute();
    }

    public function editTestimony(Testimony $testimony)
    {
        $req = $this->db->prepare('UPDATE testimony SET categoryId = :categoryId, authorId = :authorId, title = :title, content = :content, editDate = NOW(), edited = 1, published = :published WHERE id = :id');
        $req->bindValue(':categoryId', $testimony->categoryId(), \PDO::PARAM_INT);
        $req->bindValue(':id', $testimony->id(), \PDO::PARAM_INT);
        $req->bindValue(':authorId', $testimony->authorId(), \PDO::PARAM_INT);
        $req->bindValue(':title', $testimony->title());
        $req->bindValue(':content', $testimony->content());
        $req->bindValue(':published', (int) $testimony->published(), \PDO::PARAM_INT);
        $req->execute();
    }    

    public function get($info)
    {
        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->prepare('SELECT testimony.id, categoryId, authorId, title, content, addDate, editDate, edited, published, commentCount, login as authorName, categories.name as categoryName
            FROM testimony
            LEFT JOIN user ON authorId = user.id
            LEFT JOIN categories ON categoryId = categories.id
            WHERE testimony.id = :id');
        $req->bindValue(':id', $info, \PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new Testimony($data):'';
    }

    public function getAll($addWhere = null, $addLimit = null)
    {
        $testimonies = null;

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->query('SELECT testimony.id, categoryId, authorId, title, content, addDate, editDate, edited, published, commentCount, login as authorName, categories.name as categoryName 
            FROM testimony
            LEFT JOIN user ON authorId = user.id
            LEFT JOIN categories ON categoryId = categories.id '
            .$addWhere.
            'ORDER BY addDate DESC '.$addLimit);

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $testimonies[] = new Testimony($data);
        }

        return $testimonies;
    }

    public function getLast()
    {
        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->query('SELECT testimony.id, categoryId, authorId, title, content, addDate, editDate, edited, published, commentCount, login as authorName, categories.name as categoryName
            FROM testimony
            LEFT JOIN user ON authorId = user.id
            LEFT JOIN categories ON categoryId = categories.id
            WHERE published = 1
            ORDER BY  addDate DESC LIMIT 0, 1');

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new Testimony($data):'';
    }

    public function publish($testimonyId, $published)
    {
        $req = $this->db->prepare('UPDATE testimony SET published = :published WHERE id = :id');
        $req->bindValue(':id', $testimonyId, \PDO::PARAM_INT);
        $req->bindValue(':published', (int) $published, \PDO::PARAM_INT);
        $req->execute();
    }

    public function search($search)
    {
        $testimonies = [];

        $req = $this->db->prepare('SELECT testimony.id, categoryId, authorId, title, content, addDate, editDate, edited, published, commentCount, login as authorName, categories.name as categoryName
            FROM testimony
            LEFT JOIN user ON authorId = user.id
            LEFT JOIN categories ON categoryId = categories.id
            WHERE content LIKE :content AND published = 1');
        $req->bindValue(':content', $search);
        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $testimonies[] = new Testimony($data);
        }

        return $testimonies;
    }

    public function updateCommentCount(Testimony $testimony)
    {
        $req = $this->db->prepare('UPDATE testimony SET commentCount = :commentCount WHERE id = :id');
        $req->bindValue(':commentCount', $testimony->commentCount(), \PDO::PARAM_INT);
        $req->bindValue(':id', $testimony->id(), \PDO::PARAM_INT);
        $req->execute();
    }
}
