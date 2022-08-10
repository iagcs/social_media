# Readme

# Banco de dados

Para realização do teste pratico, montei um bando de dados com as tabelas de User, Post, PostUser, Likes e Comments. Abaixo estão as tabelas com seus atributos e relações. 

- User

![Captura de Tela 2022-08-10 às 03.48.11.png](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/c3dc3b4b-4126-4eaa-a407-c89eb935bb83/Captura_de_Tela_2022-08-10_s_03.48.11.png)

- Post

![Captura de Tela 2022-08-10 às 03.48.29.png](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/902eb479-2af8-43c7-98c4-f7064f05101d/Captura_de_Tela_2022-08-10_s_03.48.29.png)

- PostUser (tabela pivot)

![Captura de Tela 2022-08-10 às 03.48.42.png](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/ffa57e1f-eab3-4486-8488-55d84e1edb4b/Captura_de_Tela_2022-08-10_s_03.48.42.png)

- Comments

![Captura de Tela 2022-08-10 às 03.48.59.png](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/c213fd5a-9126-4dfa-b78a-0a23e73a000c/Captura_de_Tela_2022-08-10_s_03.48.59.png)

- Likes

![Captura de Tela 2022-08-10 às 03.49.10.png](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/f9d3e61a-db91-4906-b7ab-280f35515fc2/Captura_de_Tela_2022-08-10_s_03.49.10.png)

Optei por utilizar as relations do Laravel, pois alem de ficar visível no próprio código as relações que cada tabela tem, fica mais simples de fazer as query’s, alem de ficar mais legível pra quem nao conhece/desenvolveu o código.

O Laravel nos fornecem diversas ferramentas que facilitam o desenvolvimento. Portanto, com as factory relations, foi possível popular o banco de dados para teste, com poucas linhas de código, como pode ver abaixo.

![Captura de Tela 2022-08-10 às 03.58.57.png](https://s3-us-west-2.amazonaws.com/secure.notion-static.com/52141b5e-a919-4a7c-8a93-f21c3de494c1/Captura_de_Tela_2022-08-10_s_03.58.57.png)

# Como rodar o projeto Laravel 💻

## Necessário na máquina local

- Composer
- PHP v8
- Redis
- MySql
- sqlite

- Copie `env.example` para `.env`
- Entre na pasta do projeto pelo terminal e rode o comando `composer install`.
- Crie um database chamado ’social_media’.
- Rode as migrations no projeto com o comando `php artisan migrate`.
- Em seguida, popule o banco com o comando `php artisan db:seed`.
- Inicie o redis no terminal com o comando `redis-server`.
- Após isso, entre na pasta do projeto e digite o comando `php artisan serve` .
- Para rodar os testes é necessário rodar as migrations no banco de teste “sqlite”
- Portanto, rode o comando `php artisan migrate —database=sqlite`
- Digite `php artisan test` para rodar os teste funcionais
