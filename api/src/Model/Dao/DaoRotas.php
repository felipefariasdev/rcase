<?php

namespace Model\Dao;
use Model\Entity\Rotas;

class DaoRotas
{
    private $cn;

    public function __construct()
    {
        try{
            $this->cn = Connection::getInstance();
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }


}