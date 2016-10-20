<?php

namespace Model\Dao;
use PDO;
use stdClass;

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
    public function add($obj){

        try{
            $this->cn->beginTransaction();

            $sql = "INSERT INTO rotas (origem,destino,km,nome) VALUES (:origem,:destino,:km,:nome)";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":origem", $obj->getOrigem(), PDO::PARAM_STR);
            $res->bindParam(":destino", $obj->getDestino(), PDO::PARAM_STR);
            $res->bindParam(":km", $obj->getKm(), PDO::PARAM_STR);
            $res->bindParam(":nome", $obj->getNome(), PDO::PARAM_STR);

            if($res->execute()){

                $this->cn->commit();
                $data                   = new stdClass();
                $data->success          = true;
                $data->error            = false;
                return json_encode($data);

            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }


}