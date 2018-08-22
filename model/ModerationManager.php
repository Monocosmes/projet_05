<?php

/**
 * summary
 */
namespace model;

use \model\entity\Moderation;

class ModerationManager extends Manager
{
	public function add(Moderation $moderation)
	{
		$req = $this->db->prepare('INSERT INTO moderation(moderationMessage) VALUES(:moderationMessage)');
		$req->bindValue(':moderationMessage', $moderation->getModerationMessage());
		$req->execute();
	}

	public function getAll()
	{
		$moderationMessages = null;

		$req = $this->db->query('SELECT id, moderationMessage FROM moderation');

		while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $moderationMessages[] = new Moderation($data);
        }

        return $moderationMessages;
	}
}