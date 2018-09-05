<?php


namespace model;

use \model\entity\News;


class NewsManager extends Manager
{
    public function addNews(News $news)
    {
        $req = $this->db->prepare('INSERT INTO news(authorId, title, content, addDate, editDate, published, highlight) VALUES(:authorId, :title, :content, NOW(), NOW(), :published, :highlight)');
        $req->bindValue(':authorId', $news->authorId(), \PDO::PARAM_INT);
        $req->bindValue(':title', $news->title());
        $req->bindValue(':content', $news->content());
        $req->bindValue(':published', (int) $news->published(), \PDO::PARAM_INT);
        $req->bindValue(':highlight', $news->highlight(), \PDO::PARAM_INT);
        $req->execute();

        return $this->db->lastInsertId();
    }

    public function count($addWhere = [])
    {
        $query = 'SELECT COUNT(*) FROM news WHERE ';

        $query = $this->createQuery($addWhere, $query);

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }

        $req->execute();

        return $req->fetchColumn();
    }

    public function delete($newsId)
    {
        $req = $this->db->prepare('DELETE FROM news WHERE id = :id');
        $req->bindValue(':id', $newsId, \PDO::PARAM_INT);
        $req->execute();
    }

    public function editNews(News $news)
    {
        $req = $this->db->prepare('UPDATE news SET authorId = :authorId, title = :title, content = :content, editDate = NOW(), edited = 1, published = :published, highlight = :highlight WHERE id = :id');
        $req->bindValue(':id', $news->id(), \PDO::PARAM_INT);
        $req->bindValue(':authorId', $news->authorId(), \PDO::PARAM_INT);
        $req->bindValue(':title', $news->title());
        $req->bindValue(':content', $news->content());
        $req->bindValue(':published', (int) $news->published(), \PDO::PARAM_INT);
        $req->bindValue(':highlight', $news->highlight(), \PDO::PARAM_INT);
        $req->execute();
    }

    public function get($id)
    {
        $req = $this->db->prepare('SELECT news.id, authorId, title, content, addDate, editDate, edited, published, commentCount, highlight, login as authorName
            FROM news
            LEFT JOIN user ON authorId = user.id
            WHERE news.id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new News($data):'';
    }

    public function getAll($addWhere = null, $addLimit = null)
    {
        $allNews = null;

        $req = $this->db->query('SELECT news.id, authorId, title, content, addDate, editDate, edited, published, commentCount, highlight, login as authorName
            FROM news
            LEFT JOIN user ON authorId = user.id'
            .$addWhere.'
            ORDER BY addDate DESC '.$addLimit);

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $allNews[] = new News($data);
        }

        return $allNews;
    }

    public function getHighlight()
    {
        $req = $this->db->query('SELECT news.id, authorId, title, content, addDate, editDate, edited, published, commentCount, login as authorName
            FROM news
            LEFT JOIN user ON authorId = user.id
            WHERE highlight = 1');

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new News($data):'';
    }

    public function publish($id, $published)
    {
        $req = $this->db->prepare('UPDATE news SET published = :published WHERE id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->bindValue(':published', (int) $published, \PDO::PARAM_INT);
        $req->execute();
    }

    public function resetHighlight()
    {
        $req = $this->db->exec('UPDATE news SET highlight = 0 WHERE highlight = 1');
    }

    public function search($search)
    {
        $news = [];

        $req = $this->db->prepare('SELECT  news.id, authorId, title, content, addDate, editDate, edited, published, commentCount, highlight, login as authorName
            FROM news
            LEFT JOIN user ON authorId = user.id
            WHERE content LIKE :content AND published = 1');
        $req->bindValue(':content', $search);
        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $news[] = new News($data);
        }

        return $news;
    }

    public function updateHighlight($id)
    {
        $req = $this->db->prepare('UPDATE news SET highlight = 1 WHERE id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();
    }

    public function updateCommentCount(News $news)
    {
        $req = $this->db->prepare('UPDATE news SET commentCount = :commentCount WHERE id = :id');
        $req->bindValue(':commentCount', $news->commentCount(), \PDO::PARAM_INT);
        $req->bindValue(':id', $news->id(), \PDO::PARAM_INT);
        $req->execute();
    }
}
