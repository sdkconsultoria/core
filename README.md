SDK Consultoría Core
====

Descripción
------------
- Creacion de APIs
- Generador de crud

Instalación
------------
EL mejor modo de instalar esta extencion es por medio de composer.

Ejecutando el comando

```
composer require sdkconsultoria/core
```

inicializar libreria

```
php artisan sdk:core-install && php artisan sdk:permissions
```

crear usuario con su token
```
php artisan sdk:users email=admin@sdkconsultoria.com --token
```

