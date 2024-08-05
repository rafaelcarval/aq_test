
# Teste Febrapar

Objetivo: O desafio é desenvolver um sistema de gerenciamento de tarefas.

### Passo a passo
Clone Repositório
```sh
git clone https://github.com/rafaelcarval/aqbank_test
```
```sh
cd aqbank_test/
```
Crie o Arquivo .env
```sh
cp .env.example .env
```

Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```

Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Gerar as migrations
```sh
php artisan migrate
```

Gerar o primeiro usuário
```sh
php artisan db:seed
```

Inicializar a fila (queue)
```sh
php artisan queue:work
```

Caso haja erros de permissões
```sh
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
```

Acessar o projeto - api Swagger via auto scan
[http://localhost/api-docs-ui#//](http://localhost/api-docs-ui#/)




Testes unitários
```sh
php artisan test
```


Além dos testes unitários, disponibilizei via e-mail a collection do postman com testes completos
