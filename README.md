# Projeto API de Gerenciamento de Campanhas e Influenciadores

Este projeto foi desenvolvido como parte de um teste para a empresa Lisa IT. Trata-se de uma API para gerenciamento de campanhas e influenciadores, com as seguintes funcionalidades principais:

## Funcionalidades

1. **Autenticação**
   - Cadastro de usuários
   - Login

2. **Influenciadores**
   - Cadastro e listagem de influenciadores
   - Cadastro de campanhas para influenciadores

3. **Campanhas**
   - Cadastro e listagem de campanhas
   - Associação de influenciadores às campanhas

4. **Categorias**
   - Cadastro e listagem de categorias

## Por que Laravel?
O Laravel foi escolhido para este projeto devido a suas características que o tornam ideal para desenvolvimento ágil e eficiente:

- **Facilidade de uso:** Laravel possui uma curva de aprendizado amigável e uma documentação completa.
- **Pronto para APIs:** A estrutura do Laravel oferece suporte nativo para construção de APIs RESTful.
- **Segurança:** O framework implementa boas práticas de segurança, como proteção contra CSRF e SQL Injection.
- **Comunidade ativa:** A ampla comunidade garante suporte rápido e abundância de pacotes reutilizáveis.
- **Desempenho:** Combinado com ferramentas modernas como Eloquent e cache, o Laravel oferece um desempenho robusto.

Essas vantagens tornam o Laravel uma escolha sólida para um projeto de teste que visa demonstrar boas práticas e eficiência.

## Requisitos

Antes de começar, você precisará ter instalados:

- **Docker**
- **Docker Compose**

## Passo a Passo para Rodar o Projeto

1. **Configuração Inicial**
   - Copie o arquivo `.env.example` para `.env`:
     ```bash
     cp .env.example .env
     ```

2. **Subir os Contêineres**
   - Execute o seguinte comando para subir os contêineres do projeto:
     ```bash
     docker-compose up -d
     ```

3. **Instalar Dependências**
   - Execute o comando abaixo para instalar as dependências do projeto via Composer:
     ```bash
     docker-compose exec app composer install
     ```

4. **Rodar as Migrations**
   - Execute o comando abaixo para criar as tabelas no banco de dados:
     ```bash
     docker-compose exec app php artisan migrate
     ```

5. **Acessar o Projeto**
   - A API estará disponível em:
     ```
     http://localhost/api
     ```

6. **Documentação da API (Swagger)**
   - A documentação Swagger pode ser acessada em:
     ```
     http://localhost/api/documentation
     ```

## Como Iniciar os Testes

1. **Criar um Novo Usuário**
   - Para autenticação no sistema, é necessário criar um novo usuário. Consulte a aba "Auth" na documentação do Swagger para instruções sobre como criar um novo usuário.

2. **Realizar Login**
   - Efetue o login na aplicação para gerar um token JWT. Esse token deverá ser incluído como Bearer Token no cabeçalho das requisições.

3. **Criar Categorias**
   - Acesse o endpoint de categorias para criar as categorias necessárias antes de continuar os testes.

## Tecnologias Utilizadas

- **PHP 8.2**
- **Laravel 10**
- **MySQL 5.7**
- **Nginx**
- **Swagger**
- **JWT (JSON Web Tokens)**
