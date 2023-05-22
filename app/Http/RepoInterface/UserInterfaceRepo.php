<?php
namespace App\Http\RepoInterface;

interface UserInterfaceRepo{
    public function getUsers(Array $where  = []);
    public function getUser(Array $where  = [],Array $with  = [],);
    public function createUser(Array $data);
    public function updateUser(Array $where ,Array $data);
    public function deleteUser(Array $where);


}
