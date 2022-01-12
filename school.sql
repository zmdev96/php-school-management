-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2020 at 01:05 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_classes`
--

CREATE TABLE `app_classes` (
  `class_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(36) NOT NULL,
  `division` varchar(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_classes`
--

INSERT INTO `app_classes` (`class_id`, `name`, `division`) VALUES
(2, 'class two', '1');

-- --------------------------------------------------------

--
-- Table structure for table `app_classes_material`
--

CREATE TABLE `app_classes_material` (
  `id` int(11) UNSIGNED NOT NULL,
  `class_id` int(11) UNSIGNED NOT NULL,
  `material_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_classes_material`
--

INSERT INTO `app_classes_material` (`id`, `class_id`, `material_id`, `user_id`) VALUES
(3, 2, 3, 8),
(4, 2, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `app_material`
--

CREATE TABLE `app_material` (
  `material_id` int(11) UNSIGNED NOT NULL,
  `material` varchar(36) NOT NULL,
  `about` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_material`
--

INSERT INTO `app_material` (`material_id`, `material`, `about`) VALUES
(1, 'English Language', 'this is the first material'),
(3, 'Arabic Language', ''),
(4, 'Mathmatic', ''),
(5, 'computer science', ''),
(6, 'Sport', ''),
(7, 'History', '');

-- --------------------------------------------------------

--
-- Table structure for table `app_students`
--

CREATE TABLE `app_students` (
  `student_id` int(11) UNSIGNED NOT NULL,
  `national_id` int(20) UNSIGNED NOT NULL,
  `first_name` varchar(24) NOT NULL,
  `last_name` varchar(24) NOT NULL,
  `email` varchar(60) NOT NULL,
  `class_id` int(11) UNSIGNED NOT NULL,
  `has_users` int(11) UNSIGNED DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `logout_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_students`
--

INSERT INTO `app_students` (`student_id`, `national_id`, `first_name`, `last_name`, `email`, `class_id`, `has_users`, `created_at`, `updated_at`, `logout_at`) VALUES
(1, 4294967295, 'ali', 'zeyad', 'aliahmad@gmail.com', 2, 3, '2020-04-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_students_profiles`
--

CREATE TABLE `app_students_profiles` (
  `student_id` int(11) UNSIGNED NOT NULL,
  `address` varchar(50) NOT NULL,
  `pob` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `nationalty` varchar(24) NOT NULL,
  `responsble` enum('mother','father','teacher') NOT NULL,
  `responsible_phone` int(15) NOT NULL,
  `responsible_job` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_students_profiles`
--

INSERT INTO `app_students_profiles` (`student_id`, `address`, `pob`, `dob`, `gender`, `nationalty`, `responsble`, `responsible_phone`, `responsible_job`) VALUES
(1, 'hussstr.13', '2020-04-14', '2020-04-16', 'male', 'gggg', '', 123456789, 'web ');

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `group_id` tinyint(3) UNSIGNED NOT NULL,
  `status` enum('active','pending','disabled','') NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`user_id`, `username`, `email`, `password`, `first_name`, `last_name`, `group_id`, `status`, `created_at`, `updated_at`, `last_login`) VALUES
(3, 'moslem', 'moslem@gmail.com', '$2a$07$yeNCSNwRpYopOhv0TrrReOTF7T/DenCJpSDRToDBOX7ZBEqfd.CVe', 'Zeyad', 'Moslem', 1, 'active', '2020-03-03', NULL, NULL),
(5, 'hadeel123', 'almadihaeel@gmail.com', '$2a$07$yeNCSNwRpYopOhv0TrrReOTF7T/DenCJpSDRToDBOX7ZBEqfd.CVe', 'hadeel', 'Almadi', 3, 'active', '2020-03-06', NULL, NULL),
(6, 'zeyad_teacher', 'z_teacher@gmail.com', '$2a$07$yeNCSNwRpYopOhv0TrrReOTF7T/DenCJpSDRToDBOX7ZBEqfd.CVe', 'zeyad', 'teacher', 5, 'active', '2020-03-17', NULL, NULL),
(8, 'hadeel_teacher', 'hadeelhamad@gmail.com', '$2a$07$yeNCSNwRpYopOhv0TrrReO.EVbKiK/d8vzsPTNWgCX2yIvApKjaaa', 'hadeel', 'teacher', 5, 'active', '2020-03-17', '2020-03-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_users_groups`
--

CREATE TABLE `app_users_groups` (
  `group_id` tinyint(3) UNSIGNED NOT NULL,
  `group_title_en` varchar(100) NOT NULL,
  `group_title_ar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users_groups`
--

INSERT INTO `app_users_groups` (`group_id`, `group_title_en`, `group_title_ar`) VALUES
(1, 'administrator', 'مدير'),
(3, 'Editor ', 'محررين'),
(5, 'Teachers', 'المعلمين');

-- --------------------------------------------------------

--
-- Table structure for table `app_users_groups_privileges`
--

CREATE TABLE `app_users_groups_privileges` (
  `id` int(11) UNSIGNED NOT NULL,
  `privilege_id` tinyint(3) UNSIGNED NOT NULL,
  `group_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users_groups_privileges`
--

INSERT INTO `app_users_groups_privileges` (`id`, `privilege_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 3, 1),
(5, 5, 1),
(6, 6, 1),
(8, 7, 1),
(9, 8, 1),
(10, 9, 1),
(11, 10, 1),
(12, 11, 1),
(13, 12, 1),
(14, 13, 1),
(15, 14, 1),
(16, 15, 1),
(17, 16, 1),
(18, 17, 1),
(19, 18, 1),
(20, 19, 1),
(21, 20, 1),
(22, 21, 1),
(23, 22, 1),
(24, 23, 1),
(25, 24, 1),
(26, 25, 1),
(27, 26, 1),
(28, 27, 1),
(29, 28, 1),
(30, 29, 1),
(31, 30, 1),
(32, 31, 1),
(33, 32, 1),
(34, 33, 1),
(35, 34, 1),
(36, 19, 3),
(37, 20, 3),
(38, 21, 3),
(39, 22, 3),
(40, 23, 3),
(41, 24, 3),
(42, 25, 3),
(43, 26, 3),
(44, 27, 3),
(45, 28, 3),
(46, 29, 3),
(47, 30, 3),
(48, 33, 3),
(49, 34, 3);

-- --------------------------------------------------------

--
-- Table structure for table `app_users_privileges`
--

CREATE TABLE `app_users_privileges` (
  `privilege_id` tinyint(3) UNSIGNED NOT NULL,
  `privilege_path` varchar(100) NOT NULL,
  `privilege_title_en` varchar(100) NOT NULL,
  `privilege_title_ar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users_privileges`
--

INSERT INTO `app_users_privileges` (`privilege_id`, `privilege_path`, `privilege_title_en`, `privilege_title_ar`) VALUES
(1, 'users.php', 'Users Index', 'تصفح المستخدمين'),
(3, 'users.php?action=create', 'Create New Users', 'انشاء مستخدم جديد'),
(4, 'users.php?action=edit', 'Users Edit', 'تعديل المستخدمين'),
(5, 'users.php?action=delete', 'Users Delete', 'حذف المستخدمين'),
(6, 'users.php?action=insert', 'Insert New User', 'اظافة مستخدم جديد'),
(7, 'users_groups.php', 'Users Groups Index', 'تصفح  مجموعات المستخدمين'),
(8, 'users_groups.php?action=create', 'Create New Users Group', 'انشاء مجموعة مستخدمين جديدة'),
(9, 'users_groups.php?action=insert', 'Insert New User Groups', ' اظافة مجموعة مستخدمين جديدة'),
(10, 'users_groups.php?action=edit', 'Edit Users Groups', 'تعديل مجموعة المستخدمين'),
(11, 'users_groups.php?action=update', 'Udpate Users Groups', 'تحديث مجموعات المستخدمين'),
(12, 'users_groups.php?action=delete', 'Delete Users Groups', 'حذف مجموعات المستخدمين'),
(13, 'privileges.php', 'Users Privileges Index', 'تصفح صلاحيات المستخدمين'),
(14, 'privileges.php?action=create', 'Create New Privileges', 'انشاء صلاحية جديدة'),
(15, 'privileges.php?action=insert', 'Insert  New Privileges', 'اضافة صلاحية جديدة'),
(16, 'privileges.php?action=edit', 'Edit Users Privielges', 'تعديل صلاحيات المستخدمين'),
(17, 'privileges.php?action=update', 'Update Users Privileges', 'تحديث صلاحيات المستحدمين'),
(18, 'privileges.php?action=delete', 'Delete Users Privileges', 'حذف صلاحيات المستخدمين'),
(19, 'classes.php', 'Classes Index', 'تصفح الصفوف'),
(20, 'classes.php?action=create', 'Create Classes', 'انشاء صفوف'),
(21, 'classes.php?action=insert', 'Insert Classes', 'اضافة صفوف'),
(22, 'classes.php?action=edit', 'Edit  Calsses', 'تعديل الصفوف'),
(23, 'classes.php?action=update', 'Update Classes', 'تحديث الصفوف'),
(24, 'classes.php?action=delete', 'Delete Classes', 'حذف الصفوف'),
(25, 'material.php', 'Material Index', 'تصفح المواد'),
(26, 'material.php?action=create', 'Material Create', 'انشاء المواد'),
(27, 'material.php?action=insert', 'Material Insert', 'اضافة المواد'),
(28, 'material.php?action=edit', 'Edit Material', 'تعديل المواد'),
(29, 'material.php?action=update', 'Update Material', 'تحديث المواد'),
(30, 'material.php?action=delete', 'Delete Material', 'حذف المواد'),
(31, 'users.php?action=update', 'Update Users', 'تحديث المستخدمين'),
(32, 'users.php?action=show', 'show profile of users', 'عرض سجل المستخدم'),
(33, 'students_reg.php', 'Students Registration Create', 'انشاء طالب جديد'),
(34, 'students_reg.php?action=insert', 'Students Registration Insert', 'اظافة طالب جديد');

-- --------------------------------------------------------

--
-- Table structure for table `app_users_profiles`
--

CREATE TABLE `app_users_profiles` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `specialty` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `address` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `about` varchar(255) NOT NULL,
  `image` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users_profiles`
--

INSERT INTO `app_users_profiles` (`user_id`, `specialty`, `city`, `address`, `phone`, `dob`, `about`, `image`) VALUES
(3, 'web ', 'gera ', 'hussstr.13', '0123456789', '2020-03-03', 'this is new user  ', NULL),
(5, 'computer science', 'Arbid', 'Arbid/kyremah', '0795467832', '2020-03-11', 'this new user', NULL),
(6, 'History', 'gera', 'gera', '012345678', '2020-03-24', 'this is teacher one', NULL),
(8, 'computer science', 'Arbid', 'Arbid/kyremah', '98765437889', '2020-03-15', 'this is  tow teacher', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_classes`
--
ALTER TABLE `app_classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `app_classes_material`
--
ALTER TABLE `app_classes_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class` (`class_id`),
  ADD KEY `material` (`material_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `app_material`
--
ALTER TABLE `app_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `app_students`
--
ALTER TABLE `app_students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `national_id` (`national_id`),
  ADD KEY `users_id` (`has_users`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `app_students_profiles`
--
ALTER TABLE `app_students_profiles`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_group` (`group_id`);

--
-- Indexes for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `app_users_groups_privileges`
--
ALTER TABLE `app_users_groups_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `privilege` (`privilege_id`),
  ADD KEY `group` (`group_id`);

--
-- Indexes for table `app_users_privileges`
--
ALTER TABLE `app_users_privileges`
  ADD PRIMARY KEY (`privilege_id`);

--
-- Indexes for table `app_users_profiles`
--
ALTER TABLE `app_users_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_classes`
--
ALTER TABLE `app_classes`
  MODIFY `class_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_classes_material`
--
ALTER TABLE `app_classes_material`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `app_material`
--
ALTER TABLE `app_material`
  MODIFY `material_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `app_students`
--
ALTER TABLE `app_students`
  MODIFY `student_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_students_profiles`
--
ALTER TABLE `app_students_profiles`
  MODIFY `student_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `app_users_groups`
--
ALTER TABLE `app_users_groups`
  MODIFY `group_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `app_users_groups_privileges`
--
ALTER TABLE `app_users_groups_privileges`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `app_users_privileges`
--
ALTER TABLE `app_users_privileges`
  MODIFY `privilege_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `app_users_profiles`
--
ALTER TABLE `app_users_profiles`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_classes_material`
--
ALTER TABLE `app_classes_material`
  ADD CONSTRAINT `class` FOREIGN KEY (`class_id`) REFERENCES `app_classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `material` FOREIGN KEY (`material_id`) REFERENCES `app_material` (`material_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_students`
--
ALTER TABLE `app_students`
  ADD CONSTRAINT `class_id` FOREIGN KEY (`class_id`) REFERENCES `app_classes` (`class_id`),
  ADD CONSTRAINT `users_id` FOREIGN KEY (`has_users`) REFERENCES `app_users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `app_students_profiles`
--
ALTER TABLE `app_students_profiles`
  ADD CONSTRAINT `student_profile` FOREIGN KEY (`student_id`) REFERENCES `app_students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_users`
--
ALTER TABLE `app_users`
  ADD CONSTRAINT `user_group` FOREIGN KEY (`group_id`) REFERENCES `app_users_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_users_groups_privileges`
--
ALTER TABLE `app_users_groups_privileges`
  ADD CONSTRAINT `group` FOREIGN KEY (`group_id`) REFERENCES `app_users_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `privilege` FOREIGN KEY (`privilege_id`) REFERENCES `app_users_privileges` (`privilege_id`);

--
-- Constraints for table `app_users_profiles`
--
ALTER TABLE `app_users_profiles`
  ADD CONSTRAINT `users_profile` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
