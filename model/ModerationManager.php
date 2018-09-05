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
		$req->bindValue(':moderationMessage', $moderation->moderationMessage());
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

	public function update(Moderation $moderation)
	{
		$req = $this->db->prepare('UPDATE moderation SET moderationMessage = :moderationMessage WHERE id = :id');
		$req->bindValue(':id', $moderation->id(), \PDO::PARAM_INT);
		$req->bindValue(':moderationMessage', $moderation->moderationMessage());
		$req->execute();
	}
}