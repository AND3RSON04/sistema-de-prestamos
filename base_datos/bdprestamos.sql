/*
 Navicat Premium Data Transfer

 Source Server         : cnn
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : bdprestamos

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 18/12/2024 20:15:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `dni` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`dni`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of clientes
-- ----------------------------
INSERT INTO `clientes` VALUES ('74440547', 'MUCHA AMBOLAYA', 'MAGALY ROSARIO', 'san martin', 'complejo deportivo');
INSERT INTO `clientes` VALUES ('74474037', 'GOMEZ ASTETE', 'BRYAN ANDERSON', 'San Sebastian', 'panaderia');
INSERT INTO `clientes` VALUES ('765310', 'AQUINO FERNANDEZ', 'VIOLETA SOLAINNS', 'COMASS', 'asdsad');

-- ----------------------------
-- Table structure for detalle_prestamos
-- ----------------------------
DROP TABLE IF EXISTS `detalle_prestamos`;
CREATE TABLE `detalle_prestamos`  (
  `codigo_p` int NOT NULL AUTO_INCREMENT,
  `codigo` int NULL DEFAULT NULL,
  `numero_cuota` float NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `cuota` float NULL DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`codigo_p`) USING BTREE,
  INDEX `detalle_prestamo`(`codigo` ASC) USING BTREE,
  CONSTRAINT `detalle_prestamo` FOREIGN KEY (`codigo`) REFERENCES `prestamos` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of detalle_prestamos
-- ----------------------------
INSERT INTO `detalle_prestamos` VALUES (1, 2, 1, '2024-12-17', 110, 'Pagado');
INSERT INTO `detalle_prestamos` VALUES (2, 1, 2, '2024-12-17', 110, 'Pagado');
INSERT INTO `detalle_prestamos` VALUES (3, 1, 1, '2024-12-17', 110, 'Pagado');
INSERT INTO `detalle_prestamos` VALUES (4, 1, 3, '2024-12-17', 110, 'Pagado');
INSERT INTO `detalle_prestamos` VALUES (5, 6, 1, '2024-12-19', 110, 'Pagado');

-- ----------------------------
-- Table structure for prestamos
-- ----------------------------
DROP TABLE IF EXISTS `prestamos`;
CREATE TABLE `prestamos`  (
  `codigo` int NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cantidad_prestar` float NULL DEFAULT NULL,
  `interes` int NULL DEFAULT NULL,
  `cuotas` float NULL DEFAULT NULL,
  `pago_mensual` float NULL DEFAULT NULL,
  `color` int NULL DEFAULT NULL,
  `estado` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`) USING BTREE,
  INDEX `prestamos_clientees`(`dni` ASC) USING BTREE,
  CONSTRAINT `prestamos_clientees` FOREIGN KEY (`dni`) REFERENCES `clientes` (`dni`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of prestamos
-- ----------------------------
INSERT INTO `prestamos` VALUES (1, '765310', 'diario', 1000, 10, 10, 110, 1, 'en curso', '2024-12-15');
INSERT INTO `prestamos` VALUES (2, '74474037', 'diario', 1000, 10, 10, 110, 2, 'en curso', '2024-12-15');
INSERT INTO `prestamos` VALUES (3, '74440547', 'diario', 100, 10, 10, 11, 3, 'en curso', '2024-12-15');
INSERT INTO `prestamos` VALUES (6, '765310', 'semanal', 1000, 10, 10, 110, 1, 'en curso', '2024-12-15');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `Datos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `rol` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'Jose alexander yovera simbala', 'admin', 'admin', 1);

SET FOREIGN_KEY_CHECKS = 1;
