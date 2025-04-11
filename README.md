# Entorno de Laboratorio para Ethical Hacking con Docker

## 📋 Descripción

Este repositorio contiene un entorno de laboratorio para prácticas de Ethical Hacking, configurado con vulnerabilidades controladas (SQL Injection y XSS) para fines educativos. El entorno se ejecuta en un contenedor Docker con Apache, PHP 8.2 y SSL configurado.

## 🛠 Prerrequisitos

- Docker instalado en tu sistema
- Git (opcional, para clonar el repositorio)
- OpenSSL (para generar certificados, si no usas los incluidos)

## 🚀 Configuración Inicial

1. **Clonar el repositorio** (opcional):
   ```bash
   git clone https://github.com/wpadillav/web-vuln-lab.git
   cd web-vuln-lab
   ```

2. **Generar certificados SSL** (si no usas los incluidos):
   ```bash
   mkdir -p ssl
   openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
       -keyout ssl/localhost.key \
       -out ssl/localhost.crt \
       -subj "/CN=localhost" \
       -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"
   ```

## 🐳 Construcción y Ejecución del Contenedor

1. **Construir la imagen Docker**:
   ```bash
   docker build -t ethical-hacking-lab .
   ```

2. **Ejecutar el contenedor**:
   ```bash
   docker run -d -p 80:80 -p 443:443 \
       -v $(pwd)/sitio:/var/www/html \
       -v $(pwd)/ssl:/etc/apache2/ssl \
       --name hacking-lab \
       ethical-hacking-lab
   ```

   Para exponer el puerto HTTPS en el puerto 4000 del host:
   ```bash
   docker run -d -p 80:80 -p 4000:443 \
       -v $(pwd)/sitio:/var/www/html \
       -v $(pwd)/ssl:/etc/apache2/ssl \
       --name hacking-lab \
       ethical-hacking-lab
   ```

## 🌐 Acceso a la Aplicación

- **Interfaz principal**: 
  - HTTPS: `https://localhost` (o `https://localhost:4000` si mapeaste a 4000)
  - HTTP (redirige a HTTPS): `http://localhost`

- **Páginas vulnerables**:
  - SQL Injection: `https://localhost/login.php`
  - XSS: `https://localhost/hackme.php`

---

## 🗃️ Restauración de la Base de Datos

El repositorio incluye un archivo `restore_db.sql` con la estructura y datos de prueba para el laboratorio:

```sql
/* Estructura completa con:
- Tabla de usuarios (credenciales de prueba)
- Tabla de comentarios (para XSS)
- Datos iniciales */
```

### Métodos de restauración:

1. **Usando línea de comandos**:
   ```bash
   mysql -u [usuario] -p[contraseña] hacking_class < restore_db.sql
   ```

2. **En contenedor Docker**:
   ```bash
   docker exec -i [nombre-contenedor-mysql] mysql -u root -p[contraseña] hacking_class < restore_db.sql
   ```

3. **Via phpMyAdmin**:
   - Importar el archivo SQL desde la interfaz gráfica

### Credenciales de prueba incluidas:
| Usuario     | Contraseña    | Rol         |
|-------------|---------------|-------------|
| admin       | password123   | Administrador |
| profesor    | seguro456     | Instructor  |
| estudiante  | aprendiendo   | Estudiante  |

> **Nota de seguridad**: Estas credenciales son solo para propósitos educativos en entornos locales. Nunca uses contraseñas reales o simples en producción.

---

## 🛡️ Estructura del Proyecto

```
.
├── apache-config/          # Configuraciones de Apache
│   ├── 000-default.conf    # Configuración para HTTP (redirige a HTTPS)
│   └── default-ssl.conf    # Configuración para HTTPS
├── Dockerfile              # Configuración del contenedor Docker
├── restore_db.sql          # SQL para base de datos
├── sitio/                  # Código fuente de la aplicación vulnerable
│   ├── hackme.php          # Página vulnerable a XSS
│   ├── index.html          # Página principal
│   ├── login.php           # Página vulnerable a SQLi
│   ├── padlock-308589_640.png # Imagen de ejemplo
│   └── styles.css          # Estilos CSS comunes
└── ssl/                    # Certificados SSL
    ├── localhost.crt       # Certificado autofirmado
    └── localhost.key       # Clave privada
```

## 🔍 Vulnerabilidades Implementadas

1. **SQL Injection (SQLi)**:
   - Localización: `login.php`
   - Ejemplo de payload: `admin' -- `
   - Objetivo educativo: Bypass de autenticación, extracción de datos

2. **Cross-Site Scripting (XSS)**:
   - Localización: `hackme.php`
   - Ejemplo de payload: `<script>alert('XSS')</script>`
   - Objetivo educativo: Ejecución de código arbitrario en el navegador

## ⚠️ Advertencia de Seguridad

❗ **Este entorno contiene vulnerabilidades deliberadas y solo debe usarse para fines educativos en un entorno controlado.** 

- No expongas este contenedor a redes públicas
- No uses credenciales reales en este entorno
- Asegúrate de entender los riesgos antes de ejecutarlo

## 🛠️ Comandos Útiles

- **Ver logs del contenedor**:
  ```bash
  docker logs hacking-lab
  ```

- **Acceder al contenedor**:
  ```bash
  docker exec -it hacking-lab bash
  ```

- **Detener el contenedor**:
  ```bash
  docker stop hacking-lab
  ```

- **Eliminar el contenedor**:
  ```bash
  docker rm hacking-lab
  ```

## 📝 Notas Adicionales

- Para aceptar el certificado SSL autofirmado en tu navegador, deberás agregar una excepción de seguridad.
- Si necesitas acceder desde otros dispositivos en tu red local, asegúrate de usar la IP correcta y que los puertos estén accesibles.
- Considera usar `docker-compose` para una gestión más avanzada si planeas expandir este laboratorio.

## 📚 Recursos de Aprendizaje

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Guía de SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection)
- [Guía de XSS](https://owasp.org/www-community/attacks/xss/)
