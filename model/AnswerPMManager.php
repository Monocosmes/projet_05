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

	public function delete($addWhere, $condition = null)
	{
		$query = 'DELETE FROM answerpm WHERE ';

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

		$req = $this->db->prepare('SELECT answerPM.id, privateMessageId, authorId, content, creationDate, editDate, edited, login AS authorName
			FROM answerPM
			LEFT JOIN user ON authorId = user.id
			WHERE answerPM.id = :id');
		$req->bindValue(':id', $id, \PDO::PARAM_INT);
		$req->execute();

		$data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new AnswerPM($data):'';
	}

	public function getAll($privateMessageId)
	{
		$answers = null;

		$this->db->query('SET lc_time_names = \'fr_FR\'');

		$req = $this->db->prepare('SELECT answerPM.id AS id, privateMessageId, authorId, content, creationDate, editDate, edited, login AS authorName
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

	public function update(AnswerPM $answerPM)
	{
		$req = $this->db->prepare('UPDATE answerpm SET content = :content, editDate = NOW(), edited = :edited WHERE id = :id');
		$req->bindValue(':id', $answerPM->id(), \PDO::PARAM_INT);
		$req->bindValue(':content', $answerPM->content());
		$req->bindValue(':edited', $answerPM->edited(), \PDO::PARAM_INT);
		$req->execute();
	}
}