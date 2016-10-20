<?php

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'inicio.phtml', $args);
});

