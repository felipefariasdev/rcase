angular.module('starter.controllers', [])

.controller('AppCtrl', function($scope, $ionicModal, $timeout) {

})
.controller('RotasCtrl', function($scope,$http) {

    $scope.encontrarCaminho = function (encontrar) {
        $http.get("http://desenvolvedorphprj.com.br/rcase/api/rotas/menor_custo/"+encontrar.origem+"/"+encontrar.destino)
            .then(function(response) {
                $scope.rotas = response.data;
            });


    }

})
.controller('RotasAddCtrl', function($scope,$http) {
    
    $scope.salvarNovaRota = function (rota) {
        $http.post("http://desenvolvedorphprj.com.br/rcase/api/rotas/add",{origem:rota.origem,destino:rota.destino,km:rota.km,nome:rota.nome})
            .then(function(response) {
                $scope.response = response.data;
            });
    }
    

})
;

