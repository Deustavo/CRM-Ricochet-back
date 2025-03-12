
# Desafio Ricochet 360 - Backend

Esse projeto é um desafio da empresa Ricochet 360 de criar um sistema CRM de gestão de reuniões.

<br>

## Rotas da API

### Autenticação

#### POST /api/login

Realiza o login do usuário.

**Parâmetros:**

- `email` (string, obrigatório): Email do usuário.
- `password` (string, obrigatório): Senha do usuário.

**Resposta de sucesso:**

- `token` (string): Token de autenticação.
- `token_type` (string): Tipo do token.
- `email` (string): Email do usuário.
- `name` (string): Nome do usuário.

**Resposta de erro:**

- `message` (string): Mensagem de erro.

#### POST /api/register

Registra um novo usuário.

**Parâmetros:**

- `email` (string, obrigatório): Email do usuário.
- `name` (string, obrigatório): Nome do usuário.
- `password` (string, obrigatório): Senha do usuário (mínimo 6 caracteres).

**Resposta de sucesso:**

- `message` (string): Mensagem de sucesso.
- `user` (objeto): Dados do usuário criado.
- `status` (integer): Código de status HTTP.

#### POST /api/logout

Realiza o logout do usuário.

**Parâmetros:**

- Nenhum.

**Resposta de sucesso:**

- `message` (string): Mensagem de sucesso.

### Meetings

#### GET /api/meetings

Retorna todas as reuniões.

**Resposta de sucesso:**

- `meetings` (array): Lista de reuniões.

#### POST /api/meetings

Cria uma nova reunião.

**Parâmetros:**

- `title` (string, obrigatório): Título da reunião.
- `description` (string, opcional): Descrição da reunião.
- `start_time` (datetime, obrigatório): Data e hora de início da reunião.
- `end_time` (datetime, opcional): Data e hora de término da reunião (deve ser após o início).
- `meeting_link` (string, opcional): Link da reunião.
- `attendees` (array, opcional): Lista de IDs dos participantes (deve existir na tabela de usuários).

**Resposta de sucesso:**

- `meeting` (objeto): Dados da reunião criada.

#### GET /api/meetings/{id}

Retorna os detalhes de uma reunião específica.

**Resposta de sucesso:**

- `meeting` (objeto): Dados da reunião.

#### PUT /api/meetings/{id}

Atualiza os dados de uma reunião específica.

**Parâmetros:**

- `title` (string, opcional): Título da reunião.
- `description` (string, opcional): Descrição da reunião.
- `start_time` (datetime, opcional): Data e hora de início da reunião.
- `end_time` (datetime, opcional): Data e hora de término da reunião (deve ser após o início).
- `meeting_link` (string, opcional): Link da reunião.
- `attendees` (array, opcional): Lista de IDs dos participantes (deve existir na tabela de usuários).

**Resposta de sucesso:**

- `meeting` (objeto): Dados da reunião atualizada.

#### DELETE /api/meetings/{id}

Deleta uma reunião específica.

**Resposta de sucesso:**

- `message` (string): Mensagem de sucesso.
- `status` (integer): Código de status HTTP.

<br>
<hr>
<br>

## Instalação do projeto

Suba os containers do projeto

```sh
docker-compose up -d
```

Crie o Arquivo .env

```sh
cp .env.example .env
```

Acesse o container app

```sh
docker-compose exec app bash
```

Instale as dependências do projeto

```sh
composer install
```

Gere a key do projeto Laravel

```sh
php artisan key:generate
```

OPCIONAL: Gere o banco SQLite (caso não use o banco MySQL)

```sh
touch database/database.sqlite
```

Rodar as migrations

```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)
