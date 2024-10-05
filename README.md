# Back-end Challenge - Coodesh

Esta é uma API para listagem de palavras em inglês. Nela, o usuário é capaz de realizar login, visualizar a lista de palavras, guardar no histórico as palavras já visualizadas, visualizar o histórico de palavras já visualizadas, e guardar ou remover uma palavra dos favoritos.

## Tecnologias utilizadas:
- Docker.
- Nginx.
- PHP.
- Laravel.
- Redis (Para armazenar o CACHE).
- MySQL, com hospedagem na Heroku.

## Instruções para instalação:
## Arquivo .env
- Deve criar uma cópia do arquivo ".env.example" para o arquivo ".env".
- Adicionar as credenciais de acesso ao Banco de Dados.
- Adicionar o nome do Container "redis" em "REDIS_HOST" e em "CACHE_STORE" para configuração do cache.

## Demais instruções
- Acessar o diretório da aplicação e executar o comando: "docker-compose up -d".
- Acessar o container da aplicação em modo "bash", com o comando "docker-compose exec app bash".
- Instalar o composer, com o comando: "composer install".
- executar o comando "php artisan key:generate" para gerar a chave da aplicação.
- Caso o acesso ao Banco de Dados seja local, deve rodar as migrations "php artisan migrate".
- Acessar o EndPoint "/api/upload-txt" para que seja realizada a gravação dos dados no Banco.