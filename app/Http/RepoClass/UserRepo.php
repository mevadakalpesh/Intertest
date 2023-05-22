<?php
namespace App\Http\RepoClass;

use App\Models\User;
use App\Http\RepoInterface\UserInterfaceRepo;

class UserRepo implements UserInterfaceRepo {
    public function __construct(
        public User $user
    ){
    }

    public function getUsers(Array $where  = []){
        return $this->user->where($where)->get();
    }

    public function getUser(Array $where  = [],Array $with = []){
        return $this->user->with($with)->where($where)->first();
    }
    public function createUser(Array $data){
        return $this->user->create($data);
    }
    public function updateUser(Array $where ,Array $data){
        return $this->user->where($where)->update($data);
    }
    public function deleteUser(Array $where){
        return $this->user->where($where)->delete();
    }
}


