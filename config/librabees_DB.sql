-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2022 at 07:56 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Database: `librabees_DB`
--
--
-- Table structure for table `errQueries`
--
CREATE TABLE `errQueries` (
  `err_id` int(250) NOT NULL,
  `err_title` varchar(50) NOT NULL,
  `err_sender` varchar(50) NOT NULL,
  `err_desc` text NOT NULL,
  `err_Img` varchar(50)  NULL,
  `err_report_created` timestamp NOT NULL DEFAULT current_timestamp()
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Table structure for table `reserve`
--

CREATE TABLE `reserve_book` (
  `reserve_id` int(250) NOT NULL,
  `book_id` int(50) NOT NULL,
  `stud_number` varchar(50) NOT NULL,
  `reserve_time` timestamp NOT NULL DEFAULT current_timestamp()
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(250) NOT NULL,
  `stud_number` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `compost_id` int(250) NOT NULL,
  `compost_time` timestamp NOT NULL DEFAULT current_timestamp()
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `community_post`
--

CREATE TABLE `community_post` (
  `compost_id` int(250) NOT NULL,
  `stud_number` varchar(50) NOT NULL,
  `compost_content` text NOT NULL,
  `compost_time` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(250) NOT NULL,
  `chat_msg` text NOT NULL,
  `chat_receiver` varchar(50) NOT NULL,
  `chat_sender` varchar(50) NOT NULL,
  `chat_status` int(1) NOT NULL DEFAULT 0,
  `chat_time` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `notif_title` varchar(50) NOT NULL,
  `notif_msg` text NOT NULL,
  `send_to` varchar(50) NOT NULL,
  `notif_time` date,
  `notif_end` date NULL,
  `notif_sta_usrvw` varchar(10) NOT NULL DEFAULT('unseen'),
  `publish_dt` timestamp NOT NULL DEFAULT current_timestamp()

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `barrow_book`
--

CREATE TABLE `barrow_book` (
  `barrow_id` int(11) NOT NULL,
  `stud_number` varchar(50) NOT NULL,
  `stud_barr_name` varchar(150) NOT NULL,
  `book_id` varchar(150) NOT NULL,
  `book_title` varchar(50) NOT NULL,
  `book_author` varchar(50) NOT NULL,
  `book_image` varchar(255) NOT NULL DEFAULT('./uploads/south.png'),
  `book_status` int(1) NOT NULL DEFAULT 1,
  `email_barrower` varchar(150) NULL,
  `days_can_barrowed` int(11) NOT NULL,
  `barrow_dt` timestamp  NULL,
  `return_dt` timestamp  NULL, 
  `lost_dt` timestamp  NULL,
  `pickup_dt` timestamp,
  `dt_overdue` int(11)  NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barrow_book`
--



-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `subject` (`subject_id`, `subject_name`) VALUES
(1, 'Statistic'),
(2, 'Romance'),
(3, 'Horror'),
(4, 'Anime'),
(5, 'Fantasy'),
(6, 'Crime'),
(7, 'Life'),
(8, 'Comedy'),
(9, 'Style'),
(10, 'Cooking'),
(11, 'Drama'),
(12, 'Math'),
(13, 'Science'),
(14, 'History'),
(15, 'Sci-Fi');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Filipiniana Section'),
(2, 'Foreign Section'),
(3, 'Reserve Section'),
(4, 'Reference Section');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_title` varchar(50) NOT NULL,
  `book_code` varchar(50) NOT NULL,
  `book_author` varchar(50) NOT NULL,
  `book_desc` text NOT NULL,
  `book_image` varchar(255) NOT NULL DEFAULT('./uploads/south.PNG'),
  `book_status` int(11)  NOT NULL DEFAULT 1,
  `days_can_barrowed` int(11) NOT NULL,
  `category_id` varchar(200) NULL,
  `bookcategory_id` varchar(200) NULL,
  `booksubject_id` varchar(200) NULL,
  `book_copies` int(11) NULL,
  
  `publication_date` varchar(50) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_title`, `book_code`, `book_author`,`book_desc`, `book_image`, `book_status`, `days_can_barrowed`, `category_id`, `bookcategory_id`,`booksubject_id`,`book_copies`, `publication_date`) VALUES
(1, 'Look Homeward Angel', '106936', 'Thomas Wolfe','A Story of the Buried Life is a 1929 novel by Thomas Wolfe. It is Wolfe first novel, and is considered a highly autobiographical American Bildungsroman. The character of Eugene Gant is generally believed to be a depiction of Wolfe himself. The novel covers the span of time from Gants birth to the age of 19', './uploads/lookhomewardangel.jpg', 1,3,'Foreign Section','Community Engagement','Romance',1, '1929'),
(2, 'The Handmaids Tale', '9780395404256', 'Atwood Margaret','The Handmaids Tale is a dystopian novel written by Margaret Atwood in 1985. It depicts a totalitarian world known as Gilead. portraying the subjection of women in a patriarchal society. ', './uploads/thehandmantail.jpg', 1,2,'Foreign Section','Global Nonfiction','Fantasy',1, '1986'),
(3, 'I Know Why the Caged Bird Sings', '9780860685111', 'Angelou, Dr Maya','Titled after a stanza from Paul Laurence Dunbars poem Sympathy I Know Why the Caged Bird Sings is the first of a series of seven autobiographical novels by African-American poet and writer Maya Angelou. Personally deeply involved and affected by the civil rights movement', './uploads/birdsings.jpg', 1,4,'Foreign Section','Community Engagement','Statistic',1, '1969'),
(4, 'AUTOMOBILIA', '016200', 'Automobile Pricing Publications; Auto Blue Book Bluebook staff','The very first Auto Blue Book, Volume 1 -- Number 1, dated Summer 1959. Very Good condition. Light cover soil. Pages mildly age-tanned ', './uploads/automobilia.jpg', 1,4,'Foreign Section','Community Engagement','Statistic',1, '1959'),
(5, 'Practical Mathematics, Parts I, II, III, IV, Instruction Paper', 'AA0100049', 'Automobile Pricing Publications; Auto Blue Book [Bluebook] staff','The very first Auto Blue Book, Volume 1 -- Number 1, dated Summer 1959. Very Good condition. Light cover soil. Pages mildly age-tanned ', './uploads/pracmath.jpg', 1,4,'Foreign Section','Community Engagement','Statistic',1, '1959'),
(6, 'Birds and Ornithology', '030898', 'A History of British Birds','LONDON: George Bell & Sons, 1870 A nice set of the second edition of Morriss History of British Birds. In 6 volumes with original decorative cloth bindings and 365 hand coloured plates as called for.', './uploads/historyofbirds.jpg', 1,4,'Foreign Section','Community Engagement','Statistic',1, '1959'),
(7, 'The Library at Mount Char: A Novel', 'B21354', 'Matt Haig s','LONDON: George Bell & Sons, 1870 A nice set of the second edition of Morriss History of British Birds. In 6 volumes with original decorative cloth bindings and 365 hand coloured plates as called for.', './uploads/mount car.jpg', 1,4,'Reserve Section','Community Engagement','Life',1, '1986'),
(8, 'A summer beach read', '658451', 'Brenda Novak ','LONDON: George Bell & Sons, 1870 A nice set of the second edition of Morriss History of British Birds. In 6 volumes with original decorative cloth bindings and 365 hand coloured plates as called for.', './uploads/81m4DdKJTwL._AC_UY218_.jpg', 1,4,'Global Nonfiction','Community Engagement','Life',1, '2002'),
(9, 'Wuthering Heights', '65744', ' Emily Brontë','Complete Unabridged 1847 Special Edition with a Historical Annotation and Author Biography One of the greatest romances ever written Emily Bronte has left a legacy in classic English literature.Experience a new presentation of this classic.', './uploads/71nXI8KFiXL._AC_UY218_.jpg', 1,4,'Reference Section','Multicultural Tales','Drama',1, '2023'),
(10, 'The Library Book', '65284', 'Susan Orlean','Complete Unabridged 1847 Special Edition with a Historical Annotation and Author Biography One of the greatest romances ever written Emily Bronte has left a legacy in classic English literature.Experience a new presentation of this classic.', './uploads/81VtM49TzfL._AC_UY218_.jpg', 1,4,'Reserve Section','Global Nonfiction','Style',1, '2018'),
(11, 'Naruto', '65284', 'Legendary Sanin Jiraiya','Naruto was born on the night of October 10th to Minato Namikaze (the Fourth Hokage) and Kushina Uzumaki (the second jinchūriki of the Nine-Tails). He was named after Naruto Musasabi, the protagonist of Jiraiyas first book which made the Sannin his godfather.', './uploads/naruto.jpg', 1,4,'Foreign Section','Diverse Fiction','Anime',1, '2005'),
(12, 'Bleach', '65284', 'Itchigo','Naruto was born on the night of October 10th to Minato Namikaze (the Fourth Hokage) and Kushina Uzumaki (the second jinchūriki of the Nine-Tails). He was named after Naruto Musasabi, the protagonist of Jiraiyas first book which made the Sannin his godfather.', './uploads/bleach.jpg', 1,4,'Foreign Section','Diverse Fiction','Anime',1, '2004'),
(13, 'Fetching Raymond: A Story from the Ford County Collection', '65284', 'John Grisham ','From the beginning of their careers as thieves, the Graney boys were hounded by an obnoxious deputy named Coy Childers', './uploads/91XtkQAlgbL._AC_UY218_.jpg', 1,4,'Foreign Section','Multicultural Tales','Fantasy',1, '2013'),
(14, 'The River Deadly', '651244', 'Terry Darnell','Based on a true story, three friends blaze a path through the Pacific Northwest so they can fish drink and pay respects to a dead girls marker. ', './uploads/613sa8aohcL._AC_UY218_.jpg', 1,4,'Foreign Section','Global Nonfiction','Drama',1, '2004'),
(15, 'The Woman in the Library', '564844', 'Sulari Gentill','Based on a true story, three friends blaze a path through the Pacific Northwest so they can fish drink and pay respects to a dead girls marker.', './uploads/81ysl1U+DLL._AC_UY218_.jpg', 1,4,'Foreign Section','Global Nonfiction','Horror',1, '2004'),
(16, 'The Lion: Son Of The Forest (Warhammer 40,000)', '515422', 'Mike Brooks','announced via the Warhammer Community website on Wednesday, will shake up decades of established lore. The book follows Dark Angels Primarch Lion ElJonson on his first adventure since awakening in the 41st millennium, and will break with some pillars of the Dark Angels canon.', './uploads/81tPUqbXRML._AC_UY218_.jpg', 1,4,'Foreign Section','Diverse Fiction','Fantasy',1, '2023'),
(17, 'Murder in the Library', '515422', 'Katie Gayle ','announced via the Warhammer Community website on Wednesday, will shake up decades of established lore. The book follows Dark Angels Primarch Lion ElJonson on his first adventure since awakening in the 41st millennium, and will break with some pillars of the Dark Angels canon.', './uploads/91LwZI3VD5L._AC_UY218_.jpg', 1,4,'Foreign Section','Diverse Fiction','Horror',1, '2023'),
(18, 'The Pain Colony (The Colony)', '515422', 'Shanon Hunt','A thrilling combination of Constantine and The Exorcist, Andy Lorenzo prepares himself for the greatest fight of his life--the battle for Kates soul.', './uploads/71u0+xPr12L._AC_UY218_.jpg', 1,4,'Reference Section','Diverse Fiction','Horror',1, '2019'),
(19, 'Battle of the Soul', '66666', 'Carl Alves','announced via the Warhammer Community website on Wednesday, will shake up decades of established lore. The book follows Dark Angels Primarch Lion ElJonson on his first adventure since awakening in the 41st millennium, and will break with some pillars of the Dark Angels canon.', './uploads/71bHFwq4j5L._AC_UY218_.jpg', 1,4,'Reference Section','Diverse Fiction','Horror',1, '2017'),
(20, 'Complete Curriculum Success Kindergarten - Learning Workbook For Kindergarten', '123456', 'Popular Book Company Popular Book USA','Complete Curriculum Success Kindergarten - Learning Workbook For Kindergarten Students - English, Math and Science Activities Children Book.', './uploads/81uoL0ndlWS._AC_UY218_.jpg', 1,4,'Reference Section','Community Engagement','Math',1, '2017'),
(21, 'DK Workbooks: Science', '548972', 'Popular Book Company Popular Book USA','Complete Curriculum Success Kindergarten - Learning Workbook For Kindergarten Students - English, Math and Science Activities Children Book.', './uploads/813WbvU-BFL._AC_UY218_.jpg', 1,4,'Reference Section','Community Engagement','Science',1, '2017'),
(22, 'Addition and Subtraction Math Workbook', '548972', 'Cottage Path Press','Complete Curriculum Success Kindergarten - Learning Workbook For Kindergarten Students - English, Math and Science Activities Children Book.', './uploads/71gcM59iA5L._AC_UY218_.jpg', 1,4,'Reference Section','Community Engagement','Math',1, '2017'),
(23, 'Improving Learning and Mental Health', '658754', 'Robert Eaton, Steven V. Hunsaker','Improving Learning and Mental Health in the College Classroom (Teaching and Learning in Higher Education).', './uploads/71v2YY8vXqL._AC_UY218_.jpg', 1,4,'Reserve Section','Community Engagement','Life',1, '2017'),
(24, 'Visual Learning: Biology', '984265', 'Helen Pitcher','Improving Learning and Mental Health in the College Classroom (Teaching and Learning in Higher Education).', './uploads/th.jpg', 1,4,'Reference Section','Community Engagement','Science',1, '2017'),
(25, 'Noli Me Tangere', '514877', 'Jose Rizal, Raul L. Locsin',' In this modern classic of Filipino literature, Jose Rizal exposes matters . . . so delicate that they cannot be touched by anybody, unfolding an epic history of the Philippines that has made it that country most influential political novel in the nineteenth and twentieth centuries. Jose Rizal national hero of the Philippines completed Noli Me Tangere in Spanish in 1887 while he was studying in Europe. Rizal continued to write, completing a second novel and many other', './uploads/content.jpg', 1,4,'Filipiniana Section','Diverse Fiction','History',1, '1997'),
(26, 'El Filibusterismo', '514877', 'Jose Rizal',' In this modern classic of Filipino literature, Jose Rizal exposes matters . . . so delicate that they cannot be touched by anybody, unfolding an epic history of the Philippines that has made it that country most influential political novel in the nineteenth and twentieth centuries. Jose Rizal national hero of the Philippines completed Noli Me Tangere in Spanish in 1887 while he was studying in Europe. Rizal continued to write, completing a second novel and many other', './uploads/content (1).jpg', 1,4,'Filipiniana Section','Diverse Fiction','History',1, '2006 ');



-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `stud_id` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL,
 `ratingNumber` int(11) NOT NULL,
  `comments` text NOT NULL,
  `brrow_id` int(11)  NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `stud_id`, `book_id`, `ratingNumber`, `comments`, `created`, `status`) VALUES
(14, '19-00291', 1, 4, 'YOU. ARE. THE. DEAD. Oh my God. I got the chills so many times toward the end of this book. It completely blew my mind. It managed to surpass my high expectations AND be nothing at all like I expected.', '2018-08-19 09:13:01', 1),
(15, '19-00291', 2, 5, 'Nice product', '2018-08-19 09:13:37', 1),
(16, '19-00059', 3, 4, 'The hype around this book has been unquestionable and, admittedly, that made me both eager to get my hands on it and terrified to read it. ', '2018-08-19 09:14:19',1),
(17, '19-00291', 4, 4, 'Quick Thoughts and Rating: 5 stars! I cannot imagine how challenging it would be to tackle the voice of a movement like Black Lives Matter', '2018-08-19 09:18:00',  1),
(22, '19-00059', 5, 4, '4 stars. Great world-building, weak romance, but still worth the read.', '2019-01-20 17:00:58', 1),
(23, '20-00089', 5, 5, 'Nice book', '2019-01-20 17:01:37',  1),
(24, '11-00063', 3, 4, 'Detailed characterization leading to unforgettable characters', '2019-01-20 21:06:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookcategory`
--

CREATE TABLE `bookcategory` (
  `bookcategory_id` int(11) NOT NULL,
  `bookcategory_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookcategory`
--

INSERT INTO `bookcategory` (`bookcategory_id`, `bookcategory_name`) VALUES
(1, 'Diverse Fiction'),
(2, 'Global Nonfiction'),
(3, 'Multicultural Tales'),
(4, 'Community Engagement'),
(5, 'Periodicals');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin_Lib` (
  `admin_id` int(11) NOT NULL,
  `admin_pos` varchar(200) NOT NULL,
  `admin_fname` varchar(200) NOT NULL,
  `admin_sname` varchar(255) NOT NULL,
  `admin_user` varchar(255) NOT NULL,
  `admin_password` varchar(150) NOT NULL,
  `admin_currChat` varchar(50)  NULL,
  `adverification_code` text  NULL,
  `ademail_verified_at` date DEFAULT NULL,
  `isBookAccess` int(11) NOT NULL DEFAULT 0,
  `isStudentAccess` int(11) NOT NULL DEFAULT 0,
  `isChatAccess` int(11) NOT NULL DEFAULT 0,
  `isNotifAccess` int(11) NOT NULL DEFAULT 0,
  `isReviewsCommsAccess` int(11) NOT NULL DEFAULT 0,
  `isMainAdmin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `admin`
--
INSERT INTO `admin_Lib` (`admin_id`,`admin_pos`, `admin_fname`, `admin_sname`, `admin_user`, `admin_password`,`isBookAccess`,`isStudentAccess`,`isChatAccess`,`isNotifAccess`,`isReviewsCommsAccess`,`isMainAdmin`,`ademail_verified_at`) VALUES
(1,'Admin Librarian', 'Jeremy', 'Bashan', 'SEClibrabees@gmail.com', '$2y$10$cgC/777z0CITuHRoKQiAvO4gu0C0cVujNkxtV/CBtSpQzblmN/H2.',1,1,1,1,1,1,'2019-01-20 21:06:48');
--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `stud_id` int(11) NOT NULL,
  `pre_reg_number` varchar(50)  NULL,
  `lib_card_number` varchar(50)  NULL,
  `stud_number` varchar(50)  NULL,
  `stud_first_name` varchar(50)  NULL,
  `stud_last_name` varchar(50)  NULL,
  `stud_email` varchar(255)  NULL,
  `stud_yrlvl` varchar(50)  NULL,
  `stud_course` varchar(50)  NULL,
  `stud_gradelvl` varchar(50)  NULL,
  `stud_password` varchar(150)  NULL,
  `stud_contact_no` varchar(50)  NULL,
  `registered_at` date  NULL,
  `isAdmin` int(11) NOT NULL DEFAULT 0,
  `stud_address` varchar(255)  NULL,
  `verification_code` text  NULL,
  `stud_avatar` varchar(255)  NOT NULL DEFAULT ('student1.png'),
  `email_verified_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `users`
--
INSERT INTO `users` (`stud_id`,`pre_reg_number`, `lib_card_number`, `stud_number`, `stud_first_name`, `stud_last_name`,`stud_email`,`stud_yrlvl`,`stud_course`,`stud_password`,`stud_contact_no`,`registered_at`,`stud_address`,`verification_code`,`email_verified_at`) VALUES
(1,'5158696', '5158696', '5158696', 'Jao', 'Bandin', 'jao.bandin21@gmail.com', 'College', 'BSCS', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023', 'Pasay', '5158696', '2/21/2023'),
(2,'19-00059', '19-00059', '19-00059', 'Jomar', 'Geneta', 'jao.bandin21@gmail.com', 'College', 'BSCS', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023', 'Pasay', '5158696', '2/21/2023'),
(3,'19-00291', '19-00291', '19-00291', 'Dave', 'Manayon', 'dabyomanayon@gmail.com', 'College', 'BSED', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(4,'20-00089', '20-00089', '20-00089', 'Neslyn', 'Brizuela', 'brizuelaneslyn@gmail.com', 'College', 'BEED', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(5,'20-00090', '20-00089', '20-00089', 'Tonnie Rose', 'Buenafe', 'tonneeeeehh@gmail.com', 'College', 'BSOM', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023', 'Pasay', '5158696', '2/21/2023'),
(6,'20-00091', '20-00091', '20-00091', 'Kaizler', 'Guevarra', 'ffboi106@yahoo.com', 'High-School', 'BSCS', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(7,'20-00092', '20-00092', '20-00092', 'Sky Dylan', 'Debuton', 'sample@gmail.com', 'Elementary', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(8,'20-00093', '20-00093', '20-00093', 'Ferl Regilyn', 'Ramos', 'sample@gmail.com', 'Elementary', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(9,'20-00094', '20-00094', '20-00094', 'Emilio', 'Rigno', 'sample@gmail.comm', 'High-School', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(10,'20-00095', '20-00095', '20-00095', 'Jake', 'Tamayo', 'sample@gmail.com', 'High-School', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(11,'20-00096', '20-00096', '20-00096', 'Kate', 'Ramos', 'sample@gmail.com', 'High-School', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(12,'20-00097', '20-00097', '20-00097', 'Kathryn', 'Del Mundo', 'sample@gmail.com', 'High-School', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(13,'20-00098', '20-00098', '20-00098', 'James', 'Rapis', 'sample@gmail.com', 'Elementary', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(14,'20-00099', '20-00099', '20-00099', 'Daniel', 'Delos Santos', 'sample@gmail.com', 'Elementary', 'N/A', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(15,'20-00100', '20-00100', '20-00100', 'Joel', 'Dela Cruz', 'sample@gmail.com', 'Senior High', 'BSCS', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023'),
(16,'11-00063', '11-00063', '11-00063', 'Psalmy Joy', 'Gelacio', 'ffboi106@yahoo.com', 'College', 'BSCS', '$2y$10$Yn9iW.kfbUWkpcEwk5cBHe6vWHS6NceG4trtYFsbrZGmu8mHIlbIO', '09060382786', '2/21/2023',  'Pasay', '5158696', '2/21/2023');
-- --------------------------------------------------------
--
-- Indexes for dumped tables
--
--
-- Indexes for table `errQueries`
--
ALTER TABLE `errQueries`
  ADD PRIMARY KEY (`err_id`);


--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve_book`
  ADD PRIMARY KEY (`reserve_id`);
--
-- Indexes for table `community_post`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);



--
-- Indexes for table `community_post`
--
ALTER TABLE `community_post`
  ADD PRIMARY KEY (`compost_id`);


--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);


--
--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);


--
-- Indexes for table `barrow_id`
--
ALTER TABLE `barrow_book`
  ADD PRIMARY KEY (`barrow_id`);


--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);
  
ALTER TABLE category ADD CONSTRAINT uc_category_name UNIQUE (category_name);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `bookcategory_id` (`bookcategory_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `stud_id` (`stud_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `bookcategory`
--
ALTER TABLE `bookcategory`
  ADD PRIMARY KEY (`bookcategory_id`);

--
-- Indexes for table `admin_Lib`
--
ALTER TABLE `admin_Lib`
  ADD PRIMARY KEY (`admin_id`);

--
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`stud_id`);

ALTER TABLE users ADD UNIQUE(pre_reg_number);
--
-- AUTO_INCREMENT for dumped tables
--
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `errQueries`
  MODIFY `err_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `reserve_book`
  MODIFY `reserve_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `community_post`
--
ALTER TABLE `community_post`
  MODIFY `compost_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barrow_book`
--
ALTER TABLE `barrow_book`
  MODIFY `barrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookcategory`
--
ALTER TABLE `bookcategory`
  MODIFY `bookcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin_Lib`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `stud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--
-- Constraints for dumped tables
--

--





COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

