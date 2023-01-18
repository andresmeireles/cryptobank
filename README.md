# Crypto bank

Um aplicativo simples de que simula as ações de um banco de forma muito basica, voltada para o estudo e criação de um cli com php.

# Considerações
Esse projeto faz parte de trilhas de aprendizado de uma empresa, o desafio era fazer uma aplicação que funcionasse como 
uma api REST, mas achei interessante fazer o porjeto com um cli que pudesse receber camadas de todos os tipos, seja uma
api REST ou mesmo uma camada de GRAPHQL

## Objetivos
* Ser um estudo de [`gitflow`](https://www.atlassian.com/br/git/tutorials/comparing-workflows/gitflow-workflow)
* Ser um estudo de [`conventional commits`](https://www.conventionalcommits.org/en/v1.0.0/)
* Ter o maximo de desacoplamento fazendo o uso de abstrações.
* Criar um CLI (command line interface) que faça todas as oerações.
* Criar uma api rest que consuma esse CLI ao invés de consumir os serviços de forma direta

## Dependecias
Todas as depedencias estão listadas em `compose.json`.

## Develop
* Execute o comando `docker compose up -d` na raiz do projeto.
