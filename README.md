# Hofmann API

## Tecnologías

- **Backend:** Laravel 11
- **Frontend:** Vue.js

## Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local:

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/nicjergsen/hofmann-api.git
   cd hofmann-api

2. **Instala las dependencias:**

    ```bash
    composer install
    npm install

3. **Copia el archivo de configuración de ejemplo y configura tu entorno:**

    ```bash
    cp .env.example .env

- Edita el archivo .env con las credenciales correspondientes

4. **Genera la clave de la app:**
    ```bash
    php artisan key:generate

5. **Compila los assets del frontend:**
    ```bash
    npm run build

6. **Levanta el sitio:**
    ```bash
    php artisan serve


## Uso

### Requerimientos

1.- Crear proyecto en Laravel, que cuente con una tabla con los campos ID, Código, Monto (Formato con separadores de miles), Fecha (Formato dd-mm-yyyy) y Acciones (Debe tener un botón llamado editar) , información de API(ListTableUsers).

2.- Al pulsar botón mostrar modal con la información que estaba en la tabla en formato de formulario.

3.- En el Modal el campo Code debe ser visualizado en un select con los datos de la información de API (GetUsers)

4.- Agregar un botón en el formulario del modal para enviar los datos a API (SendUser)   con el json descrito abajo , además modificando el campo Code e incluyendo el campo User con su usuario de GitHub.
Datos de ejemplo:
{
	“Id” : 15,
	“Code”: “V081”
	“Amount”: 2397102
	“Date”: “2024-07-05T15:01:43.170Z”
	“Github”: “https://github.com/markjamestest”
}
Nota: Este devolverá un estatus 200, si se realizó correctamente y estos cambios no se verán reflejados en API (ListTableUsers).
