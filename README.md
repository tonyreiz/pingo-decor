# Pingo Decor

## Rodar depois de clonar

Com Docker e Docker Compose instalados, na raiz do repositório execute:

```sh
docker compose up --build
```

Na primeira inicialização, o MySQL cria o banco `db_pingodecor` e carrega os dados de demonstração de `docker/mysql/Pingodecor.sql`. O container da aplicação instala as dependências PHP quando necessário e executa `php artisan migrate`, que cria as tabelas restantes. Os dados do MySQL ficam no volume Docker `mysql_data`.

A aplicação fica em <http://localhost:8001> e o phpMyAdmin em <http://localhost:8081>.

O script SQL de inicialização é executado pelo MySQL apenas quando o volume de dados é criado pela primeira vez. As migrations continuam sendo executadas ao iniciar a aplicação, inclusive quando já existe um volume.
