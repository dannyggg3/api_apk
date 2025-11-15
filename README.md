# API APK - Backend para Sistema POS (Point of Sale)

## 📋 Descripción

**API APK** es una API REST backend construida en PHP vanilla que funciona como servidor central para una aplicación Android de punto de venta (POS). Proporciona endpoints completos para gestión de inventario, ventas, clientes, gastos y reportes analíticos, diseñada especialmente para pequeños y medianos negocios en Latinoamérica.

## 🚀 Tipo de Proyecto

**API REST Backend** - Sistema de Punto de Venta (POS)

## 🛠️ Tecnologías Utilizadas

- **PHP** - Lenguaje backend (procedural vanilla)
- **MySQL** - Base de datos relacional
- **MySQLi** - Driver de conexión a MySQL
- **JSON** - Formato de intercambio de datos
- **Git** - Control de versiones

## 📚 Stack Tecnológico

| Componente | Tecnología | Propósito |
|-----------|-----------|----------|
| **Backend** | PHP (Procedural) | Lógica de negocio |
| **Base de Datos** | MySQL (MySQLi) | Almacenamiento de datos |
| **API** | REST JSON | Comunicación con APK Android |
| **Autenticación** | Session-based | Gestión de sesiones |
| **Archivos** | PHP Upload | Imágenes de productos |

## 🏗️ Arquitectura

### Patrón Arquitectónico: API REST Procedural

```
┌──────────────────────────────────────┐
│    CLIENTE (APK Android)             │
│    Aplicación Móvil POS              │
└──────────────┬───────────────────────┘
               │ HTTP Request (JSON)
               ↓
┌──────────────┴───────────────────────┐
│    SCRIPT PHP ESPECÍFICO             │
│    (add_product.php, etc.)           │
└──────────────┬───────────────────────┘
               ↓
┌──────────────┴───────────────────────┐
│    VALIDACIÓN DE MÉTODO              │
│    (POST/GET)                        │
└──────────────┬───────────────────────┘
               ↓
┌──────────────┴───────────────────────┐
│    db_connect.php                    │
│    (Conexión Global a MySQL)         │
└──────────────┬───────────────────────┘
               ↓
┌──────────────┴───────────────────────┐
│    LÓGICA CRUD                       │
│    (INSERT/UPDATE/DELETE/SELECT)     │
└──────────────┬───────────────────────┘
               ↓
┌──────────────┴───────────────────────┐
│    CONSULTAS SQL (MySQLi)            │
│    (mysqli_query)                    │
└──────────────┬───────────────────────┘
               ↓
┌──────────────┴───────────────────────┐
│    RESPUESTA JSON                    │
│    (json_encode)                     │
└──────────────┬───────────────────────┘
               │ HTTP Response
               ↓
┌──────────────┴───────────────────────┐
│    CLIENTE RECIBE RESPUESTA          │
│    ("success", "fail", datos)        │
└──────────────────────────────────────┘
```

### Características Arquitectónicas
- **Orientación**: API REST simple sin framework
- **Patrón de Endpoints**: Un archivo PHP por operación CRUD
- **Estado**: Multi-tenant (soporte de tienda con `shop_id`)
- **Autenticación**: Básica por usuario y RUC

## 📁 Estructura del Proyecto

