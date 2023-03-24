-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: local-rds-1.ckgexjkuhhne.us-west-2.rds.amazonaws.com
-- Generation Time: Mar 23, 2023 at 10:11 PM
-- Server version: 5.7.38-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `w0488_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `ActivityLog`
--

CREATE TABLE `ActivityLog` (
  `activity_id` int(11) NOT NULL,
  `activity_title` varchar(255) NOT NULL,
  `activity_description` varchar(255) NOT NULL,
  `activity_historyID` varchar(255) NOT NULL COMMENT '0 - Schedules\r\n1 - Facilities\r\n2 - requests\r\n3 - roles\r\n4 - timesheets\r\n5 - users',
  `activity_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `facility_id` int(11) NOT NULL,
  `facility_photo` varchar(255) NOT NULL,
  `facility_name` varchar(255) NOT NULL,
  `facility_location` varchar(255) NOT NULL,
  `facility_long` float NOT NULL,
  `facility_lat` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`facility_id`, `facility_photo`, `facility_name`, `facility_location`, `facility_long`, `facility_lat`) VALUES
(42, 'w4angels-2023-03-03_20-45-01.jpg', '4angels', 'Keppel Center, Cardinal Rosales Ave, Cebu Business Park, Cebu City, 6000, Philippines', 123.908, 10.3186),
(44, '', 'Ayala Center Cebu', 'Ayala Center Cebu, Archbishop Reyes Ave, Cebu Business Park, Cebu City, 6000, Philippines', 123.905, 10.318);

-- --------------------------------------------------------

--
-- Table structure for table `facilities_permission`
--

CREATE TABLE `facilities_permission` (
  `facilities_permission_id` int(11) NOT NULL,
  `facilities_permission_userid` int(11) NOT NULL,
  `facilities_permission_facilityid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facilities_permission`
--

INSERT INTO `facilities_permission` (`facilities_permission_id`, `facilities_permission_userid`, `facilities_permission_facilityid`) VALUES
(42, 10000000, 42),
(44, 10000000, 44),
(55, 10000022, 44),
(56, 10000022, 42);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `notification_title` varchar(255) NOT NULL,
  `notification_description` varchar(255) NOT NULL,
  `notification_to_user_id` int(11) NOT NULL,
  `notification_created_at` datetime NOT NULL,
  `notification_isRead` tinyint(4) NOT NULL COMMENT '0(Read), 1(Unread)',
  `notification_status` tinyint(4) NOT NULL,
  `notification_sender` int(11) NOT NULL,
  `notification_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification_title`, `notification_description`, `notification_to_user_id`, `notification_created_at`, `notification_isRead`, `notification_status`, `notification_sender`, `notification_link`) VALUES
(5, 'Missing Clockin', 'User Smith schedule started and missing clock in', 10000000, '2023-03-14 15:19:17', 0, 0, 0, '/dashboard'),
(6, 'Missing Clockin', 'User Smith schedule started and missing clock in', 10000022, '2023-03-14 15:19:17', 1, 0, 0, '/dashboard'),
(7, 'Missing Clockin', 'User Smith schedule started and missing clock in', 10000000, '2023-03-16 14:05:10', 0, 0, 0, '/dashboard'),
(8, 'Missing Clockin', 'User Smith schedule started and missing clock in', 10000022, '2023-03-16 14:05:10', 1, 0, 0, '/dashboard'),
(9, 'Missing Clockin', 'User Smith schedule started and missing clock in', 10000000, '2023-03-17 15:00:02', 0, 0, 0, '/dashboard'),
(10, 'Missing Clockin', 'User Smith schedule started and missing clock in', 10000022, '2023-03-17 15:00:02', 1, 0, 0, '/dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requests_id` int(11) NOT NULL,
  `requests_type` tinyint(4) NOT NULL,
  `requests_employeeid` int(11) NOT NULL,
  `requests_schedulesid` int(11) NOT NULL,
  `requests_reassign_employeeid` int(11) DEFAULT NULL,
  `requests_resched_date` date DEFAULT NULL,
  `requests_resched_timestart` time DEFAULT NULL,
  `requests_resched_timeend` time DEFAULT NULL,
  `requests_reason` varchar(300) DEFAULT NULL,
  `requests_approvedby` int(11) DEFAULT NULL,
  `requests_status` tinyint(4) DEFAULT '0',
  `requests_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `requests_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `requests_assignedschedulesid` int(11) DEFAULT NULL,
  `requests_new_schedulesid` varchar(25) DEFAULT NULL,
  `requests_isseen` int(2) NOT NULL,
  `requests_isread` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `role_color`) VALUES
