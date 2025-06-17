# Hotel Chuquisaqueño - Sistema de Reservas Mejorado (lb5)

## 🚀 Mejoras Implementadas

Este proyecto es una versión mejorada del sistema de reservas del Hotel Chuquisaqueño, ubicado en la carpeta `lb5` dentro de `Laboratorio5`.

### ✅ Correcciones Principales

1. **Sistema de Reservas Funcionando**
   - ✅ Las reservas ahora se guardan correctamente en la base de datos
   - ✅ Validación de fechas (no permite fechas pasadas, ni salida antes que ingreso)
   - ✅ Verificación de disponibilidad de habitaciones
   - ✅ Manejo de errores y mensajes informativos

2. **Seguridad Mejorada**
   - ✅ Uso de prepared statements para prevenir SQL injection
   - ✅ Validación de sesiones mejorada
   - ✅ Sanitización de datos de entrada

### 🎨 Mejoras de Interfaz (Bootstrap 5)

1. **Diseño Moderno y Responsivo**
   - ✅ Integración completa de Bootstrap 5
   - ✅ Font Awesome para iconografía
   - ✅ Diseño glassmorphism con efectos de blur
   - ✅ Animaciones suaves y transiciones

2. **Experiencia de Usuario Mejorada**
   - ✅ Loading spinners durante las operaciones
   - ✅ Tooltips informativos
   - ✅ Alertas y notificaciones visuales
   - ✅ Interfaz intuitiva y moderna

### 📱 Características Responsivas

- ✅ Diseño adaptable para móviles y tablets
- ✅ Navegación optimizada para dispositivos táctiles
- ✅ Formularios amigables en pantallas pequeñas

### 🔧 Archivos Principales Mejorados

1. **`insertar.php`** - Sistema de reservas completamente funcional
2. **`reservar.php`** - Formulario de reserva con validación y diseño Bootstrap
3. **`verHabitaciones.php`** - Lista de habitaciones con diseño mejorado
4. **`verReservas.php`** - Visualización de reservas con estados y detalles
5. **`verTipos.php`** - Tipos de habitación con diseño moderno
6. **`paginaCliente.html`** - Página principal con navegación mejorada
7. **`formlogin.html`** - Formulario de login con diseño glassmorphism
8. **`script.js`** - JavaScript mejorado con manejo de errores

### 🎯 Funcionalidades Agregadas

- **Validación de fechas**: No permite reservas en fechas pasadas
- **Verificación de disponibilidad**: Comprueba si la habitación está libre
- **Estados de reserva**: Activa, Próxima, Completada
- **Información detallada**: Duración de estadía, detalles de habitación
- **Notificaciones**: Mensajes de éxito, error y advertencia
- **Tooltips**: Ayuda contextual en botones y elementos

### 🛠️ Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, Bootstrap 5, Font Awesome 6, JavaScript ES6
- **Backend**: PHP 8, MySQL
- **Base de datos**: Prepared statements para seguridad
- **Diseño**: Glassmorphism, gradientes, animaciones CSS

### 📦 Estructura de Archivos

```
lb5/
├── conexion.php          # Conexión a base de datos
├── insertar.php          # ✅ Sistema de reservas funcional
├── reservar.php          # ✅ Formulario de reserva mejorado
├── verHabitaciones.php   # ✅ Lista de habitaciones con Bootstrap
├── verReservas.php       # ✅ Mis reservas con estados y detalles
├── verTipos.php          # ✅ Tipos de habitación mejorados
├── paginaCliente.html    # ✅ Página principal responsive
├── formlogin.html        # ✅ Login con diseño glassmorphism
├── autenticar.php        # Autenticación mejorada
├── verificarsesion.php   # Verificación de sesiones
├── script.js             # ✅ JavaScript mejorado
├── styles.css            # ✅ Estilos CSS modernos
└── README.md             # Este archivo
```

### 🚀 Instrucciones de Uso

1. **Configuración**:
   - Asegúrate de que XAMPP esté ejecutándose
   - La base de datos debe estar configurada en el puerto 3307
   - Base de datos: `bd_hotel`

2. **Acceso**:
   - Navega a: `http://localhost/Desarrollo_Web_ASCH/laboratorio/Laboraorio5/lb5/formlogin.html`
   - Inicia sesión con credenciales válidas
   - Explora las habitaciones y realiza reservas

3. **Funcionalidades principales**:
   - Ver tipos de habitación
   - Explorar habitaciones disponibles
   - Realizar reservas con validación
   - Ver historial de reservas

### 🎨 Paleta de Colores

- **Primario**: #c4002c (Rojo Hotel)
- **Secundario**: #a70024 (Rojo oscuro)
- **Fondo**: Gradiente #0d1117 → #1a1a2e
- **Acentos**: #17a2b8 (Azul info), #28a745 (Verde éxito)

### 💡 Características Destacadas

- **Glassmorphism**: Efectos de vidrio esmerilado modernos
- **Animaciones**: Transiciones suaves y efectos hover
- **Responsivo**: Funciona perfectamente en todos los dispositivos
- **Accesible**: Diseño intuitivo y fácil de usar
- **Seguro**: Protección contra inyecciones SQL

---

**Desarrollado por**: Sistema mejorado del Hotel Chuquisaqueño
**Fecha**: Noviembre 2025
**Versión**: 2.0 (lb5)
