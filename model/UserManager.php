<?php

namespace model;

use \model\entity\User;

class UserManager extends Manager
{
    public function add(User $user)
    {
        if(!$user->employee())
        {
            $req = $this->db->prepare('INSERT INTO user (email, login, password, employee, suscribeDate, lastLogin, askVerification) VALUES (:email, :login, :password, :employee, NOW(), NOW(), 0)');
        }
        else
        {
            $req = $this->db->prepare('INSERT INTO user(email, login, name, lastname, password, employee, suscribeDate, lastLogin, askVerification) VALUES (:email, :login, :name, :lastname, :password, :employee, NOW(), NOW(), 1)');

            $req->bindValue(':name', $user->name());
            $req->bindValue(':lastname', $user->lastname());
            $req->bindValue(':matricule', $user->matricule());
        }

        $req->bindValue(':email', $user->email());
        $req->bindValue(':login', $user->login());        
        $req->bindValue(':password', $user->getCryptedPassword());
        $req->bindValue(':employee', $user->employee(), \PDO::PARAM_INT);

        $req->execute();   
    }

    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM user')->fetchColumn();
    }    

    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM user WHERE id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();
    }

    public function exists($info)
    {
        if(is_int($info))
        {
            $req = $this->db->query('SELECT COUNT(*) FROM user WHERE id = :id');
            $req->bindValue(':id', $info, \PDO::PARAM_INT);
        }
        else
        {
            $req = $this->db->prepare('SELECT COUNT(*) FROM user WHERE login = :login OR email = :login');
            $req->bindValue(':login', $info);
        }

        $req->execute();

        return (bool) $req->fetchColumn();
    }

    public function get($info)
    {
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

    public function getAll($addWhere = null)
    {
        $users = [];

        $req = $this->db->query('SELECT id, email, login, avatar, name, lastname, matricule, phoneNumber, password, employee, suscribeDate, lastLogin, rank, onContact, accountLocked, seeEmail, seePhoneNumber, seeName, seeLastName FROM user'.$addWhere);

        while($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $users[] = new User($data);
        }

        return $users;
    }

    public function search($login)
    {
        $users = [];

        $req = $this->db->prepare('SELECT id, email, login, avatar, name, lastname, matricule, phoneNumber, password, employee, suscribeDate, lastLogin, rank, onContact, accountLocked, seeEmail, seePhoneNumber, seeName, seeLastName FROM user WHERE login LIKE :login');
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
        $req = $this->db->prepare('UPDATE user SET email = :email, login = :login, name = :name, lastname = :lastname, matricule = :matricule, phoneNumber = :phoneNumber, password = :password, employee = :employee, lastLogin = NOW(), rank = :rank, onContact = :onContact, askVerification = :askVerification, accountLocked = :accountLocked WHERE id = :id');
        $req->bindValue(':id', $user->id(), \PDO::PARAM_INT);
        $req->bindValue(':email', $user->email());
        $req->bindValue(':login', $user->login());
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
