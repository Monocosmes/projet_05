<?php

namespace model;

use \model\entity\AnswerPM;

class AnswerPMManager extends Manager
{
	public function add(AnswerPM $answerPM)
	{
		$req = $this->db->prepare('INSERT INTO answerpm (privateMessageId, authorId, content, creationDate, editDate, edited) VALUES (:privateMessageId, :authorId, :content, NOW(), NOW(), 0)');
		$req->bindValue(':privateMessageId', $answerPM->privateMessageId(), \PDO::PARAM_INT);
		$req->bindValue(':authorId', $answerPM->authorId(), \PDO::PARAM_INT);
		$req->bindValue(':content', $answerPM->content());
		$req->execute();

		return $this->db->lastInsertId();
	}

	public function get($privateMessageId)
	{
		$this->db->query('SET lc_time_names = \'fr_FR\'');

		$req = $this->db->prepare('SELECT id, privateMessageId, authorId, content, DATE_FORMAT(creationDate, \'%d %M %Y à %H:%i:%s\') AS creationDateFr, DATE_FORMAT(editDate, \'%a %d %M %Y à %H:%i:%s\') AS editDateFr, edited, isRead
			FROM answerPM
			WHERE privateMessageId = :privateMessageId
			ORDER BY creationDate
			LIMIT 0, 1');
		$req->bindValue(':privateMessageId', $privateMessageId, \PDO::PARAM_INT);
		$req->execute();

		$data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new AnswerPM($data):'';
	}

	public function getAll($privateMessageId)
	{
		$answers = null;

		$this->db->query('SET lc_time_names = \'fr_FR\'');

		$req = $this->db->prepare('SELECT answerPM.id AS id, privateMessageId, authorId, content, DATE_FORMAT(creationDate, \'%d %M %Y à %H:%i:%s\') AS creationDateFr, DATE_FORMAT(editDate, \'%a %d %M %Y à %H:%i:%s\') AS editDateFr, edited, login AS authorName
			FROM answerPM
			LEFT JOIN user ON authorId = user.id
			WHERE privateMessageId = :privateMessageId
			ORDER BY creationDate');
		$req->bindValue(':privateMessageId', $privateMessageId, \PDO::PARAM_INT);
		$req->execute();

		while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $answers[] = new AnswerPM($data);
        }

        return $answers;
	}
}