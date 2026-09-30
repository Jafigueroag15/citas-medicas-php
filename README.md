# Sistema de Citas Médicas - PHP + MySQL + XAMPP

Versión corregida para práctica académica.

## IMPORTANTE

El archivo `database/citas_medicas.sql` elimina cualquier base de datos previa llamada `citas_medicas` y la crea nuevamente con la estructura correcta.

Esto evita errores como:

`Unknown column 'fecha' in 'order clause'`

## Instalación paso a paso

1. Descomprima la carpeta `citas_medicas_php_corregido`.
2. Cópiela dentro de:

   C:\xampp\htdocs\ADSO_182\

   Por ejemplo:

   C:\xampp\htdocs\ADSO_182\citas_medicas_php_corregido

3. Abra XAMPP Control Panel.
4. Inicie:
   - Apache
   - MySQL

5. Abra en el navegador:

   http://localhost/phpmyadmin

6. Seleccione la pestaña **Importar**.

7. Seleccione el archivo:

   database/citas_medicas.sql

8. Ejecute la importación.

9. Abra la aplicación en:

   http://localhost/ADSO_182/citas_medicas_php_corregido/

## Estructura esperada de la tabla `citas`

- id
- documento
- paciente
- telefono
- correo
- medico
- especialidad
- fecha
- hora
- motivo
- estado
- creado_en

## Conexión predeterminada de XAMPP

- Host: localhost
- Usuario: root
- Contraseña: vacía
- Base de datos: citas_medicas

## Funcionalidades

- Registrar cita
- Listar citas
- Editar cita
- Cambiar estado
- Eliminar cita
