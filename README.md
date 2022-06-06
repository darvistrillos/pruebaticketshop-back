# pruebaticketshop-back
## Prueba para TicketShop - Backend


 ###### **Laravel Framework 8.83.15**


**Pasos para clonar el proyecto**


- <sup>git clone https://github.com/darvistrillos/pruebaticketshop-back.git</sup>

- <sup>cd prueba ticketshop-back</sup>

- <sup>composer install</sup>

- <sup>php artisan key:generate</sup>

- En el archivo .env modificar el parametro <sup>DB_DATABASE=tickets</sup> y lo necesario para conectar a la base de datos

- <sup>php artisan migrate</sup>

o

- Restaurar la base de datos tickets de MySQL que se encuentra en el repositorio

***Dentro del repositorio se encuentra tambien la documentacion en postman que muestra los ejemplos de consumo de la app
y la autenticación en la sección Authorization para los puntos de acceso que necesitan autorizacion se debe usar con el token generado desde el punto de acceso login.***