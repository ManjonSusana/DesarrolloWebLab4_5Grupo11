# 🏨 Sistema de Gestión Hotelera - Hotel Chuquisaqueño

## 📋 Descripción
Sistema web completo para la gestión de un hotel que incluye:
- Sistema de autenticación con roles (Admin/Cliente)
- Gestión de usuarios, habitaciones y reservas
- Panel administrativo completo
- Interfaz de cliente para reservas

## 🛠️ Instalación y Configuración

### 1. Requisitos Previos
- XAMPP instalado y funcionando
- Apache y MySQL activos
- Navegador web moderno

### 2. Configuración de la Base de Datos

1. **Abrir phpMyAdmin**: `http://localhost/phpmyadmin`

2. **Crear la base de datos**:
   ```sql
   CREATE DATABASE bd_hoteles2;
   ```

3. **Importar la estructura**:
   - Seleccionar la base de datos `bd_hoteles2`
   - Ir a la pestaña "Importar"
   - Seleccionar el archivo `bd_hoteles2.sql`
   - Hacer clic en "Continuar"

### 3. Verificar Configuración

1. **Probar conexión**:
   - Visitar: `http://localhost/Desarrollo_Web_ASCH/laboratorio/lab5/hotel2/test_conexion_bd_hoteles2.php`

2. **Insertar datos de prueba**:
   - Visitar: `http://localhost/Desarrollo_Web_ASCH/laboratorio/lab5/hotel2/insertar_datos_prueba.php`

## 🚀 Uso del Sistema

### 1. Acceso al Sistema
- **URL**: `http://localhost/Desarrollo_Web_ASCH/laboratorio/lab5/hotel2/formlogin.html`

### 2. Credenciales de Prueba

#### Administrador:
- **Tipo**: Administrador
- **Correo**: `admin@hotel.com`
- **Contraseña**: cualquier texto (no se valida por ahora)

#### Cliente:
- **Tipo**: Cliente  
- **Correo**: `cliente@test.com`
- **Contraseña**: cualquier texto (no se valida por ahora)

### 3. Funcionalidades por Rol

#### 👨‍💼 Panel Administrativo (`admin.html`)
- **Usuarios**: Crear, editar, eliminar usuarios
- **Habitaciones**: Gestionar estado y asignación de habitaciones
- **Reservas**: Ver, confirmar, cancelar reservas
- **Dashboard**: Estadísticas en tiempo real

#### 👤 Panel Cliente (`paginaCliente.html`)
- **Ver Habitaciones**: Explorar habitaciones disponibles
- **Hacer Reservas**: Reservar habitaciones por fechas
- **Mis Reservas**: Ver historial de reservas
- **Perfil**: Gestionar información personal

## 📁 Estructura de Archivos

```
hotel2/
├── 🔐 Autenticación
│   ├── formlogin.html      # Formulario de login
│   ├── autenticar.php      # Procesamiento de login
│   ├── logout.php          # Cerrar sesión
│   └── verificarsesion.php # Verificar sesión activa
│
├── 🏠 Gestión Habitaciones
│   ├── habitaciones.html   # Interface habitaciones
│   ├── habitaciones.js     # JavaScript habitaciones
│   ├── readHabitaciones.php
│   ├── estadoHabitacion.php
│   └── getDetalleHabitacion.php
│
├── 👥 Gestión Usuarios
│   ├── usuarios.html       # Interface usuarios
│   ├── usuarios.js         # JavaScript usuarios
│   ├── readUsuarios.php
│   ├── insertUsuario.php
│   ├── updateUsuario.php
│   └── deleteUsuario.php
│
├── 📋 Gestión Reservas
│   ├── reservas.html       # Interface reservas
│   ├── reservas.js         # JavaScript reservas
│   ├── readReservas.php
│   ├── insertReserva.php
│   ├── updateReserva.php
│   └── deleteReserva.php
│
├── 🎨 Interfaz
│   ├── admin.html          # Panel administrativo
│   ├── paginaCliente.html  # Panel cliente
│   ├── inicio.html         # Dashboard
│   ├── styles.css          # Estilos
│   └── main.js             # JavaScript principal
│
└── 🗄️ Base de Datos
    ├── bd_hoteles2.sql     # Estructura DB
    ├── conexion.php        # Conexión DB
    └── test_conexion_bd_hoteles2.php
```

## 🔧 Configuración Personalizada

### Cambiar Puerto de MySQL
Si usas un puerto diferente al 3306, editar `conexion.php`:
```php
$puerto = 3307; // Cambiar según tu configuración
```

### Personalizar Estilos
Editar `styles.css` para cambiar colores, fuentes, etc.

### Agregar Validación de Contraseñas
Modificar `autenticar.php` para incluir validación real de contraseñas.

## 🐛 Solución de Problemas

### Error de Conexión
1. Verificar que Apache y MySQL estén activos
2. Comprobar que la base de datos `bd_hoteles2` existe
3. Revisar credenciales en `conexion.php`

### Error "Tabla no encontrada"
1. Asegurarse de haber importado `bd_hoteles2.sql`
2. Verificar que todas las tablas estén creadas

### JavaScript no funciona
1. Verificar que todos los archivos .js estén en la carpeta
2. Comprobar la consola del navegador para errores

## 📞 Soporte

Para reportar problemas o solicitar funcionalidades:
1. Revisar este README
2. Verificar archivos de prueba
3. Consultar logs de Apache/MySQL

## 🎯 Próximas Mejoras

- [ ] Sistema de autenticación con contraseñas encriptadas
- [ ] Subida de imágenes de habitaciones
- [ ] Sistema de notificaciones por email
- [ ] Reportes en PDF
- [ ] API REST para móviles
- [ ] Sistema de pagos en línea

---

## 📄 Licencia
Proyecto académico - Universidad Mayor Real y Pontificia San Francisco Xavier de Chuquisaca

**¡Listo para usar! 🚀**
