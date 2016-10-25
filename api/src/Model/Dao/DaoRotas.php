<?php
namespace Model\Dao;
use Model\Entity\Rotas;
use PDO;
use stdClass;
use Model\Compomentes\JsonEncodePrivate;

class DaoRotas
{
    private $cn; //conexao com o banco
    private $id_menor_custo; //eliminar o caminho principal dos outros caminhos
    private $autonomia_por_livro = 10; //autonomia de kilometros por litro
    private $valor_litro         = 2.50; //valor do litro

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
                $data->rota_menor_custo  = $this->addItem($rotas_obj);

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
                $data->rotas_itens      = $this->addListItens($rotas_obj);
                return ($data);
            }


        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }


    private function addItem($vl){

        $this->id_menor_custo  = $vl->id;

        $obj = new Rotas();
        $obj->setId($vl->id);
        $obj->setOrigem($vl->origem);
        $obj->setDestino($vl->destino);
        $obj->setKm($vl->km);
        $obj->setCusto($this->getCalcularValorCusto($vl->km));
        $obj->setNome($vl->nome);


        return JsonEncodePrivate::execute($obj);
    }
    private function addListItens($l){
        $arrayObjetos = array();
        foreach($l as $vl){

            //eliminar o caminho principal dos outros caminhos
            if($this->id_menor_custo!=$vl->id){
                $obj = new Rotas();
                $obj->setId($vl->id);
                $obj->setOrigem($vl->origem);
                $obj->setDestino($vl->destino);
                $obj->setKm($vl->km);
                $obj->setCusto($this->getCalcularValorCusto($vl->km));
                $obj->setNome($vl->nome);
                $arrayObjetos[] = JsonEncodePrivate::execute($obj);
            }


        }
        return $arrayObjetos;
    }
    private function getCalcularValorCusto($km)
    {
        $qtd_litros = ($km)/$this->autonomia_por_livro;
        return ($qtd_litros * $this->valor_litro);

    }


}