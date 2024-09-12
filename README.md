# Projeto LocNav

Simples projeto (LocNav) que busca a localização de embarcações.

## Tecnologias Utilizadas
- [PHP](https://www.php.net/): Linguagem de programação utilizada para desenvolver o projeto.
- [Laravel](https://laravel.com/): Framework utilizado para facilitar o desenvolvimento de aplicações PHP.
- [Composer](https://getcomposer.org/): Ferramenta de gestão de projetos e compilação de código.
- [Docker](https://www.docker.com/): Plataforma utilizada para containerize da aplicação.
- [MySQL](https://www.mysql.com/): Sistema de gestão de banco de dados utilizado.
- [Swagger](https://swagger.io/): Ferramenta para documentação de APIs.
- [PHPUnit](https://phpunit.de/): Ferramenta utilizada para realizar os testes unitários.


## Como subir o projeto

Para subir o projeto, você deve ter o Docker instalado na sua máquina. Em seguida, execute o seguinte comando:
```bash
docker-compose up --build -d
```


## Documentação da API

A documentação Swagger do projeto pode ser acessada através do seguinte link quando o projeto estiver rodando: http://localhost:9000/api/documentation

Comando para atualizar ajustes no Swagger:
```bash
php artisan l5-swagger:generate
```

## Como executar os testes

Para rodar os testes unitários, execute o seguinte comando:

```bash
docker-compose exec app ./vendor/bin/phpunit
```


## Coverage

O relatório de cobertura de testes pode ser encontrado na seguinte URL: [Link para o relatório de cobertura](http://localhost:63342/creational-pattern-factory-method-in-php/tests/Coverage/html/index.html)

Para atualizar o coverage dos testes, execute o comando:

```bash
XDEBUG_MODE=coverage ./vendor/bin/phpunit --coverage-html tests/Coverage/
```

## Autor

Matheus Tadeu - [LinkedIn](https://www.linkedin.com/in/matheus-tadeu-482a00134/)


## Licença

Este projeto está licenciado sob os termos da licença MIT.