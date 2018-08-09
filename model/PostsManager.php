<?php


class PostsManager extends Manager
{
    public function addPost(Post $post)
    {
   		$req = $this->db->prepare('INSERT INTO posts(newsId, authorId, content, addDate) VALUES(:newsId, :authorId, :content, NOW())');
        $req->bindValue(':newsId', $post->newsId(), PDO::PARAM_INT);
   		$req->bindValue(':authorId', $post->authorId(), PDO::PARAM_INT);
   		$req->bindValue(':content', $post->content());
   		$req->execute();

        return $this->db->lastInsertId();
    }

    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }

    public function editPost(Post $post)
    {
       $req = $this->db->prepare('UPDATE posts SET content = :content, editDate = NOW(), edited = 1 WHERE id = :id');
       $req->bindValue(':id', $post->id(), PDO::PARAM_INT);
       $req->bindValue(':content', $post->content());
       $req->execute();
    }

    public function getAll($newsId)
    {
        $posts = null;

        $this->db->query('SET lc_time_names = \'fr_FR\'');

        $req = $this->db->prepare('SELECT posts.id, newsId, authorId, content, DATE_FORMAT(addDate, \'%d %M %Y à %H:%i:%s\') AS addDateFr, login as authorName
                FROM posts
                LEFT JOIN user ON authorId = user.id
                WHERE newsId = :newsId
                ORDER BY addDate DESC');
        $req->bindValue(':newsId', $newsId, PDO::PARAM_INT);
        $req->execute();

        while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $posts[] = new Post($data);
        }

        return $posts;
    }    
}
