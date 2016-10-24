<?php
use Model\Dao\DaoRotas;
use Model\Entity\Rotas;

//insert padrão
$app->post('/rotas/add', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();

            $obj = new Rotas();

            $obj->setOrigem($parsedBody["origem"]);
            $obj->setDestino($parsedBody["destino"]);
            $obj->setKm($parsedBody["km"]);
            $obj->setNome($parsedBody["nome"]);

            $dao = new DaoRotas();
            return ($dao->add($obj));

        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

//insert em massa
$app->get('/rotas/teste/add/{origem}/{destino}/{qtd_insert}', function ($request, $response, $args) {

    $qtd_insert = ($args["qtd_insert"]);
    $origem = ($args["origem"]);
    $destino = ($args["destino"]);

    for($i=1;$i<=$qtd_insert;$i++){
        try{
            $km = ($i*10);
            $nome = "caminhos".$i;


            $obj = new Rotas();

            $obj->setOrigem($origem);
            $obj->setDestino($destino);
            $obj->setKm($km);
            $obj->setNome($nome);

            $dao = new DaoRotas();
            return ($dao->getMenorCusto($obj));

        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

//capturar a rota com menor custo e também as outras opções de rotas
$app->get('/rotas/menor_custo/{origem}/{destino}', function ($request, $response, $args) {


    $origem = ($args["origem"]);
    $destino = ($args["destino"]);

        try{

            $obj = new Rotas();

            $obj->setOrigem($origem);
            $obj->setDestino($destino);

            $dao = new DaoRotas();
            echo $dao->getMenorCusto($obj);

        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }

});

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'inicio.phtml', $args);
});

