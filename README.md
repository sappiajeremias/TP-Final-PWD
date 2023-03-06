<a name="readme-top"></a>

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]

<br />
<div align="center">
    <img src="./Vista/img/logo.png" alt="Logo" width="80" height="80">

  <h3 align="center">Trabajo Práctico Final</h3>

  <p align="center">
    Programación Web Dinámica
    <br />
  </p>
</div>

# Participantes

Laureano Luna - lunalaureanoluna@gmail.com

Braian Centurión - braiankrayan@hotmail.com

Jeremías Sappia - jeremiassappia@gmail.com

Roni Broilo - ronniebroilo@gmail.com

## Objetivos:
El objetivo del trabajo es integrar los conceptos vistos en la materia. Se espera que el alumno implemente una tienda On-Line que tendrá 2 vistas: una vista “pública” y otra “privada”.

* Desde la vista pública se tiene acceso a la información de la tienda: dirección, medios de contacto, descripción y toda aquella información que crea importante desplegar. Además se podrá acceder a la vista privada de la aplicación, a partir del ingreso de un usuario y contraseña válida.
* Desde la vista privada, luego de concretar el proceso de autenticación y dependiendo los roles con el que cuenta el usuario que ingresa al sistema, se van a poder realizar diferentes operaciones. Los roles iniciales son: cliente, depósito y administrador.
### Hecho Con

* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]

### Pautas Básicas:

<br><br>
1. La aplicación debe ser desarrollada sobre una arquitectura MVC (Modelo-VistaControl) utilizando PHP como lenguaje de programación. Se propone una estructura de directorio inicial como la que se visualiza en la Ilustración 2.
<br><br>
2. Se debe utilizar la Base de Datos bdcarritocompras otorgada por la cátedra. Realizar el MOR de las tablas del modelo de base de datos de la Ilustración 1. Verificar la estructura de las tablas y realizar las modificaciones que crea
necesarias.
<br><br>
3. La aplicación tendrá páginas públicas y otras restringidas, que sólo podrán ser accedidas a partir de un usuario y contraseña. Utilizar el módulo de autenticación implementado en TP5. La aplicación debe tener como mínimo los siguientes
roles: cliente, depósito y administrador.
<br><br>
4. El menú de la aplicación debe ser un menú dinámico que pueda ser gestionado por el administrador de la aplicación. Las tablas de la base de datos vinculadas a esta información son: menu y menurol.
<br><br>
5. Cualquier usuario que tenga más de un rol asignado, puede cambiar de rol según lo desee.
<br><br>
6. Desde la aplicación un usuario con rol Cliente podrá:
    * Gestionar los datos de su cuenta, como cambiar su e-mail y contraseña.
    * Realizar la compra de uno o más productos con stock suficiente.
<br><br>
7. Desde la aplicación un usuario con rol Deposito podrá:
    * Crear nuevos productos y administrar los existentes.
    * Acceder a los procedimientos que permite el cambio de estado de los productos.
    * Modificar el stock de los productos.
<br><br>
8. Desde la aplicación un usuario con rol Administrador podrá:
    * Crear nuevos usuarios al sistema, asignar los roles correspondientes y actualizar la información que se requiera.
    * Gestionar y administrar nuevos roles e ítem del menú. Vinculando item del menú al rol según corresponda.

### Lista Usuarios:

1. Nombre de Usuario: mondongo
  * Contraseña: mondongo
  * Roles: Admin - Depósito - Cliente
2. Nombre de Usuario: admin
  * Contraseña: admin123
  * Roles: Admin
3. Nombre de Usuario: deposito
  * Contraseña: deposito
  * Roles: Depósito
4. Nombre de Usuario: cliente
  * Contraseña: cliente123
  * Roles: Cliente

<p align="right">(<a href="#readme-top">ir al inicio</a>)</p>



[contributors-shield]: https://img.shields.io/github/contributors/sappiajeremias/TP-Final-PWD.svg?style=for-the-badge
[contributors-url]: https://github.com/sappiajeremias/TP-Final-PWD/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/sappiajeremias/TP-Final-PWD.svg?style=for-the-badge
[forks-url]: https://github.com/sappiajeremias/TP-Final-PWD/network/members
[stars-shield]: https://img.shields.io/github/stars/sappiajeremias/TP-Final-PWD.svg?style=for-the-badge
[stars-url]: https://github.com/sappiajeremias/TP-Final-PWD/stargazers
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 
