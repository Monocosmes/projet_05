<?php

namespace model;

use \model\entity\ViewPM;

class ViewPMManager extends Manager
{
	public function add(ViewPM $viewPM)
	{
		$req = $this->db->prepare('INSERT INTO viewpm (receiverId, titleId, contentId, lastPMView, isRead) VALUES (:receiverId, :titleId, :contentId, :lastPMView, :isRead)');
		$req->bindValue(':receiverId', $viewPM->receiverId(), \PDO::PARAM_INT);
		$req->bindValue(':titleId', $viewPM->titleId(), \PDO::PARAM_INT);
		$req->bindValue(':contentId', $viewPM->contentId(), \PDO::PARAM_INT);
		$req->bindValue(':lastPMView', (int) $viewPM->lastPMView(), \PDO::PARAM_INT);
		$req->bindValue(':isRead', (int) $viewPM->isRead(), \PDO::PARAM_INT);

		$req->execute();
	}

	public function count($receiverId)
	{
		$req = $this->db->prepare('SELECT COUNT(*) FROM viewpm WHERE receiverId = :receiverId AND isRead = 0');
		$req->bindValue(':receiverId', $receiverId, \PDO::PARAM_INT);
		$req->execute();

		$data = $req->fetchColumn();

		return $data;
	}

	public function delete($addWhere, $condition = null)
	{
		$query = 'DELETE FROM viewpm WHERE ';

		$query = $this->createQuery($addWhere, $query, $condition);

        $req = $this->db->prepare($query);

        for($i = 0; $i < count($addWhere['value']); $i++)
        {
            $req->bindValue(':value'.$i, $addWhere['value'][$i]);
        }

		$req->execute();
	}

	public function get($receiverId, $contentId)
	{
		$req = $this->db->prepare('SELECT receiverId, contentId, titleId, lastPMView, isRead FROM viewpm WHERE receiverId = :receiverId AND contentId = :contentId');
		$req->bindValue(':receiverId', $receiverId, \PDO::PARAM_INT);
		$req->bindValue(':contentId', $contentId, \PDO::PARAM_INT);

		$req->execute();

		$data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data) ? new ViewPM($data) : '';
	}

	public function getLastPMView(ViewPM $viewPM)
	{
		$req = $this->db->prepare('SELECT receiverId, contentId, titleId, lastPMView, isRead FROM viewpm WHERE receiverId = :receiverId AND titleId = :titleId LIMIT 0, 1');
		$req->bindValue(':receiverId', $viewPM->receiverId(), \PDO::PARAM_INT);
		$req->bindValue(':titleId', $viewPM->titleId(), \PDO::PARAM_INT);

		$req->execute();

		$data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data) ? new ViewPM($data) : '';
	}

	public function isRead(ViewPM $viewPM)
	{
		$req = $this->db->prepare('UPDATE viewpm SET isRead = 1, lastPMView = :lastPMView WHERE titleId = :titleId AND receiverId = :receiverId');
		$req->bindValue(':titleId', $viewPM->titleId(), \PDO::PARAM_INT);
		$req->bindValue(':lastPMView', $viewPM->lastPMView(), \PDO::PARAM_INT);
		$req->bindValue(':receiverId', $viewPM->receiverId(), \PDO::PARAM_INT);
		$req->execute();
	}
}
