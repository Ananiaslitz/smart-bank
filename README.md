## Pré-requisitos
 - Docker
 - Docker Compose

## Configuração do Projeto
### Passo 1: Clonar o Repositório
Clone este repositório para sua máquina local:
```bash
git clone https://github.com/seu-usuario/laravel-payments-api.git
cd laravel-payments-api
```
### Passo 2: Subir os Containers Docker
Execute o comando abaixo para subir os containers Docker:

```bash
docker-compose up -d
```

### Passo 3: Acessar a Aplicação
A aplicação estará disponível em http://localhost:80.

### Passo 4: Conectar ao Container da Aplicação
Conecte-se ao container da aplicação:

```bash 
docker exec -it app bash
```
### Passo 5: Rodar as Migrations e Seeders
Dentro do container, execute os seguintes comandos para rodar as migrations e seeders:

```bash
php artisan migrate
php artisan db:seed
```
### Uso da Aplicação
Após rodar as migrations e seeders, você pode usar a aplicação. Utilize ferramentas como Postman ou Insomnia para interagir com a API. A documentação Swagger da API estará disponível em http://localhost:8080/api/documentation.

### Endpoints
POST /api/v1/register: Registrar um novo usuário
POST /api/v1/login: Fazer login
GET /api/v1/payments: Listar todos os pagamentos
GET /api/v1/payments/{id}: Obter detalhes de um pagamento específico
POST /api/v1/payments: Criar um novo pagamento
Certifique-se de enviar o token JWT no cabeçalho Authorization para acessar os endpoints protegidos.

PS: adicionei o valor do calculo num calpo chamao Fee no pedido.