(1, 'CNA', '#ff0000'),
(2, 'RNA', '#804000'),
(3, 'NON-COVID', '#008000'),
(4, '123asd', '#804040');

-- --------------------------------------------------------

--
-- Table structure for table `role_professions`
--

CREATE TABLE `role_professions` (
  `prof_id` int(11) NOT NULL,
  `prof_user_id` int(11) NOT NULL,
  `prof_role_id` int(11) NOT NULL,
  `prof_facility_id` int(11) NOT NULL,
  `prof_wage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_professions`
--

INSERT INTO `role_professions` (`prof_id`, `prof_user_id`, `prof_role_id`, `prof_facility_id`, `prof_wage`) VALUES
(19, 10000038, 2, 44, 24),
(20, 10000038, 2, 42, 23),
(21, 10000038, 3, 44, 12),
(22, 10000038, 1, 42, 2),
(23, 10000039, 2, 42, 12),
(24, 10000039, 2, 42, 2);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` varchar(30) NOT NULL,
  `schedule_type` tinyint(4) NOT NULL COMMENT '0(default) 1(open schedule)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `schedule_type`) VALUES
('1', 0),
('adwax', 0),
('v8-1grlio02p-0', 0),
('v8-1grm2cavf-0', 0),
('v8-1grm687eo-0', 0),
('v8-1grnuq2lf-0', 0),
('v8-1grnuq2lf-1', 0),
('v8-1grnuq2lf-2', 0),
('v8-1gro0nvug-0', 0),
('v8-1grvm4vam-0', 0),
('v8-1grvm8gft-0', 0),
('v8-1grvq8lv3-0', 1),
('v8-1gs31ohvd-0', 0),
('v8-1gs4s72sa-0', 1),
('vg-100021', 1),
('vg-100021230-0', 1),
('vg-100022', 0),
('vg-100023', 0),
('vg-100024', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_assigns`
--

CREATE TABLE `schedule_assigns` (
  `schedule_assigns_id` int(11) NOT NULL,
  `schedule_assigns_schedules_id` varchar(30) NOT NULL,
  `schedule_assigns_user_id` int(11) NOT NULL,
  `schedule_assign_tracker` int(11) NOT NULL DEFAULT '0',
  `schedule_assign_isComplete` int(11) NOT NULL DEFAULT '0',
  `schedule_assign_isRecordTimesheet` int(11) NOT NULL DEFAULT '0',
  `schedule_assign_wage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_assigns`
--

INSERT INTO `schedule_assigns` (`schedule_assigns_id`, `schedule_assigns_schedules_id`, `schedule_assigns_user_id`, `schedule_assign_tracker`, `schedule_assign_isComplete`, `schedule_assign_isRecordTimesheet`, `schedule_assign_wage`) VALUES
(2, '1', 10000038, 1, 1, 1, 23),
(3, 'adwax', 10000038, 0, 0, 0, 23),
(11, 'v8-1grm2cavf-0', 10000038, 0, 0, 0, 2),
(12, 'v8-1grm687eo-0', 10000038, 1, 1, 1, 23),
(13, 'v8-1grvm4vam-0', 10000038, 0, 1, 1, 23),
(14, 'v8-1grvm4vam-0', 10000039, 0, 0, 0, 12),
(15, 'v8-1grvm8gft-0', 10000038, 0, 0, 0, 2),
(16, 'v8-1gs31ohvd-0', 10000038, 0, 0, 0, 2),
(18, 'v8-1grvq8lv3-0', 10000038, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_clock_break`
--

CREATE TABLE `schedule_clock_break` (
  `clock_event_breakstart` time NOT NULL,
  `clock_event_breakend` time NOT NULL,
  `clock_event_breaklength` varchar(255) NOT NULL,
  `clock_event_break_id` int(11) NOT NULL,
  `clock_event_break_clockid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_clock_event`
--

CREATE TABLE `schedule_clock_event` (
  `clock_event_id` int(11) NOT NULL,
  `clock_event_user_id` int(11) NOT NULL,
  `clock_event_isclockin` tinyint(4) DEFAULT NULL,
  `clock_event_intime` datetime DEFAULT NULL,
  `clock_event_inlocation` varchar(255) DEFAULT NULL,
  `clock_event_inlong` float DEFAULT NULL,
  `clock_event_inlat` float DEFAULT NULL,
  `clock_event_isclockout` tinyint(4) DEFAULT NULL,
  `clock_event_outtime` datetime DEFAULT NULL,
  `clock_event_outlocation` varchar(255) DEFAULT NULL,
  `clock_event_outlong` float DEFAULT NULL,
  `clock_event_outlat` float DEFAULT NULL,
  `clock_event_schedule_assigns_id` varchar(30) NOT NULL,
  `clock_event_totalreghour` float DEFAULT NULL,
  `clock_event_totalwage` float DEFAULT NULL,
  `clock_event_status` int(11) DEFAULT NULL COMMENT '1 - ongoing sa mobile\r\n0 - completed',
  `clock_event_totalacthour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_clock_event`
--

INSERT INTO `schedule_clock_event` (`clock_event_id`, `clock_event_user_id`, `clock_event_isclockin`, `clock_event_intime`, `clock_event_inlocation`, `clock_event_inlong`, `clock_event_inlat`, `clock_event_isclockout`, `clock_event_outtime`, `clock_event_outlocation`, `clock_event_outlong`, `clock_event_outlat`, `clock_event_schedule_assigns_id`, `clock_event_totalreghour`, `clock_event_totalwage`, `clock_event_status`, `clock_event_totalacthour`) VALUES
(8, 10000038, 1, '2023-03-17 13:49:00', '', 0, 0, 1, '2023-03-17 23:49:35', '', 0, 0, '1', 0, 0, 0, 10),
(9, 10000038, 0, '0000-00-00 00:00:00', '', 0, 0, 0, '0000-00-00 00:00:00', '', 0, 0, 'adwax', 0, 0, 0, 0),
(16, 10000038, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'v8-1grm2cavf-0', NULL, NULL, NULL, 0),
(17, 10000038, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'v8-1grm687eo-0', 0, 0, NULL, 0),
(18, 10000038, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'v8-1grvm4vam-0', NULL, NULL, NULL, 0),
(19, 10000039, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'v8-1grvm4vam-0', NULL, NULL, NULL, 0),
(20, 10000038, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'v8-1grvm8gft-0', NULL, NULL, NULL, 0),
(21, 10000038, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'v8-1gs31ohvd-0', NULL, NULL, NULL, 0),
(29, 10000038, 1, '2023-03-21 06:16:09', 'Svenson Cebu, 7F Keppel Center, Cebu City, 6000, Philippines', 123.908, 10.3186, 1, '2023-03-21 06:17:11', 'Svenson Cebu, 7F Keppel Center, Cebu City, 6000, Philippines', 123.908, 10.3186, 'v8-1gs4s72sa-0', NULL, NULL, 0, 0),
(32, 10000038, 1, '2023-03-22 11:36:30', 'Metrobank Cebu Business Park, Ayala Access Road, Cebu City, 6000, Philippines', 123.908, 10.3186, 1, '2023-03-22 11:36:40', 'Metrobank Cebu Business Park, Ayala Access Road, Cebu City, 6000, Philippines', 123.908, 10.3186, 'v8-1grvq8lv3-0', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_details`
--

CREATE TABLE `schedule_details` (
  `schedule_detail_id` int(11) NOT NULL,
  `schedule_detail_description` varchar(255) DEFAULT NULL,
  `schedule_detail_facilit_id` int(11) NOT NULL,
  `schedule_detail_role_id` int(11) NOT NULL,
  `schedule_detail_start_time` time NOT NULL,
  `schedule_detail_end_time` time NOT NULL,
  `schedule_detail_hours` float NOT NULL,
  `schedule_detail_date` date NOT NULL,
  `schedule_detail_created_by` int(11) DEFAULT NULL COMMENT 'created by must save a value of userid',
  `schedule_detail_schedule_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_details`
--

INSERT INTO `schedule_details` (`schedule_detail_id`, `schedule_detail_description`, `schedule_detail_facilit_id`, `schedule_detail_role_id`, `schedule_detail_start_time`, `schedule_detail_end_time`, `schedule_detail_hours`, `schedule_detail_date`, `schedule_detail_created_by`, `schedule_detail_schedule_id`) VALUES
(1, 'Mang Limpyo ka ani orasa', 42, 2, '13:29:00', '23:12:04', 9.717, '2023-03-17', 10000000, '1'),
(3, 'manglaba', 42, 2, '20:20:36', '23:20:36', 3, '2023-03-17', 10000000, 'adwax'),
(5, NULL, 42, 2, '20:00:00', '21:00:00', 1, '2023-03-20', 2023, 'vg-100021230-0'),
(14, NULL, 42, 1, '20:00:00', '01:00:00', 5, '2023-03-18', NULL, 'v8-1grm2cavf-0'),
(15, NULL, 42, 2, '15:00:00', '01:00:00', 0, '2023-03-17', NULL, 'v8-1grm687eo-0'),
(19, NULL, 44, 2, '02:00:00', '05:00:00', 1, '2023-03-20', NULL, 'v8-1grnuq2lf-0'),
(20, 'asdasd', 42, 1, '02:00:00', '05:00:00', 15, '2023-03-22', NULL, 'v8-1grnuq2lf-1'),
(21, NULL, 42, 4, '02:00:00', '05:00:00', 1, '2023-03-24', NULL, 'v8-1grnuq2lf-2'),
(22, '', 42, 1, '02:00:00', '05:00:00', -466778, '2023-04-02', NULL, 'v8-1gro0nvug-0'),
(23, NULL, 42, 2, '23:00:00', '23:30:00', 0.5, '2023-03-20', NULL, 'v8-1grvm4vam-0'),
(24, NULL, 42, 1, '23:00:00', '12:00:00', 13, '2023-03-21', NULL, 'v8-1grvm8gft-0'),
(25, '', 42, 1, '23:50:00', '00:00:00', 0.166667, '2023-03-23', NULL, 'v8-1grvq8lv3-0'),
(26, 'aw', 42, 1, '21:09:00', '09:09:00', 12, '2023-03-25', NULL, 'v8-1gs31ohvd-0'),
(27, '', 42, 1, '23:00:00', '00:00:00', 1, '2023-03-22', NULL, 'v8-1gs4s72sa-0');

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `timesheet_id` int(11) NOT NULL,
  `timesheet_detail_id` int(11) NOT NULL,
  `timesheet_facility_id` int(11) NOT NULL,
  `timesheet_time_card` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `timesheet_details`
--

CREATE TABLE `timesheet_details` (
  `timesheet_detail_id` int(11) NOT NULL,
  `timesheet_detail_date` int(11) NOT NULL,
  `timesheet_detail_user_id` int(11) NOT NULL,
  `timesheet_detail_clock_event_id` int(11) NOT NULL,
  `timesheet_detail_actual_hour` int(11) NOT NULL,
  `timesheet_detail_schedule_id` varchar(30) NOT NULL,
  `timesheet_detail_unpaid_break` int(11) NOT NULL,
  `timesheet_detail_has_issue` int(11) NOT NULL,
  `timesheet_detail_overtime` int(11) NOT NULL,
  `timesheet_detail_regular_hours` int(11) NOT NULL,
  `timesheet_detail_paid_hours` int(11) NOT NULL,
  `timesheet_detail_total_est_wage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_photo` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_status` tinyint(4) NOT NULL COMMENT '(1) Active, (0) Not-Active',
  `user_comment` varchar(255) DEFAULT NULL,
  `user_datehired` date NOT NULL,
  `user_access_level_id` int(11) NOT NULL,
  `user_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_photo`, `user_firstname`, `user_lastname`, `user_phone`, `user_birthday`, `user_email`, `user_password`, `user_status`, `user_comment`, `user_datehired`, `user_access_level_id`, `user_created_at`) VALUES
(10000000, 'w4angels-2023-03-13_20-41-44.jpeg', 'pro', 'weaver', '09614739205', '2023-03-04', 'proweaveradmin@gmail.com', '$2a$12$d0/O0tD8LcVTpm0Wwq87nuJUJawEqP1ufENrlmTa7Vhjukm5yPJpu', 1, NULL, '0000-00-00', 1, '2023-03-03 00:25:50'),
(10000022, 'w4angels-2023-03-07_14-09-16.png', 'proweaver', 'supervisor', '1234567890', '2023-03-23', 'proweaversupervisor@gmail.com', '$2a$12$dNihdw2/w.j3Ez3Qqci5Mec2ig2iJT7FUJZbWFtUcY2f6ukHeyICK', 1, NULL, '2023-03-08', 2, '2023-03-06 22:44:04'),
(10000038, 'w4angels-2023-03-15_21-31-08.jpeg', 'John', 'Smith', '123123123', '2023-03-08', 'John099@gmail.com', '$2a$12$qia/sSkoqOIM1n16MJvolO8Afeyig/qFBTBqrwCkC7DftOIxDZbpO', 1, NULL, '2023-03-09', 0, '0000-00-00 00:00:00'),
(10000039, 'w4angels-2023-03-17_21-38-04.jpg', 'Rose', 'Doe', '1234567890', '2023-03-30', 'rose23@gmail.com', '$2y$10$exxNGk7CDnzQwjL7Y.brC.NTsTF2Ha9f9SPtiSM2QbaZf8Fp1CuJe', 1, NULL, '2023-03-09', 0, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ActivityLog`
--
ALTER TABLE `ActivityLog`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `facilities_permission`
--
ALTER TABLE `facilities_permission`
  ADD PRIMARY KEY (`facilities_permission_id`),
  ADD KEY `facilities_permission_userid` (`facilities_permission_userid`),
  ADD KEY `facilities_permission_facilityid` (`facilities_permission_facilityid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notification_to_user_id` (`notification_to_user_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requests_id`),
  ADD KEY `employee_id` (`requests_employeeid`),
  ADD KEY `requests_reassign_employeeid` (`requests_reassign_employeeid`),
  ADD KEY `requests_schedulesid` (`requests_schedulesid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_professions`
--
ALTER TABLE `role_professions`
  ADD PRIMARY KEY (`prof_id`),
  ADD KEY `prof_user_id` (`prof_user_id`),
  ADD KEY `prof_role_id` (`prof_role_id`),
  ADD KEY `prof_facility_id` (`prof_facility_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `schedule_assigns`
--
ALTER TABLE `schedule_assigns`
  ADD PRIMARY KEY (`schedule_assigns_id`),
  ADD KEY `schedule_assigns_schedules_id` (`schedule_assigns_schedules_id`),
  ADD KEY `schedule_assigns_user_id` (`schedule_assigns_user_id`);

--
-- Indexes for table `schedule_clock_break`
--
ALTER TABLE `schedule_clock_break`
  ADD PRIMARY KEY (`clock_event_break_id`);

--
-- Indexes for table `schedule_clock_event`
--
ALTER TABLE `schedule_clock_event`
  ADD PRIMARY KEY (`clock_event_id`),
  ADD KEY `clock_event_user_id` (`clock_event_user_id`),
  ADD KEY `schedule_clock_event_ibfk_2` (`clock_event_schedule_assigns_id`);

--
-- Indexes for table `schedule_details`
--
ALTER TABLE `schedule_details`
  ADD PRIMARY KEY (`schedule_detail_id`),
  ADD KEY `schedule_detail_facilit_id` (`schedule_detail_facilit_id`),
  ADD KEY `schedule_detail_role_id` (`schedule_detail_role_id`),
  ADD KEY `schedule_detail_schedule_id` (`schedule_detail_schedule_id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD KEY `timesheet_detail_id` (`timesheet_detail_id`),
  ADD KEY `timesheet_facility_id` (`timesheet_facility_id`);

--
-- Indexes for table `timesheet_details`
--
ALTER TABLE `timesheet_details`
  ADD PRIMARY KEY (`timesheet_detail_id`),
  ADD KEY `timesheet_detail_user_id` (`timesheet_detail_user_id`),
  ADD KEY `timesheet_detail_clock_event_id` (`timesheet_detail_clock_event_id`),
  ADD KEY `timesheet_detail_schedule_id` (`timesheet_detail_schedule_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ActivityLog`
--
ALTER TABLE `ActivityLog`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `facilities_permission`
--
ALTER TABLE `facilities_permission`
  MODIFY `facilities_permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requests_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_professions`
--
ALTER TABLE `role_professions`
  MODIFY `prof_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `schedule_assigns`
--
ALTER TABLE `schedule_assigns`
  MODIFY `schedule_assigns_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `schedule_clock_break`
--
ALTER TABLE `schedule_clock_break`
  MODIFY `clock_event_break_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_clock_event`
--
ALTER TABLE `schedule_clock_event`
  MODIFY `clock_event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `schedule_details`
--
ALTER TABLE `schedule_details`
  MODIFY `schedule_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `timesheet_details`
--
ALTER TABLE `timesheet_details`
  MODIFY `timesheet_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000040;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facilities_permission`
--
ALTER TABLE `facilities_permission`
  ADD CONSTRAINT `facilities_permission_ibfk_1` FOREIGN KEY (`facilities_permission_userid`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `facilities_permission_ibfk_2` FOREIGN KEY (`facilities_permission_facilityid`) REFERENCES `facilities` (`facility_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`notification_to_user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`requests_employeeid`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`requests_reassign_employeeid`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`requests_schedulesid`) REFERENCES `schedule_assigns` (`schedule_assigns_id`);

--
-- Constraints for table `role_professions`
--
ALTER TABLE `role_professions`
  ADD CONSTRAINT `role_professions_ibfk_1` FOREIGN KEY (`prof_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `role_professions_ibfk_2` FOREIGN KEY (`prof_role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `role_professions_ibfk_3` FOREIGN KEY (`prof_facility_id`) REFERENCES `facilities` (`facility_id`);

--
-- Constraints for table `schedule_assigns`
--
ALTER TABLE `schedule_assigns`
  ADD CONSTRAINT `schedule_assigns_ibfk_3` FOREIGN KEY (`schedule_assigns_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `schedule_assigns_ibfk_4` FOREIGN KEY (`schedule_assigns_schedules_id`) REFERENCES `schedules` (`schedule_id`);

--
-- Constraints for table `schedule_clock_event`
--
ALTER TABLE `schedule_clock_event`
  ADD CONSTRAINT `schedule_clock_event_ibfk_1` FOREIGN KEY (`clock_event_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `schedule_clock_event_ibfk_2` FOREIGN KEY (`clock_event_schedule_assigns_id`) REFERENCES `schedules` (`schedule_id`);

--
-- Constraints for table `schedule_details`
--
ALTER TABLE `schedule_details`
  ADD CONSTRAINT `schedule_details_ibfk_1` FOREIGN KEY (`schedule_detail_facilit_id`) REFERENCES `facilities` (`facility_id`),
  ADD CONSTRAINT `schedule_details_ibfk_2` FOREIGN KEY (`schedule_detail_role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `schedule_details_ibfk_3` FOREIGN KEY (`schedule_detail_schedule_id`) REFERENCES `schedules` (`schedule_id`);

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `timesheets_ibfk_1` FOREIGN KEY (`timesheet_detail_id`) REFERENCES `timesheet_details` (`timesheet_detail_id`),
  ADD CONSTRAINT `timesheets_ibfk_2` FOREIGN KEY (`timesheet_facility_id`) REFERENCES `facilities` (`facility_id`);

--
-- Constraints for table `timesheet_details`
--
ALTER TABLE `timesheet_details`
  ADD CONSTRAINT `timesheet_details_ibfk_1` FOREIGN KEY (`timesheet_detail_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `timesheet_details_ibfk_2` FOREIGN KEY (`timesheet_detail_clock_event_id`) REFERENCES `schedule_clock_event` (`clock_event_id`),
  ADD CONSTRAINT `timesheet_details_ibfk_3` FOREIGN KEY (`timesheet_detail_schedule_id`) REFERENCES `schedules` (`schedule_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
