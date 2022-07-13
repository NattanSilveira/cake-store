# Cake Store

## Instalação

- **Ter a versão mais atual do [Composer](https://getcomposer.org/download/) instalado**
- **Versão do [PHP](https://www.php.net/downloads) 7.2 ou superior.**


### Após realizar o clone do repositório
> - Executar o comando ```composer install```
> - Renomear o ```.env.example``` para ```.env```
> - Executar o comando ```php artisan key:generate```
> - Alterar a conexão no ```.env``` no ```DB_CONNECTION``` de ```mysql``` para ```sqlite```
> - Criar o banco .sqlite ```touch database/database.sqlite```
> - Executar Migration ``` php artisan migrate```

### Acessando o projeto
> - Pode ser usado com o server do próprio artisan; ```php artisan serve```
> - Para realizar o envio efetivo dos email alem da fila deve ser realizada a configuração do provedor de email no .env

### Acessando as rotas
> localhost:8000/api/cake
> > envio da requisição no formato json, Metodo POST
```php
{
	"nome": "teste",
	"peso": 100,
	"qtd_disponivel": 1,
	"interessados": [
		{
			"email": "teste@email.com"
		},
		{
			"email": "teste@teste.com"
		}
		
	]
}
```

> localhost:8000/api/cake/{id}
> > envio da requisição no formato json, Metodo PUT
> Todos são opcionais
```php
{
    "nome": "teste",
    "peso": 2000,
    "qtd_disponivel": 10
}
```

> localhost:8000/api/cake/{id}
> > Metodo DELETE


> > Fila para realizar os envios de email, executar o comando abaixo
```bash
php artisan queue:work --queue=available-mail
```
