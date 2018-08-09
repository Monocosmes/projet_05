<?php

class UserManager extends Manager
{
    public function add(User $user)
    {        
        $req = $this->db->prepare('INSERT INTO user(email, login, name, lastname, password, suscribeDate, lastLogin) VALUES (:email, :login, :name, :lastname, :password, NOW(), NOW())');
        $req->bindValue(':email', $user->email());
        $req->bindValue(':login', $user->login());
        $req->bindValue(':name', $user->name());
        $req->bindValue(':lastname', $user->lastname());
        $req->bindValue(':password', $user->getCryptedPassword());

        $req->execute();   
    }

    public function count()
    {
        return $this->db->query('SELECT COUNT(*) FROM user')->fetchColumn();
    }    

    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM user WHERE id = :id');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }

    public function exists($info)
    {
        if(is_int($info))
        {
            $req = $this->db->query('SELECT COUNT(*) FROM user WHERE id = :id');
            $req->bindValue(':id', $info, PDO::PARAM_INT);
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
            $req = $this->db->prepare('SELECT id, email, login, name, lastname, password, suscribeDate, lastLogin, rank, accountLocked FROM user WHERE id = :id');
            $req->bindValue(':id', $info, PDO::PARAM_INT);
        }
        else
        {
            $req = $this->db->prepare('SELECT id, email, login, name, lastname, password, suscribeDate, lastLogin, rank, accountLocked FROM user WHERE login = :login OR email = :login');
            $req->bindValue(':login', $info);
        }
      
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        return ($data)?new User($data):'';
    }    
}
