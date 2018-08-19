<?php

namespace model;

use \model\entity\PrivateMessage;

class PrivateMessageManager extends Manager
{
    public function add(PrivateMessage $privateMessage)
    {
    	$req = $this->db->prepare('INSERT INTO privatemessage (authorId, receiverId, title, messageCount, lastPMId, creationDate) VALUES (:authorId, :receiverId, :title, :messageCount, 0, NOW())');
    	$req->bindValue(':authorId', $privateMessage->authorId(), \PDO::PARAM_INT);
    	$req->bindValue(':receiverId', $privateMessage->receiverId(), \PDO::PARAM_INT);
    	$req->bindValue(':title', $privateMessage->title());
    	$req->bindValue(':messageCount', $privateMessage->messageCount(), \PDO::PARAM_INT);
    	$req->execute();

    	return $this->db->lastInsertId();
    }

    public function get($id)
    {
    	$this->db->query('SET lc_time_names = \'fr_FR\'');

    	$req = $this->db->prepare('SELECT privatemessage.id AS id, authorId, receiverId, title, messageCount, lastPMId, ua.login AS authorName, ub.login AS receiverName, DATE_FORMAT(creationDate, \'%d %M %Y à %H:%i:%s\') AS creationDateFr
    		FROM privatemessage
    		LEFT JOIN user ua ON authorId = ua.id
    		LEFT JOIN user ub ON receiverId = ub.id
    		WHERE privatemessage.id = :id');
    	$req->bindValue(':id', $id, \PDO::PARAM_INT);
    	$req->execute();

    	$data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data) ? new PrivateMessage($data) : '';
    }

    public function getAll($userId)
    {
    	$messages = null;

    	$this->db->query('SET lc_time_names = \'fr_FR\'');

    	$req = $this->db->prepare('SELECT privatemessage.id AS id, authorId, privatemessage.receiverId AS receiverId, title, messageCount, ua.login AS authorName, ub.login AS receiverName, DATE_FORMAT(creationDate, \'%d %M %Y à %H:%i:%s\') AS creationDateFr, viewpm.receiverId AS receiverIdView, isRead
    		FROM privatemessage
    		LEFT JOIN user ua ON privatemessage.authorId = ua.id
    		LEFT JOIN user ub ON receiverId = ub.id
    		LEFT JOIN viewpm ON lastPMId = contentId AND :userId = viewpm.receiverId
    		WHERE authorId = :userId OR privatemessage.receiverId = :userId
    		ORDER BY creationDate DESC');
    	$req->bindValue(':userId', $userId, \PDO::PARAM_INT);
    	$req->execute();

    	while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $messages[] = new PrivateMessage($data);
        }

        return $messages;
    }

    public function update(PrivateMessage $privateMessage)
    {
    	$req = $this->db->prepare('UPDATE privatemessage SET title = :title, messageCount = :messageCount, lastPMId = :lastPMId WHERE id = :id');
    	$req->bindValue(':title', $privateMessage->title());
    	$req->bindValue(':messageCount', $privateMessage->messageCount(), \PDO::PARAM_INT);
    	$req->bindValue(':lastPMId', $privateMessage->lastPMId(), \PDO::PARAM_INT);
    	$req->bindValue(':id', $privateMessage->id(), \PDO::PARAM_INT);
    	$req->execute();
    }
}