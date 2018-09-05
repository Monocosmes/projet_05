<?php

namespace model;

use \model\entity\PrivateMessage;

class PrivateMessageManager extends Manager
{
    public function add(PrivateMessage $privateMessage)
    {
    	$req = $this->db->prepare('INSERT INTO privatemessage (authorId, receiverId, title, messageCount, lastPMId, authorIsOn, receiverIsOn, creationDate) VALUES (:authorId, :receiverId, :title, :messageCount, 0, :authorIsOn, :receiverIsOn, NOW())');
    	$req->bindValue(':authorId', $privateMessage->authorId(), \PDO::PARAM_INT);
    	$req->bindValue(':receiverId', $privateMessage->receiverId(), \PDO::PARAM_INT);
    	$req->bindValue(':title', $privateMessage->title());
    	$req->bindValue(':messageCount', $privateMessage->messageCount(), \PDO::PARAM_INT);
        $req->bindValue(':authorIsOn', $privateMessage->authorIsOn(), \PDO::PARAM_INT);
        $req->bindValue(':receiverIsOn', $privateMessage->receiverIsOn(), \PDO::PARAM_INT);
    	$req->execute();

    	return $this->db->lastInsertId();
    }

    public function delete($addWhere, $condition = null)
    {
        $query = 'DELETE FROM privatemessage WHERE ';

        $query = $this->createQuery($addWhere, $query, $condition);

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }

        $req->execute();
    }

    public function get($id)
    {
    	$this->db->query('SET lc_time_names = \'fr_FR\'');

    	$req = $this->db->prepare('SELECT privatemessage.id AS id, authorId, receiverId, title, messageCount, lastPMId, authorIsOn, receiverIsOn, ua.login AS authorName, ub.login AS receiverName, creationDate
    		FROM privatemessage
    		LEFT JOIN user ua ON authorId = ua.id
    		LEFT JOIN user ub ON receiverId = ub.id
    		WHERE privatemessage.id = :id');
    	$req->bindValue(':id', $id, \PDO::PARAM_INT);
    	$req->execute();

    	$data = $req->fetch(\PDO::FETCH_ASSOC);

        if(is_null($data['authorName'])) {$data['authorName'] = 'Invité';}

        if($data['authorId'] == 0) {$data['authorName'] = 'Message Automatique';}

        if($data['receiverId'] == 0 OR is_null($data['receiverName'])) {$data['receiverName'] = 'Invité';}

        return ($data) ? new PrivateMessage($data) : '';
    }

    public function getAll($userId, $addWhere)
    {
    	$messages = null;

    	$this->db->query('SET lc_time_names = \'fr_FR\'');

    	$req = $this->db->prepare('SELECT privatemessage.id AS id, authorId, privatemessage.receiverId AS receiverId, title, messageCount, lastPMId, authorIsOn, receiverIsOn, ua.login AS authorName, ub.login AS receiverName, creationDate, viewpm.receiverId AS receiverIdView, isRead
    		FROM privatemessage
    		LEFT JOIN user ua ON privatemessage.authorId = ua.id
    		LEFT JOIN user ub ON receiverId = ub.id
    		LEFT JOIN viewpm ON lastPMId = contentId AND :userId = viewpm.receiverId'
    		.$addWhere.
    		'ORDER BY creationDate DESC');
    	$req->bindValue(':userId', $userId, \PDO::PARAM_INT);
    	$req->execute();

    	while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            if(is_null($data['authorName'])) {$data['authorName'] = 'Invité';}

            if($data['authorId'] == 0) {$data['authorName'] = 'Message Automatique';}

            if($data['receiverId'] == 0 OR is_null($data['receiverName'])) {$data['receiverName'] = 'Invité';}

            $messages[] = new PrivateMessage($data);
        }

        return $messages;
    }

    public function update(PrivateMessage $privateMessage)
    {
        $req = $this->db->prepare('UPDATE privatemessage SET title = :title, messageCount = :messageCount, lastPMId = :lastPMId, authorIsOn = :authorIsOn, receiverIsOn = :receiverIsOn WHERE id = :id');

    	$req->bindValue(':title', $privateMessage->title());
    	$req->bindValue(':messageCount', $privateMessage->messageCount(), \PDO::PARAM_INT);
    	$req->bindValue(':lastPMId', $privateMessage->lastPMId(), \PDO::PARAM_INT);
        $req->bindValue(':authorIsOn', $privateMessage->authorIsOn(), \PDO::PARAM_INT);
        $req->bindValue(':receiverIsOn', $privateMessage->receiverIsOn(), \PDO::PARAM_INT);
    	$req->bindValue(':id', $privateMessage->id(), \PDO::PARAM_INT);
    	$req->execute();
    }

    public function updateAll($addSet, $addWhere)
    {
        $req = $this->db->prepare('UPDATE privatemessage SET '.$addSet['champ'].' = :setValue WHERE '.$addWhere['champ'][0].' = :whereValue');

        $req->bindValue(':whereValue', $addWhere['value'][0], \PDO::PARAM_INT);
        $req->bindValue(':setValue', $addSet['value'], \PDO::PARAM_INT);
        $req->execute();
    }
}
