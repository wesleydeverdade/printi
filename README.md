## Teste Printi

Olá, neste arquivo estarei explicando como rodar minha aplicação e descrevendo a motivação das minhas escolhas técnicas/stack.

## Por que Laravel?

Hoje, o principal framework do mercado é Laravel, tanto em número absolutos de utilização quanto em contribuição da comunidade, seja com bibliotecas seja com material didático.
E também porque eu gosto bastante ;)

## O que eu fiz:

Uma api, com cadastro de usuário e autenticação JWT, para cadastrar filmes e categorias. As rotas estão em "/routes/api.php".

Um filme pode ter uma categoria, que é obrigatória. 
Usuários podem cadastrar filmes e categorias, que deverão ser únicas (entre todos os usuários do sistema).
Somente usuários cadastrados e autenticados conseguem consumir os recursos de filmes e categorias.

Na raiz do projeto há um arquivo "Printi.postman_collection.json", para importar no Postman e conseguir visualizar a API.

## Laravel Sail

Escolhi o Laravel Sail pela facilidade e velocidade de sair desenvolvendo num ambiente "dockerizado".

Para subir o ambiente, basta na raiz do projeto rodar o comando:

```
./vendor/bin/sail up 
```

ou, para em modo detached;


```
./vendor/bin/sail up -d
```

No entanto, em vez de digitar vendor/bin/sail repetidamente para executar os comandos do Sail, podes configurar um alias de shell que permita executar os comandos do Sail com mais facilidade:


```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Daqui para frente na documentação vou considerar que o alias fora configurado

```
sail up -d
```

Para parar a execução dos containers do ambiente

```
sail stop
```

## Banco de dados

Escolhi MySQL para o banco de dados da aplicação e para os testes automatizados sqlite em memória. MySQL é o banco de dados que tenho mais afinidade e sqlite por ser leve, para os testes cumpre bem o próposito. Para realizar as migrations do banco de dados:

```
sail artisan migrate
```

## Testes automatizados

Para realizar os testes automatizados

```
sail artisan test
```

Os arquivos estão localizados em: "tests/Feature/Api/"


## Rotas

A partir de http://localhost:8080/api/

### Para filmes:

#### Request

`[GET] / movies`

#### Request

`[GET] / movies / :id`

#### Request

`[POST] / movies`

Body

`
{
"name": "Forrest Gump", 
"category_id": 1
}`

#### Request

`[PUT] / movies / :id`

Body

`
{
"name": "The Godfather",
"category_id": 2
}`

#### Request

`[DELETE] / movies / :id`

### Para Categorias:

#### Request

`[GET] / categories`

#### Request

`[GET] / categories / :id`

#### Request

`[POST] / categories`

Body

`
{
"name": "Thriller"
}`

#### Request

`[PUT] / categories / :id`

Body

`
{
"name": "Comedy"
}`

#### Request


`[DELETE] / categories / :id`

### Para Criação de Usuário:

#### Request

`[POST] / register`

Body

`
{
"name": "John Doe", "email": "test@example.com", "password": "ZK@vVWLWk#9w$A3r"
}`

### Para Autenticação de Usuário:

#### Request

`[POST] / login`

Body

`
{
"email": "test@example.com", "password": "ZK@vVWLWk#9w$A3r" 
}`