```
api_apk/
├── Autenticación
│   ├── login.php                    (112 líneas)
│   └── db_connect.php               (8 líneas)
│
├── Gestión de Productos
│   ├── add_product.php
│   ├── update_product.php
│   ├── update_product_without_image.php
│   ├── delete_product.php
│   ├── get_products.php
│   ├── get_product_by_id.php
│   ├── search_product.php
│   └── get_category.php
│
├── Gestión de Clientes
│   ├── add_customer.php
│   ├── update_customer.php
│   ├── delete_customer.php
│   └── get_customer.php
│
├── Gestión de Pedidos
│   ├── orders_submit.php            (108 líneas)
│   ├── delete_order.php
│   ├── get_orders.php
│   ├── order_details_by_invoice.php
│   └── sales_report_list.php
│
├── Gestión de Gastos
│   ├── add_expense.php
│   ├── update_expense.php
│   ├── delete_expense.php
│   ├── get_expense.php
│   └── get_all_expense.php
│
├── Gestión de Proveedores
│   ├── add_suppliers.php
│   ├── update_suppliers.php
│   ├── delete_supplier.php
│   └── get_suppliers.php
│
├── Reportes y Análisis
│   ├── get_monthly_sales.php        (80 líneas)
│   ├── get_monthly_expense.php      (75 líneas)
│   ├── get_sales_report.php
│   └── get_expense_report.php
│
├── Configuración
│   ├── shop_information.php
│   └── get_weight_units.php
│
└── Utilidades
    └── my_function.php              (437 líneas)

TOTAL: ~2,318 líneas de código PHP
```

## ✨ Características Principales

### 🔐 Autenticación
- Login con email + contraseña + RUC
- Validación contra base de datos multi-tenant
- Información de usuario, tienda e impuestos
- Roles de usuario

### 📦 Gestión de Productos
#### CRUD Completo:
- **Crear**: Subida de imagen, inserción en BD
- **Leer**: Búsqueda, filtrado por categoría, obtención por ID
- **Actualizar**: Con/sin cambio de imagen
- **Eliminar**: Borrado directo

#### Campos de Producto:
- ID, nombre, código, categoría
- Descripción, precio de venta
- Peso y unidad de medida
- Stock (control de inventario)
- Proveedor asociado
- Imagen del producto
- Impuesto (tax)
- Multi-tenant (shop_id, owner_id)

### 👥 Gestión de Clientes
- CRUD completo de clientes
- Validación de tipo de documento (DNI/RUC/Cédula)
- Información de contacto (email, teléfono, dirección)
- Agrupación de clientes
- Upsert basado en documento (cédula)

### 🛒 Gestión de Pedidos

#### Estructura de Pedidos:
- **Cabecera** (`order_list`):
  - ID de orden, invoice_id único
  - Fecha y hora
  - Tipo de orden, método de pago
  - Total, descuento, impuesto
  - Nombre del cliente
  - Atendido por (served_by)

- **Líneas** (`order_details`):
  - Productos vendidos
  - Cantidad, peso, precio
  - Imagen, impuesto por línea

#### Procesamiento:
1. Recibe JSON con array de líneas
2. Inserta cabecera
3. Inserta cada línea
4. **Actualiza stock automáticamente**
5. Evita duplicados por invoice_id

### 💰 Gestión de Gastos
- Registro de gastos operacionales
- Nombre, monto, nota, fecha
- Búsqueda y filtros
- Cálculo de totales

### 🏭 Gestión de Proveedores
- CRUD de proveedores
- Información de contacto
- Vinculación con productos

### 📊 Reportes y Análisis

#### Reportes de Ventas:
- **Mensuales**: Desglose Enero-Diciembre
- **Por Período**: Diario, semanal, mensual, anual, total
- **Métricas**: Total de órdenes, descuentos, impuestos
- **Por Cliente**: Análisis de ventas

#### Reportes de Gastos:
- **Mensuales**: Desglose por mes
- **Por Tipo**: daily, weekly, monthly, yearly, all
- **Totales**: Suma agregada

### 🧮 Funciones Auxiliares (my_function.php)

**437 líneas** de funciones centralizadas:

#### Búsqueda:
- `categoryName($id)` - Nombre de categoría
- `weightUnit($id)` - Unidad de peso
- `supplierName($id)` - Nombre de proveedor
- `getProductStock($id)` - Stock de producto

#### Cálculo de Gastos:
- `getTotalExpense()` - Gasto total
- `getExpenseByType($type, $shop_id)` - Por período
- `getMonthlyExpense($month, $year, $shop_id)` - Mensual

