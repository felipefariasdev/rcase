# rcase


Mapa mental: https://www.mindmeister.com/779180087/rcase-sistema-de-log-stica

## Sistema de entregas visando sempre o menor custo.


```bash

Com os mapas carregados o requisitante irá procurar o menor valor de entrega e seu caminho.

Para isso ele passará o mapa, nome do ponto de origem, nome do ponto de destino.

Autonomia ex (km/l0) e o valor do litro do combustível ex R$ 2,50.

```

```bash

Inserir rota

Ex via POST:

http://desenvolvedorphprj.com.br/rcase/api/rotas/add

origem: É o local de saida
destino: É o local de destino
km: Qtd de quilimetros 
nome: Nome do caminho ex: pela linha amarela


```


```bash

Encontrar a rota com menor custo

Ex via GET:

http://desenvolvedorphprj.com.br/rcase/api/rotas/menor_custo/SP/RJ

http://desenvolvedorphprj.com.br/rcase/api/rotas/massa/add/{origem}/{destino}

Retorno:

- rota_menor_custo
  origem: É o local de saida
  destino: É o local de destino
  km: Qtd de quilimetros 
  nome: Nome do caminho ex: pela linha amarela

  - rotas_disponiveis (Existe a rota de menor custo, mas exite a opção se selecionar uma das outras rotas)
    origem: x
    destino: x
    km: x
    nome: x



```

```bash

Inserindo rotas em massa

Ex via GET:

http://desenvolvedorphprj.com.br/rcase/api/rotas/massa/add/SP/RJ/50

http://desenvolvedorphprj.com.br/rcase/api/rotas/massa/add/{origem}/{destino}/{qtd_insert}

qtd_insert: 50 - é a quantidade de opções de caminhos que será inserido com a origem SP e destino RJ



```
