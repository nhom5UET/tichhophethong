-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2015 at 11:59 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chikitsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `ck_appointments`
--

CREATE TABLE IF NOT EXISTS `ck_appointments` (
  `appointment_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `title` varchar(150) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `visit_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_appointment_log`
--

CREATE TABLE IF NOT EXISTS `ck_appointment_log` (
  `appointment_id` int(11) NOT NULL,
  `change_date_time` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `old_status` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_bill`
--

CREATE TABLE IF NOT EXISTS `ck_bill` (
  `bill_id` int(11) NOT NULL,
  `bill_date` date NOT NULL,
  `patient_id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `due_amount` decimal(11,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_bill`
--

INSERT INTO `ck_bill` (`bill_id`, `bill_date`, `patient_id`, `visit_id`, `total_amount`, `due_amount`) VALUES
(1, '2015-12-01', 1, 0, '0', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `ck_bill_detail`
--

CREATE TABLE IF NOT EXISTS `ck_bill_detail` (
  `bill_detail_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `bill_id` int(11) NOT NULL,
  `particular` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `mrp` decimal(10,2) NOT NULL,
  `type` varchar(25) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_clinic`
--

CREATE TABLE IF NOT EXISTS `ck_clinic` (
  `clinic_id` int(11) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `time_interval` decimal(11,2) NOT NULL DEFAULT '0.50',
  `clinic_name` varchar(50) DEFAULT NULL,
  `tag_line` varchar(100) DEFAULT NULL,
  `clinic_address` varchar(500) DEFAULT NULL,
  `landline` varchar(50) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `facebook` varchar(50) DEFAULT NULL,
  `twitter` varchar(50) DEFAULT NULL,
  `google_plus` varchar(50) DEFAULT NULL,
  `next_followup_days` int(11) NOT NULL DEFAULT '15',
  `clinic_logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_clinic`
--

INSERT INTO `ck_clinic` (`clinic_id`, `start_time`, `end_time`, `time_interval`, `clinic_name`, `tag_line`, `clinic_address`, `landline`, `mobile`, `email`, `facebook`, `twitter`, `google_plus`, `next_followup_days`, `clinic_logo`) VALUES
(1, '09:00', '18:00', '0.50', 'Chikitsa', 'Patient Management Software', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ck_contact`
--

CREATE TABLE IF NOT EXISTS `ck_contact` (
  `contact_id` int(10) unsigned NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middel_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address_line_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ck_contact`
--

INSERT INTO `ck_contact` (`contact_id`, `first_name`, `middel_name`, `last_name`, `phone_number`, `display_name`, `email`, `address_line_1`, `city`, `state`, `postal_code`, `country`, `created_at`, `updated_at`) VALUES
(1, 'dao', 'huy', 'hoang', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ck_contacts`
--

CREATE TABLE IF NOT EXISTS `ck_contacts` (
  `contact_id` int(11) NOT NULL,
  `first_names` varchar(50) DEFAULT NULL,
  `middle_names` varchar(50) DEFAULT NULL,
  `last_names` varchar(50) NOT NULL,
  `display_names` varchar(255) NOT NULL,
  `phone_numbers` varchar(15) NOT NULL,
  `emails` varchar(150) NOT NULL,
  `contact_image` varchar(255) NOT NULL DEFAULT 'images/Profile.png',
  `type` varchar(50) NOT NULL,
  `address_line_1s` varchar(150) NOT NULL,
  `address_line_2` varchar(150) NOT NULL,
  `citys` varchar(50) NOT NULL,
  `states` varchar(50) NOT NULL,
  `postal_codes` varchar(50) NOT NULL,
  `countrys` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address_line_1` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_contacts`
--

INSERT INTO `ck_contacts` (`contact_id`, `first_names`, `middle_names`, `last_names`, `display_names`, `phone_numbers`, `emails`, `contact_image`, `type`, `address_line_1s`, `address_line_2`, `citys`, `states`, `postal_codes`, `countrys`, `created_at`, `updated_at`, `first_name`, `middle_name`, `last_name`, `phone_number`, `display_name`, `email`, `address_line_1`, `city`, `state`, `postal_code`, `country`) VALUES
(1, NULL, NULL, '', '', '', '', 'images/Profile.png', '', '', '', '', '', '', '', '2015-12-02 05:09:04', '2015-12-02 05:09:04', 'Nguyen', 'Trung', 'Thanh', '1818818181', 'thanh', 'thanh@gmail.com', 'dong da', 'ha noi', 'good', '100', 'viet nam');

-- --------------------------------------------------------

--
-- Table structure for table `ck_contactss`
--

CREATE TABLE IF NOT EXISTS `ck_contactss` (
  `contact_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact_image` varchar(255) NOT NULL DEFAULT 'images/Profile.png',
  `type` varchar(50) NOT NULL,
  `address_line_1` varchar(150) NOT NULL,
  `address_line_2` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_contactsss`
--

CREATE TABLE IF NOT EXISTS `ck_contactsss` (
  `contact_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middel_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact_image` varchar(255) NOT NULL DEFAULT 'images/Profile.png',
  `type` varchar(50) NOT NULL,
  `address_line_1` varchar(150) NOT NULL,
  `address_line_2` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_contact_details`
--

CREATE TABLE IF NOT EXISTS `ck_contact_details` (
  `contact_detail_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `detail` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_data`
--

CREATE TABLE IF NOT EXISTS `ck_data` (
  `ck_data_id` int(11) NOT NULL,
  `ck_key` varchar(50) NOT NULL DEFAULT '',
  `ck_value` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_data`
--

INSERT INTO `ck_data` (`ck_data_id`, `ck_key`, `ck_value`) VALUES
(1, 'default_language', 'english'),
(2, 'default_timezone', 'UTC'),
(3, 'default_timeformate', 'h:i A'),
(4, 'default_dateformate', 'd-m-Y');

-- --------------------------------------------------------

--
-- Table structure for table `ck_followup`
--

CREATE TABLE IF NOT EXISTS `ck_followup` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `followup_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_invoice`
--

CREATE TABLE IF NOT EXISTS `ck_invoice` (
  `invoice_id` int(11) NOT NULL,
  `static_prefix` varchar(10) NOT NULL,
  `left_pad` int(11) NOT NULL,
  `next_id` int(11) NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `currency_postfix` char(10) NOT NULL DEFAULT '/-'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_invoice`
--

INSERT INTO `ck_invoice` (`invoice_id`, `static_prefix`, `left_pad`, `next_id`, `currency_symbol`, `currency_postfix`) VALUES
(1, '', 3, 1, 'Rs.', '');

-- --------------------------------------------------------

--
-- Table structure for table `ck_menu_access`
--

CREATE TABLE IF NOT EXISTS `ck_menu_access` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `allow` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_menu_access`
--

INSERT INTO `ck_menu_access` (`id`, `menu_name`, `category_name`, `allow`) VALUES
(1, 'patients', 'Doctor', 1),
(2, 'all_patients', 'Doctor', 1),
(3, 'new_inquiry', 'Doctor', 1),
(4, 'appointments', 'Doctor', 1),
(5, 'reports', 'Doctor', 1),
(6, 'patients', 'Receptionist', 1),
(7, 'all_patients', 'Receptionist', 1),
(8, 'new_inquiry', 'Receptionist', 1),
(9, 'appointments', 'Receptionist', 1),
(10, 'appointment report', 'Doctor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ck_modules`
--

CREATE TABLE IF NOT EXISTS `ck_modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `module_display_name` varchar(50) NOT NULL,
  `module_description` varchar(150) NOT NULL,
  `module_status` int(1) NOT NULL,
  `module_version` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_navigation_menu`
--

CREATE TABLE IF NOT EXISTS `ck_navigation_menu` (
  `id` int(11) NOT NULL,
  `menu_name` varchar(250) DEFAULT NULL,
  `parent_name` varchar(250) NOT NULL,
  `menu_order` int(11) NOT NULL,
  `menu_url` varchar(500) DEFAULT NULL,
  `menu_icon` varchar(100) DEFAULT NULL,
  `menu_text` varchar(200) DEFAULT NULL,
  `required_module` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_navigation_menu`
--

INSERT INTO `ck_navigation_menu` (`id`, `menu_name`, `parent_name`, `menu_order`, `menu_url`, `menu_icon`, `menu_text`, `required_module`) VALUES
(1, 'patients', '', 100, 'patient/index', 'fa-users', 'Patients', ''),
(2, 'all_patients', 'patients', 0, 'patient/index', NULL, 'All Patients', NULL),
(3, 'new_inquiry', 'patients', 200, 'patient/new_inquiry_report', NULL, 'New Inquiries', NULL),
(4, 'appointments', '', 200, 'appointment/index', 'fa-calendar', 'Appointments', ''),
(5, 'reports', '', 400, '#', 'fa-line-chart', 'Reports', ''),
(6, 'administration', '', 500, '#', 'fa-cog', 'Administration', ''),
(7, 'modules', '', 600, 'module/index', 'fa-shopping-cart', 'Modules', ''),
(8, 'appointment report', 'reports', 100, 'appointment/appointment_report', '', 'Appointment Report', ''),
(9, 'bill report', 'reports', 300, 'patient/bill_detail_report', '', 'Bill Detail Report', ''),
(10, 'clinic detail', 'administration', 100, 'settings/clinic', '', 'Clinic Detail', ''),
(11, 'invoice setting', 'administration', 200, 'settings/invoice', '', 'Invoice', ''),
(12, 'users', 'administration', 300, 'admin/users', '', 'Users', ''),
(13, 'setting', 'administration', 500, 'settings/change_settings', '', 'Setting', ''),
(14, 'payment', '', 300, 'payment/index', 'fa-money', 'Payments', ''),
(15, 'backup', 'administration', 600, 'settings/backup', NULL, 'Backup', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ck_patient`
--

CREATE TABLE IF NOT EXISTS `ck_patient` (
  `patient_id` int(11) NOT NULL,
  `contact_ids` int(11) NOT NULL,
  `patient_since` date NOT NULL,
  `display_id` varchar(12) NOT NULL,
  `followup_date` date NOT NULL,
  `reference_by` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `contact_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_patient`
--

INSERT INTO `ck_patient` (`patient_id`, `contact_ids`, `patient_since`, `display_id`, `followup_date`, `reference_by`, `gender`, `dob`, `contact_id`, `created_at`, `updated_at`) VALUES
(1, 0, '0000-00-00', 'T00001', '0000-00-00', '', NULL, NULL, 1, '2015-12-02 05:09:04', '2015-12-02 05:09:04');

-- --------------------------------------------------------

--
-- Table structure for table `ck_payment`
--

CREATE TABLE IF NOT EXISTS `ck_payment` (
  `payment_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_mode` varchar(50) NOT NULL,
  `pay_amount` decimal(10,0) NOT NULL,
  `cheque_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_payment_transaction`
--

CREATE TABLE IF NOT EXISTS `ck_payment_transaction` (
  `transaction_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `payment_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_receipt_template`
--

CREATE TABLE IF NOT EXISTS `ck_receipt_template` (
  `template_id` int(11) NOT NULL,
  `template` text NOT NULL,
  `is_default` int(1) NOT NULL,
  `template_name` varchar(25) NOT NULL,
  `type` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_receipt_template`
--

INSERT INTO `ck_receipt_template` (`template_id`, `template`, `is_default`, `template_name`, `type`) VALUES
(1, '<h1 style="text-align:center;">[clinic_name]</h1><h2 style="text-align:center;">[tag_line]</h2><p style="text-align:center;">[clinic_address]</p><span class="contact">	<p style="text-align: center;">		<b style="line-height: 1.42857143;">Landline : </b><span style="line-height: 1.42857143;">[landline]</span>  		<b style="line-height: 1.42857143;">Mobile : </b><span style="line-height: 1.42857143;">[mobile]</span>  		<b style="line-height: 1.42857143;">Email : </b><span style="text-align: center;"> [email]</span>	</p></span><hr id="null"><h3 style="text-align: center;"><u style="text-align: center;">RECEIPT</u></h3><span style="text-align: left;"><b>Date : </b>[bill_date]</span><span style="float: right;"><b>Receipt Number :</b> [bill_id]</span><p style="text-align: left;"><b style="text-align: left;">Patient Name: </b><span style="text-align: left;">[patient_name]<br></span></p><hr id="null" style="text-align: left;">Received fees for Professional services and other charges of our:<p><br></p><table style="width: 100%;margin-top: 25px;margin-bottom: 25px;border-collapse: collapse;border:1px solid black;">	<thead>		<tr>			<td style="width: 400px;text-align: left;padding:5px;border:1px solid black;">				<b style="width: 400px;text-align: left;">Item</b>			</td>			<td style="padding:5px;border:1px solid black;">				<b>Quantity</b>			</td>			<td style="width: 100px;text-align:right;padding:5px;border:1px solid black;">				<b>M.R.P.</b>			</td>			<td style="width: 100px;text-align:right;padding:5px;border:1px solid black;">				<b>Amount</b>			</td>		</tr>	</thead>	<tbody>		[col:particular|quantity|mrp|amount]		<tr>			<td colspan="3" style="padding:5px;border:1px solid black;">Previous Due</td>			<td style="text-align:right;padding:5px;border:1px solid black;"><strong>[previous_due]</strong></td>		</tr>		<tr>			<td colspan="3" style="padding:5px;border:1px solid black;">Discount</td>			<td style="text-align:right;padding:5px;border:1px solid black;"><strong>[discount]</strong></td>		</tr>		<tr>			<td colspan="3" style="padding:5px;border:1px solid black;">Total</td>			<td style="text-align:right;padding:5px;border:1px solid black;"><strong>[total]</strong></td>		</tr>				<tr>			<td colspan="3" style="padding:5px;border:1px solid black;">Paid Amount</td>			<td style="text-align:right;padding:5px;border:1px solid black;">[paid_amount]</td>		</tr>	</tbody></table>Received with Thanks,<p>For [clinic_name]</p><p><br></p><p><br></p><p>Signature</p>', 1, 'Main', 'bill');

-- --------------------------------------------------------

--
-- Table structure for table `ck_todos`
--

CREATE TABLE IF NOT EXISTS `ck_todos` (
  `id_num` int(11) NOT NULL,
  `userid` int(11) DEFAULT '0',
  `todo` varchar(250) DEFAULT NULL,
  `done` int(11) DEFAULT '0',
  `add_date` datetime DEFAULT NULL,
  `done_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ck_users`
--

CREATE TABLE IF NOT EXISTS `ck_users` (
  `userid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(15) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_users`
--

INSERT INTO `ck_users` (`userid`, `name`, `username`, `password`, `level`, `is_active`) VALUES
(1, 'Administrator', 'admin2', 'YWRtaW4=', 'Administrator', 1),
(3, 'Administrator', 'admin', 'aHV5aG9hbmdrNTc=', 'Administrator', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ck_user_categories`
--

CREATE TABLE IF NOT EXISTS `ck_user_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_user_categories`
--

INSERT INTO `ck_user_categories` (`id`, `category_name`) VALUES
(1, 'Administrator'),
(2, 'Doctor'),
(3, 'Receptionist');

-- --------------------------------------------------------

--
-- Table structure for table `ck_version`
--

CREATE TABLE IF NOT EXISTS `ck_version` (
  `id` int(11) NOT NULL,
  `current_version` varchar(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ck_version`
--

INSERT INTO `ck_version` (`id`, `current_version`) VALUES
(1, '0.2.4');

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_bill`
--
CREATE TABLE IF NOT EXISTS `ck_view_bill` (
`bill_id` int(11)
,`bill_date` date
,`visit_id` int(11)
,`doctor_name` varchar(255)
,`userid` int(11)
,`patient_id` int(11)
,`display_id` varchar(12)
,`first_name` varchar(50)
,`middle_name` varchar(50)
,`last_name` varchar(50)
,`total_amount` decimal(10,0)
,`due_amount` decimal(11,2)
,`pay_amount` decimal(10,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_bill_detail_report`
--
CREATE TABLE IF NOT EXISTS `ck_view_bill_detail_report` (
`bill_id` int(11)
,`bill_date` date
,`visit_id` int(11)
,`particular` varchar(50)
,`amount` decimal(10,2)
,`userid` int(11)
,`patient_name` varchar(152)
,`display_id` varchar(12)
,`type` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_contact_email`
--
CREATE TABLE IF NOT EXISTS `ck_view_contact_email` (
`contact_id` int(11)
,`email` varchar(150)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_email`
--
CREATE TABLE IF NOT EXISTS `ck_view_email` (
`contact_id` int(11)
,`emails` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_patient`
--
CREATE TABLE IF NOT EXISTS `ck_view_patient` (
`patient_id` int(11)
,`patient_since` date
,`display_id` varchar(12)
,`gender` varchar(10)
,`dob` date
,`reference_by` varchar(255)
,`followup_date` date
,`display_name` varchar(255)
,`contact_id` int(11)
,`first_name` varchar(50)
,`middle_name` varchar(50)
,`last_name` varchar(50)
,`phone_number` varchar(15)
,`email` varchar(150)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_payment`
--
CREATE TABLE IF NOT EXISTS `ck_view_payment` (
`payment_id` int(11)
,`bill_id` int(11)
,`pay_date` date
,`pay_mode` varchar(50)
,`cheque_no` varchar(50)
,`pay_amount` decimal(10,0)
,`bill_date` date
,`patient_id` int(11)
,`display_id` varchar(12)
,`first_name` varchar(50)
,`middle_name` varchar(50)
,`last_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_report`
--
CREATE TABLE IF NOT EXISTS `ck_view_report` (
`appointment_id` int(11)
,`patient_id` int(11)
,`patient_name` varchar(152)
,`userid` int(11)
,`appointment_date` date
,`appointment_time` time
,`waiting_in` time
,`waiting_duration` double(17,0)
,`consultation_in` time
,`consultation_out` time
,`consultation_duration` double(17,0)
,`waiting_out` time
,`collection_amount` decimal(10,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_visit`
--
CREATE TABLE IF NOT EXISTS `ck_view_visit` (
`visit_id` int(11)
,`visit_date` varchar(60)
,`visit_time` varchar(50)
,`type` varchar(50)
,`notes` text
,`userid` int(11)
,`name` varchar(255)
,`patient_id` int(11)
,`bill_id` int(11)
,`total_amount` decimal(10,0)
,`due_amount` decimal(11,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ck_view_visit_treatments`
--
CREATE TABLE IF NOT EXISTS `ck_view_visit_treatments` (
`visit_id` int(11)
,`particular` varchar(50)
,`type` varchar(25)
);

-- --------------------------------------------------------

--
-- Table structure for table `ck_visit`
--

CREATE TABLE IF NOT EXISTS `ck_visit` (
  `visit_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `notes` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `visit_date` varchar(60) NOT NULL,
  `visit_time` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_11_24_163032_create_users', 1),
('2015_12_01_171704_create_patients', 1),
('2015_12_01_212353_create_ck_contact', 2),
('2015_12_01_214137_create_ck_contacts', 3);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id_patient` int(10) unsigned NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `middelname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `displayname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postalcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id_patient`, `firstname`, `middelname`, `lastname`, `phonenumber`, `displayname`, `email`, `address`, `city`, `state`, `postalcode`, `country`, `created_at`, `updated_at`) VALUES
(1, 'd', 'h', 'hoang', '129129', 'hoang', 'hoang@gmail.com', 'ksdj', 'kdjf', 'kjdks', 'kjkj', 'kjkj', '2015-12-01 14:34:08', '2015-12-01 14:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `ck_view_bill`
--
DROP TABLE IF EXISTS `ck_view_bill`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_bill` AS select `bill`.`bill_id` AS `bill_id`,`bill`.`bill_date` AS `bill_date`,`bill`.`visit_id` AS `visit_id`,`users`.`name` AS `doctor_name`,`visit`.`userid` AS `userid`,`patient`.`patient_id` AS `patient_id`,`patient`.`display_id` AS `display_id`,`contacts`.`first_name` AS `first_name`,`contacts`.`middle_name` AS `middle_name`,`contacts`.`last_name` AS `last_name`,`bill`.`total_amount` AS `total_amount`,`bill`.`due_amount` AS `due_amount`,`payment`.`pay_amount` AS `pay_amount` from (((((`ck_bill` `bill` join `ck_visit` `visit` on((`bill`.`visit_id` = `visit`.`visit_id`))) join `ck_users` `users` on((`visit`.`userid` = `users`.`userid`))) join `ck_patient` `patient` on((`bill`.`patient_id` = `patient`.`patient_id`))) join `ck_payment` `payment` on((`payment`.`bill_id` = `bill`.`bill_id`))) join `ck_contacts` `contacts` on((`contacts`.`contact_id` = `patient`.`contact_id`)));

-- --------------------------------------------------------

--
-- Structure for view `ck_view_bill_detail_report`
--
DROP TABLE IF EXISTS `ck_view_bill_detail_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_bill_detail_report` AS select `bill`.`bill_id` AS `bill_id`,`bill`.`bill_date` AS `bill_date`,`bill`.`visit_id` AS `visit_id`,`bill_detail`.`particular` AS `particular`,`bill_detail`.`amount` AS `amount`,`visit`.`userid` AS `userid`,concat(`view_patient`.`first_name`,' ',`view_patient`.`middle_name`,' ',`view_patient`.`last_name`) AS `patient_name`,`view_patient`.`display_id` AS `display_id`,`bill_detail`.`type` AS `type` from (((`ck_bill` `bill` left join `ck_bill_detail` `bill_detail` on((`bill_detail`.`bill_id` = `bill`.`bill_id`))) left join `ck_visit` `visit` on((`visit`.`visit_id` = `bill`.`visit_id`))) left join `ck_view_patient` `view_patient` on((`view_patient`.`patient_id` = `bill`.`patient_id`)));

-- --------------------------------------------------------

--
-- Structure for view `ck_view_contact_email`
--
DROP TABLE IF EXISTS `ck_view_contact_email`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_contact_email` AS select `ck_contact_details`.`contact_id` AS `contact_id`,`ck_contact_details`.`detail` AS `email` from `ck_contact_details` where (`ck_contact_details`.`type` = 'email');

-- --------------------------------------------------------

--
-- Structure for view `ck_view_email`
--
DROP TABLE IF EXISTS `ck_view_email`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_email` AS select `ck_contact_details`.`contact_id` AS `contact_id`,group_concat(`ck_contact_details`.`detail` separator ',') AS `emails` from `ck_contact_details` where (`ck_contact_details`.`type` = 'email') group by `ck_contact_details`.`contact_id`;

-- --------------------------------------------------------

--
-- Structure for view `ck_view_patient`
--
DROP TABLE IF EXISTS `ck_view_patient`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_patient` AS select `patient`.`patient_id` AS `patient_id`,`patient`.`patient_since` AS `patient_since`,`patient`.`display_id` AS `display_id`,`patient`.`gender` AS `gender`,`patient`.`dob` AS `dob`,`patient`.`reference_by` AS `reference_by`,`patient`.`followup_date` AS `followup_date`,`contacts`.`display_name` AS `display_name`,`contacts`.`contact_id` AS `contact_id`,`contacts`.`first_name` AS `first_name`,`contacts`.`middle_name` AS `middle_name`,`contacts`.`last_name` AS `last_name`,`contacts`.`phone_number` AS `phone_number`,`contacts`.`email` AS `email` from (`ck_patient` `patient` left join `ck_contacts` `contacts` on((`patient`.`contact_id` = `contacts`.`contact_id`)));

-- --------------------------------------------------------

--
-- Structure for view `ck_view_payment`
--
DROP TABLE IF EXISTS `ck_view_payment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_payment` AS select `payment`.`payment_id` AS `payment_id`,`payment`.`bill_id` AS `bill_id`,`payment`.`pay_date` AS `pay_date`,`payment`.`pay_mode` AS `pay_mode`,`payment`.`cheque_no` AS `cheque_no`,`payment`.`pay_amount` AS `pay_amount`,`bill`.`bill_date` AS `bill_date`,`bill`.`patient_id` AS `patient_id`,`patient`.`display_id` AS `display_id`,`contacts`.`first_name` AS `first_name`,`contacts`.`middle_name` AS `middle_name`,`contacts`.`last_name` AS `last_name` from (((`ck_payment` `payment` join `ck_bill` `bill` on((`payment`.`bill_id` = `bill`.`bill_id`))) join `ck_patient` `patient` on((`patient`.`patient_id` = `bill`.`patient_id`))) join `ck_contacts` `contacts` on((`contacts`.`contact_id` = `patient`.`contact_id`)));

-- --------------------------------------------------------

--
-- Structure for view `ck_view_report`
--
DROP TABLE IF EXISTS `ck_view_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_report` AS select `appointment`.`appointment_id` AS `appointment_id`,`appointment`.`patient_id` AS `patient_id`,concat(ifnull(`view_patient`.`first_name`,''),' ',ifnull(`view_patient`.`middle_name`,''),' ',ifnull(`view_patient`.`last_name`,'')) AS `patient_name`,`appointment`.`userid` AS `userid`,`appointment`.`appointment_date` AS `appointment_date`,min(`appointment`.`start_time`) AS `appointment_time`,max((case `appointment_log`.`status` when 'Waiting' then `appointment_log`.`from_time` end)) AS `waiting_in`,(max((case `appointment_log`.`status` when 'Consultation' then `appointment_log`.`from_time` end)) - max((case `appointment_log`.`status` when 'Waiting' then `appointment_log`.`from_time` end))) AS `waiting_duration`,max((case `appointment_log`.`status` when 'Consultation' then `appointment_log`.`from_time` end)) AS `consultation_in`,max((case `appointment_log`.`status` when 'Complete' then `appointment_log`.`from_time` end)) AS `consultation_out`,(max((case `appointment_log`.`status` when 'Complete' then `appointment_log`.`from_time` end)) - max((case `appointment_log`.`status` when 'Consultation' then `appointment_log`.`from_time` end))) AS `consultation_duration`,max((case `appointment_log`.`old_status` when 'Consultation' then timediff(`appointment_log`.`to_time`,`appointment_log`.`from_time`) end)) AS `waiting_out`,max(`bill`.`total_amount`) AS `collection_amount` from (((`ck_appointments` `appointment` left join `ck_view_patient` `view_patient` on((`appointment`.`patient_id` = `view_patient`.`patient_id`))) left join `ck_bill` `bill` on((`appointment`.`visit_id` = `bill`.`visit_id`))) left join `ck_appointment_log` `appointment_log` on((`appointment`.`appointment_id` = `appointment_log`.`appointment_id`))) group by `appointment`.`appointment_id`,`patient_name`;

-- --------------------------------------------------------

--
-- Structure for view `ck_view_visit`
--
DROP TABLE IF EXISTS `ck_view_visit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_visit` AS select `visit`.`visit_id` AS `visit_id`,`visit`.`visit_date` AS `visit_date`,`visit`.`visit_time` AS `visit_time`,`visit`.`type` AS `type`,`visit`.`notes` AS `notes`,`visit`.`userid` AS `userid`,`users`.`name` AS `name`,`visit`.`patient_id` AS `patient_id`,`bill`.`bill_id` AS `bill_id`,`bill`.`total_amount` AS `total_amount`,`bill`.`due_amount` AS `due_amount` from ((`ck_visit` `visit` join `ck_users` `users` on((`users`.`userid` = `visit`.`userid`))) join `ck_bill` `bill` on((`bill`.`visit_id` = `visit`.`visit_id`))) order by `visit`.`patient_id`,`visit`.`visit_date`,`visit`.`visit_time`;

-- --------------------------------------------------------

--
-- Structure for view `ck_view_visit_treatments`
--
DROP TABLE IF EXISTS `ck_view_visit_treatments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ck_view_visit_treatments` AS select `visit`.`visit_id` AS `visit_id`,`bill_detail`.`particular` AS `particular`,`bill_detail`.`type` AS `type` from ((`ck_visit` `visit` left join `ck_bill` `bill` on((`bill`.`visit_id` = `visit`.`visit_id`))) left join `ck_bill_detail` `bill_detail` on((`bill_detail`.`bill_id` = `bill`.`bill_id`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ck_appointments`
--
ALTER TABLE `ck_appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `ck_bill`
--
ALTER TABLE `ck_bill`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `ck_bill_detail`
--
ALTER TABLE `ck_bill_detail`
  ADD PRIMARY KEY (`bill_detail_id`);

--
-- Indexes for table `ck_clinic`
--
ALTER TABLE `ck_clinic`
  ADD PRIMARY KEY (`clinic_id`);

--
-- Indexes for table `ck_contact`
--
ALTER TABLE `ck_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `ck_contacts`
--
ALTER TABLE `ck_contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `ck_contactss`
--
ALTER TABLE `ck_contactss`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `ck_contactsss`
--
ALTER TABLE `ck_contactsss`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `ck_contact_details`
--
ALTER TABLE `ck_contact_details`
  ADD PRIMARY KEY (`contact_detail_id`);

--
-- Indexes for table `ck_data`
--
ALTER TABLE `ck_data`
  ADD PRIMARY KEY (`ck_data_id`);

--
-- Indexes for table `ck_invoice`
--
ALTER TABLE `ck_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `ck_menu_access`
--
ALTER TABLE `ck_menu_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ck_modules`
--
ALTER TABLE `ck_modules`
  ADD PRIMARY KEY (`module_id`), ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `ck_navigation_menu`
--
ALTER TABLE `ck_navigation_menu`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `menu_name` (`menu_name`);

--
-- Indexes for table `ck_patient`
--
ALTER TABLE `ck_patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `ck_payment`
--
ALTER TABLE `ck_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `ck_payment_transaction`
--
ALTER TABLE `ck_payment_transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `ck_receipt_template`
--
ALTER TABLE `ck_receipt_template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `ck_todos`
--
ALTER TABLE `ck_todos`
  ADD PRIMARY KEY (`id_num`);

--
-- Indexes for table `ck_users`
--
ALTER TABLE `ck_users`
  ADD PRIMARY KEY (`userid`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ck_user_categories`
--
ALTER TABLE `ck_user_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ck_version`
--
ALTER TABLE `ck_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ck_visit`
--
ALTER TABLE `ck_visit`
  ADD PRIMARY KEY (`visit_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id_patient`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ck_appointments`
--
ALTER TABLE `ck_appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_bill`
--
ALTER TABLE `ck_bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_bill_detail`
--
ALTER TABLE `ck_bill_detail`
  MODIFY `bill_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_contact`
--
ALTER TABLE `ck_contact`
  MODIFY `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_contacts`
--
ALTER TABLE `ck_contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_contactss`
--
ALTER TABLE `ck_contactss`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_contactsss`
--
ALTER TABLE `ck_contactsss`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_contact_details`
--
ALTER TABLE `ck_contact_details`
  MODIFY `contact_detail_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_data`
--
ALTER TABLE `ck_data`
  MODIFY `ck_data_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ck_invoice`
--
ALTER TABLE `ck_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_menu_access`
--
ALTER TABLE `ck_menu_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ck_modules`
--
ALTER TABLE `ck_modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_navigation_menu`
--
ALTER TABLE `ck_navigation_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ck_patient`
--
ALTER TABLE `ck_patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_payment`
--
ALTER TABLE `ck_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_payment_transaction`
--
ALTER TABLE `ck_payment_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_receipt_template`
--
ALTER TABLE `ck_receipt_template`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_todos`
--
ALTER TABLE `ck_todos`
  MODIFY `id_num` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ck_users`
--
ALTER TABLE `ck_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ck_user_categories`
--
ALTER TABLE `ck_user_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ck_version`
--
ALTER TABLE `ck_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ck_visit`
--
ALTER TABLE `ck_visit`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id_patient` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
