# CRUD simples com slimframework

Crud de usuarios com injeção de dependencia e pattern DAO, feito com slimframework e com o servidor proprio do php 

## Tecnologias
- [Slimframework](https://www.slimframework.com/) 
- [Insomnia](https://insomnia.rest/download)
- Mysql

- Servidor embutido do [php](https://www.php.net/manual/pt_BR/features.commandline.webserver.php) 

### Instalação das dependencias

```bash
composer require
```
### Inicar aplicação


```bash
php -S localhost:8000
```
## Endpoints
> METODO GET Listar todos o ususarios
- /
>METODO POST - Criar novo Usuario
- /create
>METODO PUT - Atualizar o usuario passando o ID
- /update/{id}
>METODO DELETE - Deleta usuario passando o ID
- /delete/{id}
