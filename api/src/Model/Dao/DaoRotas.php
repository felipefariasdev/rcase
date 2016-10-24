<?php
namespace Model\Dao;
use Model\Entity\Rotas;
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
    public function getMenorCusto($obj){

        try{
            $this->cn->beginTransaction();

            $start = microtime(true);

            $sql = "SELECT id,origem,destino,km,nome FROM rotas WHERE (origem=:origem and destino=:destino) ORDER BY km ASC LIMIT 1";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":origem", $obj->getOrigem(), PDO::PARAM_STR);
            $res->bindParam(":destino", $obj->getDestino(), PDO::PARAM_STR);
            if($res->execute()){
                $rotas_obj    = $res->fetch(PDO::FETCH_OBJ);
                $this->cn->commit();

                $total              = (microtime(true) - $start);
                $tempoDeExecucao    = number_format($total, 3);
                $data                    = new stdClass();
                $data->success           = true;
                $data->error             = false;
                $data->tempoDeExecucao   = $tempoDeExecucao;
                $data->rowCount          = $res->rowCount();
                $data->rota_menor_custo  = $rotas_obj;
                $data->rotas_disponiveis = $this->getRotasDisponiveis($obj);
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

    private function getRotasDisponiveis($obj){

        try{
            $this->cn->beginTransaction();

            $start = microtime(true);

            $sql = "SELECT id,origem,destino,km,nome FROM rotas WHERE (origem=:origem and destino=:destino)";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":origem", $obj->getOrigem(), PDO::PARAM_STR);
            $res->bindParam(":destino", $obj->getDestino(), PDO::PARAM_STR);
            if($res->execute()){
                $rotas_obj    = $res->fetchAll(PDO::FETCH_OBJ);
                $this->cn->commit();

                $total              = (microtime(true) - $start);
                $tempoDeExecucao    = number_format($total, 3);
                $data                   = new stdClass();
                $data->success          = true;
                $data->error            = false;
                $data->tempoDeExecucao  = $tempoDeExecucao;
                $data->rowCount         = $res->rowCount();
                $data->rotas            = $rotas_obj;
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