#### Cálculo de Ventas:
- `getTotalOrderPrice()` - Venta total
- `getOrderPriceByType($type, $shop_id, $year)` - Por período
- `getDiscountPriceByType()` - Total descuentos
- `getTaxPriceByType()` - Total impuestos
- `getMonthlySalesAmount()` - Ventas mensuales

#### Utilidades:
- `getCurrency()` - Símbolo de moneda
- `time_elapsed_string($datetime)` - Formato "hace X tiempo"

## 🔧 Instalación

### Prerrequisitos

- PHP 7.0+ o superior
- MySQL 5.7+ o MariaDB
- Apache o Nginx
- Extensión MySQLi habilitada

### Pasos

1. Clonar el repositorio
```bash
git clone https://github.com/dannyggg3/api_apk.git
cd api_apk
```

2. Configurar la base de datos
```sql
-- Crear base de datos
CREATE DATABASE pos_database;

-- Importar estructura de tablas (consultar schema en documentación)
```

3. Configurar conexión a BD
```php
// Editar db_connect.php
$host = "localhost";
$user = "tu_usuario";
$password = "tu_contraseña";
$database = "pos_database";
```

4. Configurar servidor web
```apache
# Apache VirtualHost
<VirtualHost *:80>
    DocumentRoot "/ruta/a/api_apk"
    ServerName api.tu-dominio.com
    <Directory "/ruta/a/api_apk">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

5. Crear directorio de imágenes
```bash
mkdir product_images
chmod 755 product_images
```

6. Iniciar servidor
```bash
# Con PHP built-in server (desarrollo)
php -S localhost:8000

# O configurar Apache/Nginx
```

## 💻 Uso

### Endpoints Disponibles

#### Autenticación
```http
POST /login.php
Content-Type: application/x-www-form-urlencoded

email=usuario@example.com&password=123456&ruc=1234567890
```

#### Productos
```http
# Listar productos
GET /get_products.php?shop_id=1

# Crear producto
POST /add_product.php
Content-Type: multipart/form-data

product_name=Producto A&product_price=10.50&...

# Buscar producto
GET /search_product.php?search=laptop&shop_id=1
```

#### Pedidos
```http
POST /orders_submit.php
Content-Type: application/json

{
  "invoice_id": "INV-001",
  "order_date": "2024-11-14",
  "order_time": "14:30",
  "order_type": "regular",
  "order_price": 150.00,
  "order_payment_method": "cash",
  "discount": 0,
  "tax": 25.50,
  "customer_name": "Juan Pérez",
  "served_by": "Maria",
  "shop_id": 1,
  "owner_id": 1,
  "lines": [
    {
      "product_id": 1,
      "product_name": "Producto A",
      "product_price": 50.00,
      "product_qty": 3,
      "product_weight": "1.5",
      "tax": 8.50
    }
  ]
}
```

#### Reportes
```http
# Ventas mensuales
GET /get_monthly_sales.php?year=2024&shop_id=1

# Reporte de gastos
GET /get_expense_report.php?type=monthly&shop_id=1
```

### Respuestas API

#### Éxito
```json
{
  "status": "success",
  "data": { ... }
}
```

#### Error
```json
{
  "status": "fail",
  "message": "Error description"
}
```

## 📊 Modelo de Base de Datos

### Tablas Principales

```sql
-- Usuarios
users
├── id, name, email, password (hash)
├── role_id, warehouse_id
└── Timestamps

-- Clientes
customers
├── id, cedula, tipo (DNI/RUC)
├── name, email, phone_number, address
├── city, customer_group_id
└── created_at, updated_at

-- Productos
products
├── product_id, product_name, product_code
├── product_category_id, product_description
├── product_sell_price, product_weight
├── product_supplier_id, product_image
├── product_stock, tax
└── shop_id, owner_id

-- Pedidos (Cabecera)
order_list
├── order_id, invoice_id (UNIQUE)
├── order_date, order_time
├── order_type, order_payment_method
├── order_price, discount, tax
├── customer_name, served_by
└── shop_id, owner_id

