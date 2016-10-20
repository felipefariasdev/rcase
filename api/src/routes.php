<?php
use Model\Dao\DaoRotas;
use Model\Entity\Rotas;

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

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'inicio.phtml', $args);
});

