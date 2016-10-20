# rcase

SisLog

Mapa mental: https://www.mindmeister.com/779180087/rcase-sistema-de-log-stica


Sistema de entregas visando sempre o menor custo.

1 - popular dados via api (formato de malha)
2 - requisitante deverá informar um nome para este mapa.
3 - persistidos para evitar que a cada novo deploy todas as informações desapareçam.

__________________________________________________________________________________________

Com os mapas carregados o requisitante irá procurar o menor valor de entrega e seu caminho, para isso ele passará o mapa, nome do ponto de

origem, nome do ponto de destino, autonomia do caminhão (km/l) e o valor do litro do combustível, agora sua tarefa é criar este Webservices.

Um exemplo de entrada seria, mapa SP, origem A, destino D, autonomia 10, valor do litro 2,50; a resposta seria a rota A B D com custo de 6,25.
