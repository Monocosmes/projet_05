<?php

class CategoryManager extends Manager
{
	public function get($id)
	{
		$req = $this->db->prepare('SELECT id, name FROM categories WHERE id = :id');
		$req->bindValue('id', $id, PDO::PARAM_INT);
		$req->execute();

		$data = $req->fetch(PDO::FETCH_ASSOC);

        return ($data)?new Category($data):'';
	}

	public function getAll()
	{
		$categories = null;

		$req = $this->db->query('SELECT id, name FROM categories');

		while($data = $req->fetch(PDO::FETCH_ASSOC))
        {
            $categories[] = new Category($data);
        }

        return $categories;
	}

	public function add(Category $category)
	{
		$req = $this->db->prepare('INSERT INTO categories(name) VALUES(:name)');
		$req->bindValue(':name', $category->name());
		$req->execute();
	}
}