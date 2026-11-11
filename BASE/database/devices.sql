-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2025 a las 22:57:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `devices`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `img` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `img`) VALUES
(1, 'iPhone / iPad / Mac', 'Dispositivos móviles y computadoras Apple', 'https://imgs.search.brave.com/l_HWfV88M48k8ng4EvBJO9vAliBQGDdnT8p5RHRLuJ4/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/YXBwbGUuY29tL3Yv/bWFjb3MvY29udGlu/dWl0eS9pL2ltYWdl/cy9vdmVydmlldy9j/YWxsc190ZXh0c19f/Z2FzYnA0Z3VlY2V5/X2xhcmdlLmpwZw'),
(2, 'Apple Watch  2025', 'Relojes inteligentes Apple Watch', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/watches-value-tradein-202509?wid=780&hei=708&fmt=png-alpha&.v=enY0dFpVVEw3eEpGS3lLQSt2NzlCdGpZMkNwWlN6K0NNQ3lVbzdEZHdmbDl6dzhnbllNOEt6MC9vMUdtTEw3R3g2bitObzZwQzk4cEorV1dZdzhIazhGNEU2SEVuSFN1WEpwWjRydmFtWWc'),
(3, 'AirPods', 'Auriculares inalámbricos y accesorios de audio', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/airpods-max-hero-select-202409?wid=976&hei=916&fmt=jpeg&qlt=90&.v=WXBZVEZCOUNiUWlBYUtjZmtBc0J2N1V1ZldxRmdZVjlvL2IxaEY3dzY3SG0ybW5TK3prTnlNTURRc1V2clYydHZvdUZlR0V0VUdJSjBWaDVNVG95YkJTUUExTVpiaXRIUnFOM1YxY0hPWFU'),
(4, 'HomePod / Apple TV', 'Dispositivos de entretenimiento y hogar', 'https://www.apple.com/v/tv-home/o/images/overview/apple_tv_4k__b30wcqp0pdle_large.jpg'),
(5, 'Accesorios', 'Teclados, mouse, lápices y otros accesorios Apple', 'https://m.media-amazon.com/images/I/51CBHkbqPzL._AC_SX679_.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `img` varchar(250) NOT NULL,
  `model` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `img`, `model`, `price`, `description`, `id_category`) VALUES
(2, 'Apple Watch Series 11', 'https://http2.mlstatic.com/D_NQ_NP_743107-CBT92553161980_092025-OO.jpg', 'Series 11', 500, 'Reloj inteligente con pantalla Retina LTPO OLED y múltiples sensores.', 2),
(3, 'AirPods ProMax', 'https://http2.mlstatic.com/D_NQ_NP_851599-MLA82173621052_022025-OO.jpg', 'ProMax', 150, 'Auriculares con sonido de alta fidelidad y cancelación activa de ruido.', 3),
(6, 'HomePod Mini', 'https://http2.mlstatic.com/D_NQ_NP_840202-MLA45740046421_042021-OO.jpg', 'Mini', 100, 'Altavoz inteligente compacto con Siri integrado.', 4),
(8, 'Apple TV 4K', 'https://http2.mlstatic.com/D_NQ_NP_662921-MLA53529199006_012023-OO.jpg', '4K', 200, 'Dispositivo de streaming con resolución 4K HDR.', 4),
(9, 'Magic Keyboard Wireless', 'https://http2.mlstatic.com/D_NQ_NP_890506-MLU76759497777_052024-OO.jpg', 'Wireless', 120, 'Teclado inalámbrico con diseño minimalista y batería recargable.', 5),
(10, 'Magic Mouse 2nd Gen', 'https://http2.mlstatic.com/D_NQ_NP_624987-MLA48881660084_012022-OO.jpg', '2nd Gen', 80, 'Ratón inalámbrico con superficie multitáctil y diseño ergonómico.', 5),
(13, 'Apple Watch SE', 'https://http2.mlstatic.com/D_NQ_NP_904908-MLA92851412157_092025-OO.jpg', 'SE', 350, 'Reloj inteligente económico con funciones de salud y actividad.', 2),
(14, 'AirPods 3rd Gen', 'https://http2.mlstatic.com/D_NQ_NP_701256-MLU70634033372_072023-O.webp', '3rd Gen', 180, 'Auriculares inalámbricos con buen sonido y resistencia al agua.', 3),
(15, 'HomePod', 'https://http2.mlstatic.com/D_NQ_NP_734624-MLA87783131196_072025-OO.jpg', 'Original', 300, 'Altavoz inteligente con sonido de alta calidad y Siri integrado.', 4),
(16, 'Apple TV HD', 'https://http2.mlstatic.com/D_NQ_NP_633039-MLA32691404911_102019-OO.jpg', 'HD', 150, 'Dispositivo de streaming en HD con acceso a Apple TV+', 4),
(18, 'Magic Trackpad', 'https://http2.mlstatic.com/D_NQ_NP_787420-MLA84187497362_052025-OO.jpg', '2nd Gen', 120, 'Trackpad inalámbrico con gestos multitáctiles.', 5),
(19, 'Mac Mini', 'https://http2.mlstatic.com/D_NQ_NP_697274-MLA83598153563_042025-OO.jpg', '2025 M2', 1000, 'Mini computadora potente para escritorio con chip M2.', 5),
(20, 'AirPods Pro 2', 'https://http2.mlstatic.com/D_NQ_NP_707825-MLA72508419694_102023-OO.jpg', 'Pro 2', 250, 'Auriculares con cancelación activa de ruido y modo transparencia.', 3),
(22, 'Apple Watch Series 12', 'https://http2.mlstatic.com/D_NQ_NP_611645-MLA91903698062_092025-O.webp', 'Series 12', 550, 'Reloj inteligente con medición de oxígeno y ECG.', 2),
(23, 'AirPods Max', 'https://http2.mlstatic.com/D_NQ_NP_920403-MLU79116952765_092024-OO.jpg', 'Max', 600, 'Auriculares circumaurales con sonido envolvente y cancelación de ruido.', 3),
(24, 'Apple Pencil 2nd Gen', 'https://http2.mlstatic.com/D_NQ_NP_612377-MLA81240009786_122024-O.webp', '2nd Gen', 150, 'Lápiz inteligente para iPad con precisión y respuesta rápida.', 5),
(26, 'Producto Editadoo', 'imagen.jpg', 'Modelo X', 1200, 'Descripción del producto', 2),
(27, 'HomePod 2', 'https://http2.mlstatic.com/D_NQ_NP_850763-MLA87783387438_072025-OO.jpg', 'Segunda Gen', 350, 'Altavoz inteligente con sonido mejorado y Siri.', 4),
(28, 'Magic Keyboard Mac', 'https://http2.mlstatic.com/D_NQ_NP_890506-MLU76759497777_052024-OO.jpg', 'Mac Edition', 130, 'Teclado inalámbrico especialmente para Mac.', 5),
(29, 'Magic Mouse Pro', 'https://http2.mlstatic.com/D_NQ_NP_684898-CBT84589318828_052025-O.webp', 'Pro', 90, 'Ratón avanzado con superficie táctil y Bluetooth.', 5),
(30, 'Apple Watch Ultra', 'https://http2.mlstatic.com/D_NQ_NP_871389-MLU77501910275_072024-OO.jpg', 'Ultra', 800, 'Reloj inteligente con batería extendida y resistencia al agua.', 2),
(32, 'Apple Watch 2025', 'https://m.media-amazon.com/images/I/71mbZF8PT1L._AC_SY300_SX300_QL70_FMwebp_.jpg', '30.0', 250, 'Nuevo Apple Watch', 2),
(35, 'Cable de carga USB-C', 'https://store.storeimages.cdn-apple.com/1/as-images.apple.com/is/MQKJ3?wid=1144&hei=1144&fmt=jpeg&qlt=90&.v=UmJ0VnhkMm9DbDhxclVzaXlNbnVRUWtuVHYzMERCZURia3c5SzJFOTlPaEdPNk5TZkUyRjVjbmZlVkFhb3BFYmQzOU5RUU0yVjg1T0JNOVNCMVhGU0E', '60 W (1 metro)', 25, 'Este cable de carga de 1 metro tiene un diseño trenzado, incluye conectores USB-C en ambos extremos y es perfecto para cargar, sincronizar y transferir datos entre dispositivos USB-C.', 5),
(38, 'Producto Nuevo', 'imagen.jpg', 'Modelo X', 1200, 'Descripción del producto', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `review` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `id_product` int(11) NOT NULL,
  `calification` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `review`, `created_at`, `id_product`, `calification`) VALUES
(1, 'María', 'Excelente diseño y precisión en el seguimiento de salud.', '2025-11-12 18:37:07', 2, 5),
(2, 'Juan', 'Batería duradera, pero un poco caro.', '2025-11-12 18:37:07', 2, 4),
(3, 'Lucía', 'Muy cómodo y ligero, ideal para todo el día.', '2025-11-12 18:37:07', 2, 5),
(4, 'Pedro', 'Sonido increíble y cancelación de ruido efectiva.', '2025-11-12 18:37:07', 3, 5),
(5, 'Ana', 'Un poco incómodos para usar por varias horas.', '2025-11-12 18:37:07', 3, 4),
(6, 'Carlos', 'Pequeño pero potente, excelente sonido para su tamaño.', '2025-11-12 18:37:07', 6, 5),
(7, 'Sofía', 'Imagen clara y fluida, ideal para streaming.', '2025-11-12 18:37:07', 8, 5),
(8, 'Diego', 'Funciona perfecto con mi iPhone y Mac.', '2025-11-12 18:37:07', 8, 4),
(9, 'Valentina', 'Escribir es cómodo y silencioso.', '2025-11-12 18:37:07', 9, 5),
(10, 'Martín', 'Buena respuesta táctil, pero el tamaño podría mejorar.', '2025-11-12 18:37:07', 10, 4),
(11, 'Mariana', 'Buen reloj por el precio, funciones suficientes.', '2025-11-12 18:37:07', 13, 4),
(12, 'Alejandro', 'Sonido aceptable, pero esperaba mejor cancelación.', '2025-11-12 18:37:07', 14, 3),
(13, 'Florencia', 'Excelente calidad de audio y diseño elegante.', '2025-11-12 18:37:07', 15, 5),
(14, 'Gonzalo', 'Streaming sin problemas, aunque no es 4K.', '2025-11-12 18:37:07', 16, 4),
(15, 'Patricio', 'Gestos multitáctiles muy precisos.', '2025-11-12 18:37:07', 18, 5),
(16, 'Camila', 'Potente y silenciosa, ideal para oficina.', '2025-11-12 18:37:07', 19, 5),
(17, 'Hernán', 'Muy buen rendimiento, aunque algo caro.', '2025-11-12 18:37:07', 19, 4),
(18, 'Laura', 'Excelente cancelación de ruido.', '2025-11-12 18:37:07', 20, 5),
(19, 'Tomás', 'Buen seguimiento de salud y actividad.', '2025-11-12 18:37:07', 22, 4),
(20, 'Sofía', 'Sonido envolvente y cómodo para largas sesiones.', '2025-11-12 18:37:07', 23, 5),
(21, 'Nicolás', 'Perfecta precisión al escribir y dibujar.', '2025-11-12 18:37:07', 24, 5),
(22, 'Marta', 'Teclado muy cómodo y compatible con Mac.', '2025-11-12 18:37:07', 28, 5),
(23, 'Diego', 'Excelente respuesta y diseño minimalista.', '2025-11-12 18:37:07', 29, 5),
(24, 'Clara', 'Muy resistente y batería de larga duración.', '2025-11-12 18:37:07', 30, 5),
(25, 'Julieta', 'Funciona correctamente, buena longitud.', '2025-11-12 18:37:07', 35, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`) VALUES
(1, 'webadmin', '$2y$10$CFzl2x0uFaaKtwVA5nYlyedQzorwZkd70xsmtfCuavtEbV6kxbUBa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`id_category`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`) USING BTREE;

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
