<?php
namespace App\Http\RepoInterface;

interface ProductInterfaceRepo{
    public function getProducts(Array $where  = []);
    public function getProduct(Array $where  = [],Array $with  = [],);
    public function createProduct(Array $data);
    public function updateProduct(Array $where ,Array $data);
    public function deleteProduct(Array $where);


}
