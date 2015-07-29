/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : ykt

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-07-28 10:00:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `area`
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `parent` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of area
-- ----------------------------
INSERT INTO `area` VALUES ('1301', '石家庄市', '13');
INSERT INTO `area` VALUES ('130102', '长安区', '1301');
INSERT INTO `area` VALUES ('130104', '桥西区', '1301');
INSERT INTO `area` VALUES ('130105', '新华区', '1301');
INSERT INTO `area` VALUES ('130107', '井陉矿区', '1301');
INSERT INTO `area` VALUES ('130108', '裕华区', '1301');
INSERT INTO `area` VALUES ('130109', '藁城区', '1301');
INSERT INTO `area` VALUES ('130110', '鹿泉区', '1301');
INSERT INTO `area` VALUES ('130111', '栾城区', '1301');
INSERT INTO `area` VALUES ('130121', '井陉县', '1301');
INSERT INTO `area` VALUES ('130123', '正定县', '1301');
INSERT INTO `area` VALUES ('130125', '行唐县', '1301');
INSERT INTO `area` VALUES ('130126', '灵寿县', '1301');
INSERT INTO `area` VALUES ('130127', '高邑县', '1301');
INSERT INTO `area` VALUES ('130128', '深泽县', '1301');
INSERT INTO `area` VALUES ('130129', '赞皇县', '1301');
INSERT INTO `area` VALUES ('130130', '无极县', '1301');
INSERT INTO `area` VALUES ('130131', '平山县', '1301');
INSERT INTO `area` VALUES ('130132', '元氏县', '1301');
INSERT INTO `area` VALUES ('130133', '赵县', '1301');
INSERT INTO `area` VALUES ('130181', '辛集市', '1301');
INSERT INTO `area` VALUES ('130183', '晋州市', '1301');
INSERT INTO `area` VALUES ('130184', '新乐市', '1301');
INSERT INTO `area` VALUES ('1302', '唐山市', '13');
INSERT INTO `area` VALUES ('130202', '路南区', '1302');
INSERT INTO `area` VALUES ('130203', '路北区', '1302');
INSERT INTO `area` VALUES ('130204', '古冶区', '1302');
INSERT INTO `area` VALUES ('130205', '开平区', '1302');
INSERT INTO `area` VALUES ('130207', '丰南区', '1302');
INSERT INTO `area` VALUES ('130208', '丰润区', '1302');
INSERT INTO `area` VALUES ('130209', '曹妃甸区', '1302');
INSERT INTO `area` VALUES ('130223', '滦县', '1302');
INSERT INTO `area` VALUES ('130224', '滦南县', '1302');
INSERT INTO `area` VALUES ('130225', '乐亭县', '1302');
INSERT INTO `area` VALUES ('130227', '迁西县', '1302');
INSERT INTO `area` VALUES ('130229', '玉田县', '1302');
INSERT INTO `area` VALUES ('130281', '遵化市', '1302');
INSERT INTO `area` VALUES ('130283', '迁安市', '1302');
INSERT INTO `area` VALUES ('1303', '秦皇岛市', '13');
INSERT INTO `area` VALUES ('130302', '海港区', '1303');
INSERT INTO `area` VALUES ('130303', '山海关区', '1303');
INSERT INTO `area` VALUES ('130304', '北戴河区', '1303');
INSERT INTO `area` VALUES ('130321', '青龙满族自治县', '1303');
INSERT INTO `area` VALUES ('130322', '昌黎县', '1303');
INSERT INTO `area` VALUES ('130323', '抚宁县', '1303');
INSERT INTO `area` VALUES ('130324', '卢龙县', '1303');
INSERT INTO `area` VALUES ('1304', '邯郸市', '13');
INSERT INTO `area` VALUES ('130402', '邯山区', '1304');
INSERT INTO `area` VALUES ('130403', '丛台区', '1304');
INSERT INTO `area` VALUES ('130404', '复兴区', '1304');
INSERT INTO `area` VALUES ('130406', '峰峰矿区', '1304');
INSERT INTO `area` VALUES ('130421', '邯郸县', '1304');
INSERT INTO `area` VALUES ('130423', '临漳县', '1304');
INSERT INTO `area` VALUES ('130424', '成安县', '1304');
INSERT INTO `area` VALUES ('130425', '大名县', '1304');
INSERT INTO `area` VALUES ('130426', '涉县', '1304');
INSERT INTO `area` VALUES ('130427', '磁县', '1304');
INSERT INTO `area` VALUES ('130428', '肥乡县', '1304');
INSERT INTO `area` VALUES ('130429', '永年县', '1304');
INSERT INTO `area` VALUES ('130430', '邱县', '1304');
INSERT INTO `area` VALUES ('130431', '鸡泽县', '1304');
INSERT INTO `area` VALUES ('130432', '广平县', '1304');
INSERT INTO `area` VALUES ('130433', '馆陶县', '1304');
INSERT INTO `area` VALUES ('130434', '魏县', '1304');
INSERT INTO `area` VALUES ('130435', '曲周县', '1304');
INSERT INTO `area` VALUES ('130481', '武安市', '1304');
INSERT INTO `area` VALUES ('1305', '邢台市', '13');
INSERT INTO `area` VALUES ('130502', '桥东区', '1305');
INSERT INTO `area` VALUES ('130503', '桥西区', '1305');
INSERT INTO `area` VALUES ('130521', '邢台县', '1305');
INSERT INTO `area` VALUES ('130522', '临城县', '1305');
INSERT INTO `area` VALUES ('130523', '内丘县', '1305');
INSERT INTO `area` VALUES ('130524', '柏乡县', '1305');
INSERT INTO `area` VALUES ('130525', '隆尧县', '1305');
INSERT INTO `area` VALUES ('130526', '任县', '1305');
INSERT INTO `area` VALUES ('130527', '南和县', '1305');
INSERT INTO `area` VALUES ('130528', '宁晋县', '1305');
INSERT INTO `area` VALUES ('130529', '巨鹿县', '1305');
INSERT INTO `area` VALUES ('130530', '新河县', '1305');
INSERT INTO `area` VALUES ('130531', '广宗县', '1305');
INSERT INTO `area` VALUES ('130532', '平乡县', '1305');
INSERT INTO `area` VALUES ('130533', '威县', '1305');
INSERT INTO `area` VALUES ('130534', '清河县', '1305');
INSERT INTO `area` VALUES ('130535', '临西县', '1305');
INSERT INTO `area` VALUES ('130581', '南宫市', '1305');
INSERT INTO `area` VALUES ('130582', '沙河市', '1305');
INSERT INTO `area` VALUES ('1306', '保定市', '13');
INSERT INTO `area` VALUES ('130602', '新市区', '1306');
INSERT INTO `area` VALUES ('130603', '北市区', '1306');
INSERT INTO `area` VALUES ('130604', '南市区', '1306');
INSERT INTO `area` VALUES ('130621', '满城县', '1306');
INSERT INTO `area` VALUES ('130622', '清苑县', '1306');
INSERT INTO `area` VALUES ('130623', '涞水县', '1306');
INSERT INTO `area` VALUES ('130624', '阜平县', '1306');
INSERT INTO `area` VALUES ('130625', '徐水县', '1306');
INSERT INTO `area` VALUES ('130626', '定兴县', '1306');
INSERT INTO `area` VALUES ('130627', '唐县', '1306');
INSERT INTO `area` VALUES ('130628', '高阳县', '1306');
INSERT INTO `area` VALUES ('130629', '容城县', '1306');
INSERT INTO `area` VALUES ('130630', '涞源县', '1306');
INSERT INTO `area` VALUES ('130631', '望都县', '1306');
INSERT INTO `area` VALUES ('130632', '安新县', '1306');
INSERT INTO `area` VALUES ('130633', '易县', '1306');
INSERT INTO `area` VALUES ('130634', '曲阳县', '1306');
INSERT INTO `area` VALUES ('130635', '蠡县', '1306');
INSERT INTO `area` VALUES ('130636', '顺平县', '1306');
INSERT INTO `area` VALUES ('130637', '博野县', '1306');
INSERT INTO `area` VALUES ('130638', '雄县', '1306');
INSERT INTO `area` VALUES ('130681', '涿州市', '1306');
INSERT INTO `area` VALUES ('130682', '定州市', '1306');
INSERT INTO `area` VALUES ('130683', '安国市', '1306');
INSERT INTO `area` VALUES ('130684', '高碑店市', '1306');
INSERT INTO `area` VALUES ('1307', '张家口市', '13');
INSERT INTO `area` VALUES ('130702', '桥东区', '1307');
INSERT INTO `area` VALUES ('130703', '桥西区', '1307');
INSERT INTO `area` VALUES ('130705', '宣化区', '1307');
INSERT INTO `area` VALUES ('130706', '下花园区', '1307');
INSERT INTO `area` VALUES ('130721', '宣化县', '1307');
INSERT INTO `area` VALUES ('130722', '张北县', '1307');
INSERT INTO `area` VALUES ('130723', '康保县', '1307');
INSERT INTO `area` VALUES ('130724', '沽源县', '1307');
INSERT INTO `area` VALUES ('130725', '尚义县', '1307');
INSERT INTO `area` VALUES ('130726', '蔚县', '1307');
INSERT INTO `area` VALUES ('130727', '阳原县', '1307');
INSERT INTO `area` VALUES ('130728', '怀安县', '1307');
INSERT INTO `area` VALUES ('130729', '万全县', '1307');
INSERT INTO `area` VALUES ('130730', '怀来县', '1307');
INSERT INTO `area` VALUES ('130731', '涿鹿县', '1307');
INSERT INTO `area` VALUES ('130732', '赤城县', '1307');
INSERT INTO `area` VALUES ('130733', '崇礼县', '1307');
INSERT INTO `area` VALUES ('1308', '承德市', '13');
INSERT INTO `area` VALUES ('130802', '双桥区', '1308');
INSERT INTO `area` VALUES ('130803', '双滦区', '1308');
INSERT INTO `area` VALUES ('130804', '鹰手营子矿区', '1308');
INSERT INTO `area` VALUES ('130821', '承德县', '1308');
INSERT INTO `area` VALUES ('130822', '兴隆县', '1308');
INSERT INTO `area` VALUES ('130823', '平泉县', '1308');
INSERT INTO `area` VALUES ('130824', '滦平县', '1308');
INSERT INTO `area` VALUES ('130825', '隆化县', '1308');
INSERT INTO `area` VALUES ('130826', '丰宁满族自治县', '1308');
INSERT INTO `area` VALUES ('130827', '宽城满族自治县', '1308');
INSERT INTO `area` VALUES ('130828', '围场满族蒙古族自治县', '1308');
INSERT INTO `area` VALUES ('1309', '沧州市', '13');
INSERT INTO `area` VALUES ('130902', '新华区', '1309');
INSERT INTO `area` VALUES ('130903', '运河区', '1309');
INSERT INTO `area` VALUES ('130921', '沧县', '1309');
INSERT INTO `area` VALUES ('130922', '青县', '1309');
INSERT INTO `area` VALUES ('130923', '东光县', '1309');
INSERT INTO `area` VALUES ('130924', '海兴县', '1309');
INSERT INTO `area` VALUES ('130925', '盐山县', '1309');
INSERT INTO `area` VALUES ('130926', '肃宁县', '1309');
INSERT INTO `area` VALUES ('130927', '南皮县', '1309');
INSERT INTO `area` VALUES ('130928', '吴桥县', '1309');
INSERT INTO `area` VALUES ('130929', '献县', '1309');
INSERT INTO `area` VALUES ('130930', '孟村回族自治县', '1309');
INSERT INTO `area` VALUES ('130981', '泊头市', '1309');
INSERT INTO `area` VALUES ('130982', '任丘市', '1309');
INSERT INTO `area` VALUES ('130983', '黄骅市', '1309');
INSERT INTO `area` VALUES ('130984', '河间市', '1309');
INSERT INTO `area` VALUES ('1310', '廊坊市', '13');
INSERT INTO `area` VALUES ('131002', '安次区', '1310');
INSERT INTO `area` VALUES ('131003', '广阳区', '1310');
INSERT INTO `area` VALUES ('131022', '固安县', '1310');
INSERT INTO `area` VALUES ('131023', '永清县', '1310');
INSERT INTO `area` VALUES ('131024', '香河县', '1310');
INSERT INTO `area` VALUES ('131025', '大城县', '1310');
INSERT INTO `area` VALUES ('131026', '文安县', '1310');
INSERT INTO `area` VALUES ('131028', '大厂回族自治县', '1310');
INSERT INTO `area` VALUES ('131081', '霸州市', '1310');
INSERT INTO `area` VALUES ('131082', '三河市', '1310');
INSERT INTO `area` VALUES ('1311', '衡水市', '13');
INSERT INTO `area` VALUES ('131102', '桃城区', '1311');
INSERT INTO `area` VALUES ('131121', '枣强县', '1311');
INSERT INTO `area` VALUES ('131122', '武邑县', '1311');
INSERT INTO `area` VALUES ('131123', '武强县', '1311');
INSERT INTO `area` VALUES ('131124', '饶阳县', '1311');
INSERT INTO `area` VALUES ('131125', '安平县', '1311');
INSERT INTO `area` VALUES ('131126', '故城县', '1311');
INSERT INTO `area` VALUES ('131127', '景县', '1311');
INSERT INTO `area` VALUES ('131128', '阜城县', '1311');
INSERT INTO `area` VALUES ('131181', '冀州市', '1311');
INSERT INTO `area` VALUES ('131182', '深州市', '1311');
