-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2012 at 02:54 PM
-- Server version: 5.1.36-community-log
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ole`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `question_id`, `answer`) VALUES
(1, 1, 'computer'),
(2, 1, 'kayboard'),
(3, 1, 'mouse'),
(4, 1, 'cpu'),
(5, 2, 'Phasellus felis dolor, scelerisque a, tempus eget'),
(6, 2, 'Phasellus felis dolor, scelerisque a, tempus eget'),
(7, 3, 'Phasellus felis dolor, scelerisque a, tempus eget'),
(8, 3, 'Phasellus felis dolor, scelerisque a, tempus eget');

-- --------------------------------------------------------

--
-- Table structure for table `paper`
--

CREATE TABLE IF NOT EXISTS `paper` (
  `paper_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  PRIMARY KEY (`paper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `question`, `subject_id`) VALUES
(1, 'what is router  ?', 1),
(2, 'what does mean jitter ?', 1),
(3, 'which os is best ?', 1),
(4, 'what is the difference b\\w static and dynamic router?\n', 1),
(5, 'what is the software engineering?', 1),
(6, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit?', 2),
(7, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit?', 2),
(8, 'Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at?', 2),
(9, 'Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at?', 2),
(10, 'Cras id elit. Integer quis urna.?', 3),
(11, 'Cras id elit. Integer quis urna.?', 3),
(12, 'Cras id elit. Integer quis urna.?', 3),
(13, 'Cras id elit. Integer quis urna.?', 3),
(14, 'Nunc tempus felis vitae urna. ?', 4),
(15, 'Nunc tempus felis vitae urna. ?', 4),
(16, 'Nunc tempus felis vitae urna. ?', 4),
(17, 'Phasellus felis dolor, scelerisque a, tempus eget?', 5),
(18, 'Phasellus felis dolor, scelerisque a, tempus eget?', 5),
(19, 'Phasellus felis dolor, scelerisque a, tempus eget?', 5),
(20, 'Phasellus felis dolor, scelerisque a, tempus eget?', 5);

-- --------------------------------------------------------

--
-- Table structure for table `question_paper`
--

CREATE TABLE IF NOT EXISTS `question_paper` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_name` varchar(255) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `question_paper`
--

INSERT INTO `question_paper` (`question_id`, `question_name`) VALUES
(1, 'what is ur name?');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_name` varchar(255) NOT NULL,
  `roll_number` varchar(255) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `enrollment_date` date NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `student_name`, `roll_number`, `fathers_name`, `enrollment_date`) VALUES
(5, 'waseem', '103', 'sharif', '2012-10-05'),
(6, 'sunil', '02', 'doulat', '2012-10-06'),
(7, 'Muqtada', '1234', 'G. Hohammad', '0000-00-00'),
(8, 'Ali', '555', 'Wali', '0000-00-00'),
(9, 'abc', '222', 'xyz', '0000-00-00'),
(10, 'wertwert', 'sdfg', 'dfgsdfg', '2012-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(255) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`) VALUES
(1, 'networking'),
(2, 'telephony'),
(3, 'software engineering'),
(4, 'database system'),
(5, 'operating system');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_name` varchar(255) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_name`, `fathers_name`) VALUES
(1, 'Aslam', 'Gulam'),
(2, 'Amit', 'Amarat'),
(3, 'Lachman', 'Lajpat'),
(4, 'Asad', 'Ali'),
(5, 'Sunder', 'Nawaz');

-- --------------------------------------------------------

--
-- Table structure for table `write_answer`
--

CREATE TABLE IF NOT EXISTS `write_answer` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
