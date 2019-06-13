<?php

namespace model\gateway;

use app\src\App;

class UserGateway
{
    /**
     * @var \PDO
     */
    private $conn;

    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    private $pseudo;

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name): void
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password=$password;
        //$this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @return mixed
     */
    public function getInfoPerso()
    {
        return $this->info_perso;
    }

    /**
     * @param mixed $info_perso
     */
    public function setInfoPerso($info_perso): void
    {
        $this->info_perso = $info_perso;
    }

    private $user_name;

    private $password;

    private $info_perso;

    private $birth;

    /**
     * @return mixed
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * @param mixed $birth
     */
    public function setBirth($birth): void
    {
        $this->birth = $birth;
    }

    public function __construct(App $app)
    {
        $this->conn = $app->getService('database')->getConnection();
    }


    public function insert() : void
    {
        $query = $this->conn->prepare('INSERT INTO user (user_name, pseudo, password, birth) VALUES (:user_name, :pseudo, :password, :birth)');
        $executed = $query->execute([
            ':user_name' => $this->user_name,
            ':pseudo' => $this->pseudo,
            ':password' => $this->password,
            ':birth' => $this->birth
        ]);

        if(!$executed) throw new \Error('Insert Failed');

        $this->id = $this->conn->lastInsertId();
    }

    public function update() : void
    {
        if(!$_SESSION['id']) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('UPDATE user SET pseudo = :pseudo, birth = :birth, info_perso = :info_perso WHERE id = :id');
        $executed = $query->execute([
            ':pseudo' => $this->pseudo,
            ':birth' => $this->birth,
            ':info_perso' => $this->info_perso,
            ':id' => $_SESSION['id']
        ]);

        if(!$executed) throw new \Error('Update failed');

    }

    public function delete() : void
    {
        if(!$this->id) throw new \Error('Instance does not exist in base');

        $query = $this->conn->prepare('DELETE FROM city WHERE id = :id');
        $executed = $query->execute([
            ':name' => $this->name,
            ':country' => $this->country,
            ':life' => $this->life,
            ':id' => $this->id
        ]);

        if(!$executed) throw new \Error('Delete failed');

    }

    public function hydrate($element)
    {
        $this->user_name = $element['user_name'];
        $this->info_perso = $element['info_perso'];
        $this->pseudo = $element['pseudo'];
        $this->birth = $element['birth'];
        $this->id = $element['id'];

    }

}