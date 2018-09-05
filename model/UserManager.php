<?php

namespace model;

use \model\entity\User;

class UserManager extends Manager
{
    public function add(User $user)
    {
        $req = $this->db->prepare('INSERT INTO user(email, login, name, lastname, matricule, password, employee, suscribeDate, askVerification) VALUES (:email, :login, :name, :lastname, :matricule, :password, :employee, NOW(), :askVerification)');

        $req->bindValue(':email', $user->email());
        $req->bindValue(':login', $user->login());
        $req->bindValue(':name', $user->name());
        $req->bindValue(':lastname', $user->lastname());
        $req->bindValue(':matricule', $user->matricule());
        $req->bindValue(':password', $user->password());
        $req->bindValue(':employee', $user->employee(), \PDO::PARAM_INT);        
        $req->bindValue(':askVerification', $user->askVerification(), \PDO::PARAM_INT);

        $req->execute();   
    }

    public function count($addWhere = null)
    {
        return $this->db->query('SELECT COUNT(*) FROM user'.$addWhere)->fetchColumn();
    }    

    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM user WHERE id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();
    }

    public function exists($data)
    {
        if(is_int($data))
        {
            $req = $this->db->prepare('SELECT COUNT(*) FROM user WHERE id = :id');
            $req->bindValue(':id', $data, \PDO::PARAM_INT);
        }
        else
        {
            $req = $this->db->prepare('SELECT COUNT(*) FROM user WHERE login = :data OR email = :data OR matricule = :data');
            $req->bindValue(':data', $data);
        }

        $req->execute();

        return (bool) $req->fetchColumn();
    }

    public function get($info)
    {
        $this->db->query('SET lc_time_names = \'fr_FR\'');

        if(is_int($info))
        {
            $req = $this->db->prepare('SELECT id, email, login, avatar, name, lastname, matricule, phoneNumber, password, employee, suscribeDate, lastLogin, rank, onContact, askVerification, accountLocked, seeEmail, seePhoneNumber, seeName, seeLastName FROM user WHERE id = :id');
            $req->bindValue(':id', $info, \PDO::PARAM_INT);
        }
        else
        {
            $req = $this->db->prepare('SELECT id, email, login, avatar, name, lastname, matricule, phoneNumber, password, employee, suscribeDate, lastLogin, rank, onContact, askVerification, accountLocked, seeEmail, seePhoneNumber, seeName, seeLastName FROM user WHERE login = :login OR email = :login');
            $req->bindValue(':login', $info);
        }
      
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);

        return ($data)?new User($data):'';
    }

    public function getAll($addWhere = null, $addOrder = null, $addLimit = null, $condition = null)
    {
        $users = [];

        $query = 'SELECT id, email, login, avatar, name, lastname, matricule, phoneNumber, password, employee, suscribeDate, lastLogin, rank, onContact, accountLocked, seeEmail, seePhoneNumber, seeName, seeLastName FROM user';

        if($addWhere)
        {
            $query .= ' WHERE ';

            $query = $this->createQuery($addWhere, $query, $condition);
        }

        if($addOrder) {$query .= $addOrder;}
        if($addLimit) {$query .= $addLimit;}

        $req = $this->db->prepare($query);

        if($addWhere)
        {
            for($i = 0; $i < count($addWhere['value']); $i++)
            {
                $req->bindValue(':value'.$i, $addWhere['value'][$i]);
            }
        }

        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $users[] = new User($data);
        }

        return $users;
    }

    public function lastLogin(User $user)
    {
        $req = $this->db->prepare('UPDATE user SET lastLogin = NOW() WHERE id = :id');
        $req->bindValue(':id', $user->id(), \PDO::PARAM_INT);
        $req->execute();
    }

    public function search($login)
    {
        $users = [];

        $req = $this->db->prepare('SELECT id, email, login, avatar, rank, accountLocked FROM user WHERE login LIKE :login');
        $req->bindValue(':login', $login);
        $req->execute();

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $users[] = new User($data);
        }

        return $users;
    }

    public function update(User $user)
    {
        $req = $this->db->prepare('UPDATE user SET email = :email, login = :login, avatar = :avatar, name = :name, lastname = :lastname, matricule = :matricule, phoneNumber = :phoneNumber, password = :password, employee = :employee, rank = :rank, onContact = :onContact, askVerification = :askVerification, accountLocked = :accountLocked WHERE id = :id');
        $req->bindValue(':id', $user->id(), \PDO::PARAM_INT);
        $req->bindValue(':email', $user->email());
        $req->bindValue(':login', $user->login());
        $req->bindValue(':avatar', $user->avatar());
        $req->bindValue(':name', $user->name());
        $req->bindValue(':lastname', $user->lastname());
        $req->bindValue(':matricule', $user->matricule());
        $req->bindValue(':phoneNumber', $user->phoneNumber());
        $req->bindValue(':password', $user->password());
        $req->bindValue(':employee', $user->employee(), \PDO::PARAM_INT);
        $req->bindValue(':rank', $user->rank(), \PDO::PARAM_INT);
        $req->bindValue(':onContact', $user->onContact(), \PDO::PARAM_INT);
        $req->bindValue(':askVerification', $user->askVerification(), \PDO::PARAM_INT);
        $req->bindValue(':accountLocked', $user->accountLocked(), \PDO::PARAM_INT);
        $req->execute();

    }

    public function updateSettings(User $user)
    {
        $req = $this->db->prepare('UPDATE user SET onContact = :onContact, seeEmail = :seeEmail, seePhoneNumber = :seePhoneNumber, seeName = :seeName, seeLastName = :seeLastName WHERE id = :id');
        $req->bindValue(':onContact', $user->onContact(), \PDO::PARAM_INT);
        $req->bindValue(':seeEmail', $user->seeEmail(), \PDO::PARAM_INT);
        $req->bindValue(':seePhoneNumber', $user->seePhoneNumber(), \PDO::PARAM_INT);
        $req->bindValue(':seeName', $user->seeName(), \PDO::PARAM_INT);
        $req->bindValue(':seeLastName', $user->seeLastName(), \PDO::PARAM_INT);
        $req->bindValue(':id', $user->id(), \PDO::PARAM_INT);

        $req->execute();
    }    
}
