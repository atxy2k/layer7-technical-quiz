# Instrucciones

- Clonar el repositorio
- Copiar el archivo .env.example en un archivo nuevo llamado .env
- Colocar las variables necesarias en el archivo .env, el sistema funciona sobre una instancia de Mysql que levanta el mismo laravel sail (personalmente no moví más que el timezone a America/Merida)
- Dado que el desarrollo se hizo sobre laravel sail así que lo ideal es inicializarlo con Docker con el siguiente comando en el root del proyecto:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
Esto instalará las dependencias del proyecto, y ahora procederemos a levantarlo con:

```
sail up -d
```
o en su caso:

```
vendor/bin/sail up -d 
```
- Una vez levantado procederemos a seguir los siguientes pasos, generar una llave unica:
```
sail artisan key:generate
```
- El contendor levanta una propia instancia de mysql, así que solo hay que  ejecutar :

```
sail artisan migrate
```
- Una vez levantado los contenedores y ejecutado las migraciones se pueden correr las pruebas unitarias con (asegurarse de que exista la base de datos llamada testing antes)

```
sail artisan test
```
