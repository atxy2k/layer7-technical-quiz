# Instrucciones

- Clonar el repositorio
- Copiar el archivo .env.example en un archivo nuevo llamado .env
- Colocar las variables necesarias en el archivo .env, el sistema funciona sobre una instancia de Mysql que levanta el mismo laravel sail (personalmente no moví más que el timezone a America/Merida)
- Dado que el desarrollo se hizo sobre laravel sail así que lo ideal es inicializarlo con Docker con el siguiente comando:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
- Una vez levantado, el contendor levanta una propia instancia de mysql, así que solo hay
que posicionarse en el root del proyecto y ejecutar :
```
sail artisan migrate
```
- Una vez levantado los contenedores y ejecutado las migraciones se pueden correr las pruebas unitarias con (asegurarse de que exista la base de datos llamada testing antes)

```
sail artisan test
```
