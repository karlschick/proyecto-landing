-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-04-2026 a las 07:42:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `landing_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `category` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `title`, `description`, `image`, `type`, `category`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Proyecto Web 1', 'Captura de pantalla del proyecto web corporativo', 'gallery/default-1.jpg', 'image', 'Desarrollo Web', 1, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 'Proyecto Web 2', 'Vista responsive del portal', 'gallery/default-2.jpg', 'image', 'Desarrollo Web', 1, 2, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 'App Móvil 1', 'Interfaz principal de la app', 'gallery/default-3.jpg', 'image', 'Apps Móviles', 1, 3, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 'App Móvil 2', 'Pantalla de checkout', 'gallery/default-4.jpg', 'image', 'Apps Móviles', 1, 4, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(5, 'Diseño UX 1', 'Wireframes del proyecto', 'gallery/default-5.jpg', 'image', 'Diseño', 1, 5, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(6, 'Diseño UX 2', 'Prototipos de alta fidelidad', 'gallery/default-6.jpg', 'image', 'Diseño', 1, 6, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `status` enum('nuevo','contactado','calificado','convertido','descartado') NOT NULL DEFAULT 'nuevo',
  `admin_notes` text DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `contacted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_stats_table', 1),
(5, '2025_11_01_031905_create_settings_table', 1),
(6, '2025_11_01_095020_create_services_table', 1),
(7, '2025_11_01_100000_create_project_categories_table', 1),
(8, '2025_11_01_100001_create_projects_table', 1),
(9, '2025_11_01_100002_create_testimonials_table', 1),
(10, '2025_11_01_100003_create_gallery_images_table', 1),
(11, '2025_11_01_100004_create_leads_table', 1),
(12, '2025_11_02_100000_create_product_categories_table', 1),
(13, '2025_11_02_100001_create_products_table', 1),
(14, '2025_11_02_100002_create_carts_table', 1),
(15, '2025_11_02_100003_create_cart_items_table', 1),
(16, '2025_11_02_100004_create_orders_table', 1),
(17, '2025_11_02_100005_create_shipping_addresses_table', 1),
(18, '2025_11_02_100006_create_order_items_table', 1),
(19, '2025_11_02_100007_create_payments_table', 1),
(20, '2025_11_04_000001_add_hero_customization_to_settings_table', 1),
(21, '2025_11_04_051605_add_navbar_settings_to_settings_table', 1),
(22, '2025_11_08_230219_add_section_controls_to_settings_table', 1),
(23, '2025_11_09_000001_add_color_columns_to_settings_table', 1),
(24, '2025_11_10_000001_add_hero_logo_position_to_settings_table', 1),
(25, '2025_11_13_040402_add_featured_image_to_projects_table', 1),
(26, '2025_11_13_053302_make_category_id_nullable_in_projects_table', 1),
(27, '2025_11_13_075516_add_type_to_gallery_images_table', 1),
(28, '2025_11_14_024332_create_notifications_table', 1),
(29, '2025_11_15_000815_add_pdf_fields_to_products_table', 1),
(30, '2025_11_15_000822_create_product_downloads_table', 1),
(31, '2025_11_15_094237_add_is_digital_to_products_table', 1),
(32, '2025_11_15_115524_add_method_to_payments_table', 1),
(33, '2025_11_28_050652_add_missing_columns_to_payments_table', 1),
(34, '2025_11_28_050949_fix_payment_method_column_in_payments_table', 1),
(35, '2025_11_28_053546_add_receipt_columns_to_payments_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `status` enum('pending','paid','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'COP',
  `notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'COP',
  `payment_gateway` varchar(255) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `status` enum('pending','pending_verification','completed','approved','failed','rejected','cancelled') DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `track_quantity` tinyint(1) NOT NULL DEFAULT 1,
  `weight` decimal(8,2) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `download_limit` int(11) NOT NULL DEFAULT 3,
  `access_days` int(11) NOT NULL DEFAULT 365,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_digital` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `short_description`, `price`, `compare_price`, `cost`, `sku`, `barcode`, `quantity`, `track_quantity`, `weight`, `featured_image`, `file_path`, `file_size`, `download_limit`, `access_days`, `gallery_images`, `is_featured`, `is_active`, `is_digital`, `order`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 1, 'Laptop HP 15\"', 'laptop-hp-15', 'Laptop HP con procesador Intel Core i5, 8GB RAM, 256GB SSD. Ideal para trabajo y estudio.', 'Laptop potente para trabajo y estudio', 1299000.00, 1499000.00, NULL, 'PRD-VC2XOXTT', NULL, 10, 1, NULL, 'products/product1.png', NULL, NULL, 3, 365, NULL, 1, 1, 0, 1, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 1, 'Mouse Inalámbrico Logitech', 'mouse-inalambrico-logitech', 'Mouse ergonómico inalámbrico con batería de larga duración.', 'Mouse inalámbrico ergonómico', 89000.00, NULL, NULL, 'PRD-SNNWAR5T', NULL, 50, 1, NULL, 'products/product2.png', NULL, NULL, 3, 365, NULL, 0, 1, 0, 2, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 6, 'Mantenimiento de Computadores', 'mantenimiento-de-computadores', 'Servicio técnico de mantenimiento preventivo y correctivo de equipos de cómputo.', 'Mantenimiento técnico de PC y laptops', 120000.00, 150000.00, NULL, 'PRD-FUTAYK2F', NULL, 1, 0, NULL, 'products/product3.png', NULL, NULL, 3, 365, NULL, 1, 1, 0, 3, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 6, 'Diseño Web Profesional', 'diseno-web-profesional', 'Creación de sitios web modernos, responsivos y optimizados para SEO.', 'Diseño de páginas web profesionales', 950000.00, 1200000.00, NULL, 'PRD-QTN0PPNI', NULL, 1, 0, NULL, 'products/product4.png', NULL, NULL, 3, 365, NULL, 1, 1, 0, 4, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(5, 6, 'Consultoría Tecnológica', 'consultoria-tecnologica', 'Asesoría especializada en transformación digital y automatización.', 'Consultoría digital y tecnológica', 350000.00, NULL, NULL, 'PRD-HQBRQZX6', NULL, 1, 0, NULL, 'products/product5.png', NULL, NULL, 3, 365, NULL, 0, 1, 0, 5, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(6, 7, 'Instalación de Cámaras de Seguridad', 'instalacion-de-camaras-de-seguridad', 'Instalación profesional de sistemas de videovigilancia IP y analógicos.', 'Instalación de cámaras de seguridad', 800000.00, 950000.00, NULL, 'PRD-Q2REIDJI', NULL, 1, 0, NULL, 'products/product6.png', NULL, NULL, 3, 365, NULL, 1, 1, 0, 6, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(7, 7, 'Cableado Estructurado de Red', 'cableado-estructurado-de-red', 'Diseño e instalación de cableado de red para oficinas y hogares.', 'Cableado estructurado y redes', 550000.00, 700000.00, NULL, 'PRD-L4QF6IKQ', NULL, 1, 0, NULL, 'products/product7.png', NULL, NULL, 3, 365, NULL, 0, 1, 0, 7, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(8, 7, 'Configuración de Servidores', 'configuracion-de-servidores', 'Implementación, configuración y mantenimiento de servidores locales o en la nube.', 'Configuración profesional de servidores', 1200000.00, 1500000.00, NULL, 'PRD-ELLH2E2U', NULL, 1, 0, NULL, 'products/product8.png', NULL, NULL, 3, 365, NULL, 1, 1, 0, 8, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Electrónica', 'electronica', 'Productos electrónicos y tecnología', NULL, 1, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 'Ropa y Accesorios', 'ropa-y-accesorios', 'Moda, ropa y accesorios', NULL, 1, 2, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 'Hogar y Jardín', 'hogar-y-jardin', 'Artículos para el hogar y jardín', NULL, 1, 3, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 'Deportes', 'deportes', 'Artículos deportivos y fitness', NULL, 1, 4, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(5, 'Libros', 'libros', 'Libros y revistas', NULL, 1, 5, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(6, 'Servicios', 'servicios', 'Servicios profesionales y técnicos ofrecidos por la empresa', NULL, 1, 6, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(7, 'Instalaciones', 'instalaciones', 'Instalaciones técnicas, eléctricas y de redes', NULL, 1, 7, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_downloads`
--

CREATE TABLE `product_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `download_token` varchar(64) NOT NULL,
  `downloads_count` int(11) NOT NULL DEFAULT 0,
  `max_downloads` int(11) NOT NULL DEFAULT 3,
  `expires_at` timestamp NULL DEFAULT NULL,
  `last_downloaded_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `project_date` date DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`id`, `category_id`, `title`, `slug`, `short_description`, `description`, `client`, `project_date`, `url`, `is_featured`, `is_active`, `order`, `image`, `featured_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Portal Corporativo ABC', 'portal-corporativo-abc', 'Desarrollo de portal web corporativo con panel de administración', 'Desarrollamos un portal web corporativo completo con sistema de gestión de contenidos, integración con redes sociales y panel de administración personalizado.', 'ABC Corporation', '2024-06-15', 'https://ejemplo.com', 1, 1, 1, NULL, 'projects/default-project-1.png', '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 2, 'App de Delivery FoodNow', 'app-de-delivery-foodnow', 'Aplicación móvil para pedidos de comida a domicilio', 'Creamos una aplicación móvil completa para iOS y Android que permite a los usuarios ordenar comida de restaurantes locales.', 'FoodNow Inc.', '2024-08-22', NULL, 1, 1, 2, NULL, 'projects/default-project-2.png', '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 4, 'Tienda Online Fashion Store', 'tienda-online-fashion-store', 'E-commerce completo para tienda de moda', 'Desarrollamos una tienda online completa con carrito de compras, sistema de pagos integrado, gestión de inventario y panel de administración.', 'Fashion Store', '2024-09-10', NULL, 0, 1, 3, NULL, 'projects/default-project-3.png', '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 3, 'Rediseño UX de Banking App', 'rediseno-ux-de-banking-app', 'Rediseño completo de interfaz para app bancaria', 'Realizamos un rediseño completo de la experiencia de usuario y la interfaz de una aplicación bancaria.', 'Banco Digital', '2024-07-18', NULL, 0, 1, 4, NULL, 'projects/default-project-4.png', '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_categories`
--

CREATE TABLE `project_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `project_categories`
--

INSERT INTO `project_categories` (`id`, `name`, `slug`, `description`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Desarrollo Web', 'desarrollo-web', 'Proyectos de desarrollo web', 1, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 'Aplicaciones Móviles', 'aplicaciones-moviles', 'Apps móviles iOS y Android', 1, 2, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 'Diseño UX/UI', 'diseno-uxui', 'Proyectos de diseño de interfaces', 1, 3, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 'E-commerce', 'e-commerce', 'Tiendas online y plataformas de venta', 1, 4, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `description`, `short_description`, `icon`, `image`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Desarrollo Web', 'desarrollo-web', 'Desarrollamos sitios web profesionales, modernos y completamente responsivos. Utilizamos las últimas tecnologías para garantizar el mejor rendimiento y experiencia de usuario.', 'Creamos sitios web modernos y responsivos', '💻', NULL, 1, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 'Diseño Gráfico', 'diseno-grafico', 'Creamos diseños únicos y profesionales que reflejan la identidad de tu marca. Desde logos hasta material publicitario completo.', 'Diseños creativos que destacan tu marca', '🎨', NULL, 1, 2, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 'Marketing Digital', 'marketing-digital', 'Desarrollamos estrategias de marketing digital efectivas para aumentar tu presencia online y generar más ventas.', 'Estrategias para hacer crecer tu negocio', '📱', NULL, 1, 3, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 'Consultoría IT', 'consultoria-it', 'Brindamos consultoría especializada en tecnología para optimizar tus procesos y tomar las mejores decisiones tecnológicas.', 'Asesoramiento tecnológico experto', '🔧', NULL, 1, 4, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NkhhoyDfLrIvcdH1bMrgG6qxw2vLiXWwKWw7gZg8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXg2cnVMRU4zdmVrMndxV1hGNGhtUk5vbWk2MnR4MGg5Z3ZKb2NhZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYXZpY29uLmljbz92PTE3NzYyOTc0MDYiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1776297407);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_slogan` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `primary_color` varchar(255) DEFAULT NULL,
  `secondary_color` varchar(255) DEFAULT NULL,
  `accent_color` varchar(255) DEFAULT NULL,
  `facebook_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `twitter_url` varchar(255) DEFAULT NULL,
  `linkedin_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `whatsapp_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `show_email` tinyint(1) NOT NULL DEFAULT 1,
  `contact_email` varchar(255) DEFAULT NULL,
  `show_phone` tinyint(1) NOT NULL DEFAULT 1,
  `contact_phone` varchar(255) DEFAULT NULL,
  `show_address` tinyint(1) NOT NULL DEFAULT 1,
  `contact_address` text DEFAULT NULL,
  `show_map` tinyint(1) NOT NULL DEFAULT 0,
  `google_maps_url` text DEFAULT NULL,
  `hero_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `cta_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` text DEFAULT NULL,
  `hero_button_text` varchar(255) DEFAULT NULL,
  `hero_button_url` varchar(255) DEFAULT NULL,
  `hero_background_type` enum('color','image','video') NOT NULL DEFAULT 'color',
  `hero_background_image` varchar(255) DEFAULT NULL,
  `hero_background_video` varchar(255) DEFAULT NULL,
  `hero_overlay_opacity` decimal(3,2) NOT NULL DEFAULT 0.50,
  `about_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `features_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `stats_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `stats_bg_color` varchar(255) NOT NULL DEFAULT '#000000',
  `stats_number_color` varchar(255) NOT NULL DEFAULT '#f5f500',
  `about_title` varchar(255) DEFAULT NULL,
  `about_description` text DEFAULT NULL,
  `about_image` varchar(255) DEFAULT NULL,
  `services_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `products_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `shop_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `testimonials_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `gallery_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `contact_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `show_social_footer` tinyint(1) NOT NULL DEFAULT 1,
  `footer_text` text DEFAULT NULL,
  `show_whatsapp_button` tinyint(1) NOT NULL DEFAULT 1,
  `whatsapp_button_message` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `google_analytics_id` varchar(255) DEFAULT NULL,
  `facebook_pixel_id` varchar(255) DEFAULT NULL,
  `notification_email` varchar(255) DEFAULT NULL,
  `business_hours` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hero_title_color` varchar(255) DEFAULT '#ffffff',
  `hero_title_font` varchar(255) DEFAULT 'default',
  `hero_show_logo_instead` tinyint(1) NOT NULL DEFAULT 0,
  `navbar_bg_color` varchar(255) DEFAULT '#ffffff',
  `navbar_text_color` varchar(255) DEFAULT '#000000',
  `navbar_show_logo` tinyint(1) NOT NULL DEFAULT 1,
  `navbar_show_title` tinyint(1) NOT NULL DEFAULT 1,
  `navbar_show_slogan` tinyint(1) NOT NULL DEFAULT 1,
  `navbar_show_shop` tinyint(1) NOT NULL DEFAULT 1,
  `navbar_menu_labels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`navbar_menu_labels`)),
  `hero_logo_x` int(11) NOT NULL DEFAULT 50,
  `hero_logo_y` int(11) NOT NULL DEFAULT 50,
  `hero_logo_size` int(11) NOT NULL DEFAULT 112
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `site_slogan`, `logo`, `favicon`, `primary_color`, `secondary_color`, `accent_color`, `facebook_enabled`, `facebook_url`, `instagram_enabled`, `instagram_url`, `twitter_enabled`, `twitter_url`, `linkedin_enabled`, `linkedin_url`, `whatsapp_enabled`, `whatsapp_number`, `show_email`, `contact_email`, `show_phone`, `contact_phone`, `show_address`, `contact_address`, `show_map`, `google_maps_url`, `hero_enabled`, `cta_enabled`, `hero_title`, `hero_subtitle`, `hero_button_text`, `hero_button_url`, `hero_background_type`, `hero_background_image`, `hero_background_video`, `hero_overlay_opacity`, `about_enabled`, `features_enabled`, `stats_enabled`, `stats_bg_color`, `stats_number_color`, `about_title`, `about_description`, `about_image`, `services_enabled`, `products_enabled`, `shop_enabled`, `testimonials_enabled`, `gallery_enabled`, `contact_enabled`, `show_social_footer`, `footer_text`, `show_whatsapp_button`, `whatsapp_button_message`, `meta_description`, `meta_keywords`, `google_analytics_id`, `facebook_pixel_id`, `notification_email`, `business_hours`, `created_at`, `updated_at`, `hero_title_color`, `hero_title_font`, `hero_show_logo_instead`, `navbar_bg_color`, `navbar_text_color`, `navbar_show_logo`, `navbar_show_title`, `navbar_show_slogan`, `navbar_show_shop`, `navbar_menu_labels`, `hero_logo_x`, `hero_logo_y`, `hero_logo_size`) VALUES
(1, 'Mi Landing Page', 'Tu solución perfecta', NULL, 'favicon.ico', '#3B82F6', '#8B5CF6', '#10B981', 0, NULL, 0, NULL, 0, NULL, 0, NULL, 0, NULL, 1, 'contacto@ejemplo.com', 1, NULL, 1, NULL, 0, NULL, 1, 1, 'Bienvenido a Tu LandingPage', 'Ofrecemos las mejores soluciones para tu negocio', 'Comenzar', '#contacto', 'color', NULL, NULL, 0.50, 1, 1, 1, '#000000', '#f5f500', 'Soluciones tecnológicas para tu negocio', 'Somos una empresa especializada en tecnología y servicios IT, comprometida con ofrecer soluciones innovadoras para empresas y personas que buscan optimizar sus procesos digitales.\n\nBrindamos servicios de mantenimiento, instalación de redes, configuración de servidores, diseño web y consultoría tecnológica, adaptándonos a las necesidades específicas de cada cliente.', NULL, 1, 1, 1, 1, 1, 1, 1, NULL, 1, 'Hola, quiero más información', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49', '#ffffff', 'default', 1, '#000000', '#ffffff', 1, 1, 1, 1, NULL, 50, 50, 112);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Colombia',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stats`
--

CREATE TABLE `stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `target` int(11) NOT NULL,
  `suffix` varchar(255) NOT NULL DEFAULT '',
  `duration` int(11) NOT NULL DEFAULT 20,
  `step` int(11) NOT NULL DEFAULT 5,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `stats`
--

INSERT INTO `stats` (`id`, `label`, `value`, `target`, `suffix`, `duration`, `step`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Proyectos Completados', '150+', 150, '+', 20, 5, 1, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 'Satisfacción del Cliente', '95%', 95, '%', 30, 5, 2, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 'Años de Experiencia', '20+', 20, '+', 200, 1, 3, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 'Clientes Satisfechos', '2000+', 2000, '+', 10, 50, 4, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_position` varchar(255) DEFAULT NULL,
  `client_company` varchar(255) DEFAULT NULL,
  `testimonial` text NOT NULL,
  `client_photo` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `client_position`, `client_company`, `testimonial`, `client_photo`, `rating`, `is_featured`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'María González', 'CEO', 'Tech Solutions', 'Excelente trabajo, superaron nuestras expectativas. El equipo fue profesional y entregó el proyecto a tiempo. Definitivamente los recomendaría.', 'testimonials/default-testimonial-1.jpg', 5, 1, 1, 1, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(2, 'Carlos Rodríguez', 'Director de Marketing', 'Fashion Store', 'La tienda online que desarrollaron para nosotros ha incrementado nuestras ventas en un 300%. Altamente recomendados.', 'testimonials/default-testimonial-2.jpg', 5, 1, 1, 2, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(3, 'Ana Martínez', 'Gerente General', 'ABC Corporation', 'Profesionales, creativos y muy responsables. Nuestro nuevo portal web es exactamente lo que necesitábamos.', 'testimonials/default-testimonial-3.jpg', 5, 1, 1, 3, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(4, 'Roberto Silva', 'Product Manager', 'FoodNow Inc.', 'La app que desarrollaron funciona perfectamente. Los usuarios están muy satisfechos y hemos recibido excelentes comentarios.', 'testimonials/default-testimonial-4.jpg', 4, 1, 1, 4, '2026-04-16 04:30:49', '2026-04-16 04:30:49'),
(5, 'Laura Pérez', 'Directora de Innovación', 'Banco Digital', 'El rediseño de nuestra app ha mejorado significativamente la experiencia de nuestros usuarios. Trabajo impecable.', 'testimonials/default-testimonial-5.jpg', 5, 1, 1, 5, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','editor','researcher','columnist','seller','customer','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'skuboxit@gmail.com', '2026-04-16 04:30:47', '$2y$12$8hEyd0BGdlHqfIc75hP5s.VpgC.Jk6xpEScSBJoTui/T6ChNvQ2da', 'admin', NULL, '2026-04-16 04:30:47', '2026-04-16 04:30:47'),
(2, 'Editor', 'editor@tudominio.com', '2026-04-16 04:30:48', '$2y$12$kWmkoaikzWYIdmGIGjzIjukO1VNqnQCtMpx5Qhw5yCVArpuukBLqe', 'editor', NULL, '2026-04-16 04:30:48', '2026-04-16 04:30:48'),
(3, 'Investigador', 'researcher@tudominio.com', '2026-04-16 04:30:48', '$2y$12$/Fgq.PIMOoAsUo7OIWPx.eNfbHipmghW5jWi7MLKzx1OqSqoKMfEq', 'researcher', NULL, '2026-04-16 04:30:48', '2026-04-16 04:30:48'),
(4, 'Columnista', 'columnist@tudominio.com', '2026-04-16 04:30:48', '$2y$12$nDdmXSfrBxFNNBN6xpPAnu7PgBfUJdyuNSmpE8WzW2vAcBeVv7Z3a', 'columnist', NULL, '2026-04-16 04:30:48', '2026-04-16 04:30:48'),
(5, 'Vendedor', 'seller@tudominio.com', '2026-04-16 04:30:48', '$2y$12$iAQsLD0K/BbE/9X5lMQrAeyAKJQSFIGk0sIr98Kmup24zuSkJ/eB2', 'seller', NULL, '2026-04-16 04:30:48', '2026-04-16 04:30:48'),
(6, 'Cliente', 'customer@tudominio.com', '2026-04-16 04:30:48', '$2y$12$kz7cjjzoVHgP.EN79unjm.B0eixPDi2sC9vPkuq1G7zNY0AwwI5rK', 'customer', NULL, '2026-04-16 04:30:48', '2026-04-16 04:30:48'),
(7, 'Usuario', 'user@tudominio.com', '2026-04-16 04:30:49', '$2y$12$1dWtciVnKLCq2wpfaoO4leNA8E7juuN8rtK/.0oiG5J1WhPoV/lnO', 'user', NULL, '2026-04-16 04:30:49', '2026-04-16 04:30:49');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_session_id_index` (`session_id`),
  ADD KEY `carts_expires_at_index` (`expires_at`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_index` (`cart_id`),
  ADD KEY `cart_items_product_id_index` (`product_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_status_index` (`status`),
  ADD KEY `leads_created_at_index` (`created_at`),
  ADD KEY `leads_email_index` (`email`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_order_number_index` (`order_number`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_created_at_index` (`created_at`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_index` (`order_id`),
  ADD KEY `order_items_product_id_index` (`product_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_reference_unique` (`reference`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_slug_index` (`slug`),
  ADD KEY `products_sku_index` (`sku`),
  ADD KEY `products_is_active_index` (`is_active`),
  ADD KEY `products_is_featured_index` (`is_featured`),
  ADD KEY `products_category_id_index` (`category_id`);

--
-- Indices de la tabla `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_categories_slug_unique` (`slug`),
  ADD KEY `product_categories_slug_index` (`slug`),
  ADD KEY `product_categories_is_active_index` (`is_active`);

--
-- Indices de la tabla `product_downloads`
--
ALTER TABLE `product_downloads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_downloads_download_token_unique` (`download_token`),
  ADD KEY `product_downloads_product_id_foreign` (`product_id`),
  ADD KEY `product_downloads_order_id_product_id_index` (`order_id`,`product_id`),
  ADD KEY `product_downloads_download_token_index` (`download_token`),
  ADD KEY `product_downloads_expires_at_index` (`expires_at`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_slug_unique` (`slug`),
  ADD KEY `projects_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_categories_slug_unique` (`slug`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_order_id_index` (`order_id`);

--
-- Indices de la tabla `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `product_downloads`
--
ALTER TABLE `product_downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `stats`
--
ALTER TABLE `stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `product_downloads`
--
ALTER TABLE `product_downloads`
  ADD CONSTRAINT `product_downloads_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_downloads_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
