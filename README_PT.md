# Crypto bank

Um aplicativo simples de que simula as ações de um banco de forma muito basica, voltada para o estudo e criação de um cli com php.

## Objetivos
* Ser um estudo de [`gitflow`](https://www.atlassian.com/br/git/tutorials/comparing-workflows/gitflow-workflow)
* Ser um estudo de [`conventional commits`](https://www.conventionalcommits.org/en/v1.0.0/)
* Ter o maximo de desacoplamento fazendo o uso de abstrações.
* Criar um CLI (command line interface) que faça todas as oerações.
* Criar uma api rest que consuma esse CLI ao invés de consumir os serviços de forma direta

## Dependecias
Todas as depedencias estão listadas em `compose.json`.

## Tarefas
* Cadastro de correntistas com dados básicos (Nome/Razão Social, CPF/CNPJ, RG/Inscrição estatual, Data de nascimento/Data fundação, telefone e endereço).
* Cada cliente terá um número de conta que será único, e não deve ser a chave primária da tabela.
* Sistema de login para o correntista ter acesso a um ambiente seguro para realizar suas transações.
  * Login precisa ter um log
* Realizar as seguintes transações.
  * Todas as transações devem escrever logs.
  * Depósito - O correntista irá adicionar um valor X na sua conta.
  * Retirada - O correntista poderá retirar um valor X da sua conta.
  * Transferência para outro correntista - O correntista poderá transferir um valor X para a conta de outro correntista do nosso banco, mas não para outros bancos pro enquanto.