-- Pedidos (Líneas)
order_details
├── order_details_id, invoice_id (FK)
├── product_id, product_name
├── product_quantity, product_weight
├── product_price, tax
└── shop_id, owner_id

-- Gastos
expense
├── expense_id, expense_name
├── expense_amount, expense_note
├── expense_date, expense_time
└── shop_id, owner_id

-- Proveedores
suppliers
├── suppliers_id, suppliers_name
├── suppliers_contact, suppliers_email
└── suppliers_address

-- Categorías
product_category
├── product_category_id
└── product_category_name

-- Unidades de Peso
weight_unit
├── weight_unit_id
└── weight_unit_name

-- Tiendas
shop
├── shop_id, shop_name
├── shop_contact, shop_email
├── shop_address
└── currency_symbol
```

## 🎯 Flujos de Operación

### Flujo de Venta
```
1. Usuario inicia sesión → login.php
2. APK obtiene productos → get_products.php
3. Usuario selecciona productos y cantidad
4. APK genera invoice_id local
5. APK calcula totales, descuentos, impuestos
6. APK envía JSON → orders_submit.php
7. Backend inserta pedido + líneas
8. Backend actualiza stock
9. Backend retorna "success"
10. APK sincroniza datos
```

### Flujo de Reportes
```
1. APK solicita reporte → get_monthly_sales.php
2. Backend calcula montos por mes
3. Backend incluye totales (descuentos, impuestos)
4. Backend retorna JSON con arrays
5. APK grafica datos
```

## 📈 Estadísticas del Proyecto

| Métrica | Valor |
|---------|-------|
| Total líneas PHP | 2,318 |
| Archivos PHP | 35 |
| Endpoints CRUD | ~35 |
| Tablas BD | 10+ |
| Funciones auxiliares | 20+ |

## ⚠️ Consideraciones de Seguridad

### Vulnerabilidades Detectadas (para mejorar)

🔴 **CRÍTICAS:**
- SQL Injection (parámetros sin prepared statements)
- Autenticación débil (hash comentado)
- Validación insuficiente de entrada
- Control de acceso básico

⚠️ **IMPORTANTES:**
- Manejo de archivos sin validación MIME
- Sin rate limiting
- Tokens en texto plano
- Exposición de información en errores

### Recomendaciones de Mejora

1. **Implementar Prepared Statements**
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
```

2. **Agregar Autenticación JWT**
```php
// Implementar tokens JWT
// Enviar en headers Authorization: Bearer {token}
```

3. **Validación Robusta**
```php
// Validar y sanitizar TODOS los inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
```

4. **Refactorizar a Framework Moderno**
- Considerar Laravel, Symfony o Slim Framework
- Implementar ORM (Eloquent, Doctrine)
- Agregar middleware de autenticación

## 🚀 Mejoras Futuras

- [ ] Migrar a framework PHP moderno (Laravel/Symfony)
- [ ] Implementar prepared statements (prevenir SQL injection)
- [ ] Agregar autenticación JWT
- [ ] Crear middleware de validación
- [ ] Implementar RBAC (Role-Based Access Control)
- [ ] Agregar validación MIME para archivos
- [ ] Implementar rate limiting
- [ ] Crear documentación OpenAPI/Swagger
- [ ] Agregar tests unitarios (PHPUnit)
- [ ] Implementar logging robusto

## 🌎 Contexto Regional

Optimizado para Latinoamérica:
- **RUC**: Registro Único del Contribuyente (Perú)
- **Tipos de Documento**: DNI, Cédula, RUC
- **Mensajes**: Español
- **Multi-tenant**: Soporte de múltiples tiendas

## 📄 Licencia

Este proyecto es parte del portafolio de desarrollo de dannyggg3.

## 👤 Autor

**dannyggg3**
- GitHub: [@dannyggg3](https://github.com/dannyggg3)

---

⭐ Si este proyecto te fue útil, considera darle una estrella
