CREATE TABLE IF NOT EXISTS `#__yeeditor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `create_date` datetime NOT NULL,
  `published` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__yeeditor_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(100) NOT NULL,
  `option_value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `#__yeeditor_extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(100) NOT NULL,
  `widget_group` varchar(100) NOT NULL DEFAULT 'Social',
  `author` varchar(100) NOT NULL,
  `setting_type` varchar(500) NOT NULL,
  `widget_info` text NOT NULL,
  `install_time` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `published` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

INSERT INTO `#__yeeditor_option` (`id`, `option_name`, `option_value`) VALUES
(1, 'yeeditor_status', '1'),
(2, 'yeeditor_load_font_awesome', '1'),
(3, 'yeeditor_load_jquery', 'local'),
(4, 'yeeditor_load_jquery_backend', 'local'),
(5, 'yeeditor_editor_status', '1'),
(6, 'yeeditor_other_editor', 'tinymce');

INSERT INTO `#__yeeditor_extensions` (`widget_name`, `widget_group`, `author`, `setting_type`, `widget_info`, `install_time`, `last_update`, `published`) VALUES
('wgt_wysiwyg', 'Editor', 'YEEDEEN', '', '[{"0":"Text Block"},{"0":"1.0"},{"0":"MAY 2013"},{"0":"YEEDEEN"},{"0":"info@yeedeen.com"},{"0":"http://yeeditor.com"},{"0":"Copyright (C) 2013"},{"0":"Commercial license; see http://yeedeen.com/license"},{}]', '2013-09-04 13:28:46', '2013-09-04 13:28:46', 1),
('wgt_html', 'Content', 'YEEDEEN', '', '[{"0":"Html"},{"0":"1.0"},{"0":"MAY 2013"},{"0":"YEEDEEN"},{"0":"info@yeedeen.com"},{"0":"http://yeeditor.com"},{"0":"Copyright (C) 2013"},{"0":"Commercial license; see http://yeedeen.com/license"},{}]', '2013-09-04 13:28:51', '2013-09-04 13:28:51', 1),
('wgt_hello_world', 'Social', 'YEEDEEN', '', '[{"0":"Hello World"},{"0":"1.0"},{"0":"MAY 2013"},{"0":"YEEDEEN"},{"0":"info@yeedeen.com"},{"0":"http://yeeditor.com"},{"0":"Copyright (C) 2013"},{"0":"Commercial license; see http://yeedeen.com/license"},{}]', '2013-09-04 13:29:40', '2013-09-04 13:29:40', 1),
('wgt_separator', 'Content', 'YEEDEEN', '', '[{"0":"Separator"},{"0":"1.0"},{"0":"MAY 2013"},{"0":"YEEDEEN"},{"0":"info@yeedeen.com"},{"0":"http://yeeditor.com"},{"0":"Copyright (C) 2013"},{"0":"Commercial license; see http://yeedeen.com/license"},{}]', '2013-09-04 13:30:21', '2013-09-04 13:30:21', 1),
('wgt_additional_js', 'Social', 'YEEDEEN', '', '[{"0":"Additional JS"},{"0":"1.0"},{"0":"MAY 2013"},{"0":"YEEDEEN"},{"0":"info@yeedeen.com"},{"0":"http://yeeditor.com"},{"0":"Copyright (C) 2013"},{"0":"Commercial license; see http://yeedeen.com/license"},{}]', '2013-10-18 03:28:18', '2013-10-18 03:28:18', 1),
('wgt_additional_css', 'Social', 'YEEDEEN', '', '[{"0":"Additional CSS"},{"0":"1.0"},{"0":"MAY 2013"},{"0":"YEEDEEN"},{"0":"info@yeedeen.com"},{"0":"http://yeeditor.com"},{"0":"Copyright (C) 2013"},{"0":"Commercial license; see http://yeedeen.com/license"},{}]', '2013-10-18 03:28:22', '2013-10-18 03:28:22', 1);
