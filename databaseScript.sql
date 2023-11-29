-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2023 at 09:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutoring`
--
CREATE DATABASE IF NOT EXISTS `tutoring` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tutoring`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `add_class`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_class` (IN `p_CName` CHAR(1), IN `p_SchoolYear` TINYINT, IN `p_CNumber` TINYINT, IN `p_AvailableSeats` TINYINT, IN `p_CDays` CHAR(7), IN `p_TimeForFirstDay` CHAR(8), IN `p_TimeForSecondDay` CHAR(8), IN `p_NextYears` TINYINT)   BEGIN
    INSERT INTO Class (
        CName,
        SchoolYear,
        CNumber,
        AvailableSeats,
        CDays,
        TimeForFirstDay,
        TimeForSecondDay,
        NextYears
    ) VALUES (
        p_CName,
        p_SchoolYear,
        p_CNumber,
        p_AvailableSeats,
        p_CDays,
        p_TimeForFirstDay,
        p_TimeForSecondDay,
        p_NextYears
    );
    SELECT LAST_INSERT_ID() ;
END$$

DROP PROCEDURE IF EXISTS `add_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user` (IN `firstName` CHAR(36), IN `lastName` CHAR(36), IN `usersPhone` INT, IN `userspassword` CHAR(72), IN `userType` TINYINT)   BEGIN
    DECLARE t CHAR(36);
    DECLARE num INT;
     DECLARE un CHAR(36);
     
    SET t=CONCAT(SUBSTRING(firstName FROM 1 FOR 1), SUBSTRING(lastName FROM 1 FOR 4));


    SELECT COUNT(*)
    INTO num
    FROM Users u
    WHERE u.username LIKE CONCAT(t, '%');
    SET num=num+1;

    SET un = CONCAT(t, CAST(num AS CHAR));

    IF userType = 0 THEN
        INSERT INTO Users (Fname, Lname, username, Upassword, UType, isEnrolled, Phone)
        VALUES (firstName, lastName, un, userspassword, 0, 0, usersPhone);
    END IF;

    IF userType = 1 THEN
        INSERT INTO Users (Fname, Lname, username, Upassword, UType, isEnrolled, Phone)
        VALUES (firstName, lastName, un, userspassword, 1, 1, usersPhone);
    END IF;
END$$

DROP PROCEDURE IF EXISTS `delete_class`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_class` (IN `p_CID` TINYINT)   BEGIN
    DELETE c 
    FROM CLASS c 
    WHERE c.CID=p_CID;
END$$

DROP PROCEDURE IF EXISTS `delete_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_user` (IN `p_username` CHAR(36))   BEGIN
    DELETE u  
    FROM Users u 
    WHERE u.username=p_username;
END$$

DROP PROCEDURE IF EXISTS `enroll`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `enroll` (IN `p_username` CHAR(36))   BEGIN
    UPDATE Users u 
    SET u.isEnrolled=1
    WHERE u.username=p_username ;
END$$

DROP PROCEDURE IF EXISTS `fetch_class_students`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_class_students` (IN `p_CID` TINYINT)   BEGIN
    SELECT u.*
    FROM Users u
    INNER JOIN BelongsTo b ON u.UserID=b.UserID
    INNER JOIN Class c ON b.CID=c.CID
    WHERE c.CID=p_CID;
END$$

DROP PROCEDURE IF EXISTS `fetch_next_years`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_next_years` (`p_SchoolYear` TINYINT)   BEGIN
    SELECT *
    FROM Class c
    WHERE c.NextYears=1 AND c.SchoolYear=p_SchoolYear;
END$$

DROP PROCEDURE IF EXISTS `fetch_other_students`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_other_students` (IN `p_CID` TINYINT)   BEGIN
    SELECT u1.*
    FROM Users u1
    WHERE u1.UType = 0
    AND NOT EXISTS (
        SELECT u2.*
        FROM Users u2
        INNER JOIN BelongsTo b ON u2.UserID = b.UserID
        INNER JOIN Class c ON b.CID = c.CID
        WHERE c.CID = p_CID AND u1.UserID = u2.UserID
    );
END$$

DROP PROCEDURE IF EXISTS `fetch_teachers`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_teachers` ()   BEGIN
SELECT u.Fname,u.Lname,u.username
FROM Users u
WHERE u.UType=1;

END$$

DROP PROCEDURE IF EXISTS `find_teaching_classes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `find_teaching_classes` (IN `p_username` CHAR(36))   BEGIN
SELECT c.*
FROM Class c
INNER JOIN Teaching t ON t.CID=c.CID
INNER JOIN Users u ON u.UserID=t.UserID
WHERE u.username=p_username;

END$$

DROP PROCEDURE IF EXISTS `find_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `find_user` (IN `firstName` CHAR(36), IN `lastName` CHAR(36), IN `usersPhone` INT)   BEGIN
    SELECT *
    FROM Users u
    WHERE u.Fname=firstName AND u.Lname=lastName AND u.Phone=usersPhone;
END$$

DROP PROCEDURE IF EXISTS `get_all_classes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_classes` ()   BEGIN
    SELECT *
    FROM Class;
END$$

DROP PROCEDURE IF EXISTS `get_enrolled`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_enrolled` ()   BEGIN
    SELECT *
    FROM Users u 
    WHERE u.isEnrolled=1 AND u.UType != 2;
END$$

DROP PROCEDURE IF EXISTS `get_unenrolled`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_unenrolled` ()   BEGIN
    SELECT *
    FROM Users u 
    WHERE u.isEnrolled=0 ;
END$$

DROP PROCEDURE IF EXISTS `get_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user` (IN `p_username` CHAR(36))   BEGIN
    SELECT *
    FROM Users u
    WHERE u.username = p_username;
END$$

DROP PROCEDURE IF EXISTS `insert_extra_lesson`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_extra_lesson` (IN `extraDate` DATE, IN `extraTime` CHAR(8), IN `classID` TINYINT)   BEGIN
    INSERT INTO ExtraLesson (ELDate, ELTime,CID) VALUES (extraDate, extraTime,classID);
END$$

DROP PROCEDURE IF EXISTS `insert_to_belongsto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_to_belongsto` (IN `p_UserID` SMALLINT, IN `p_CID` TINYINT)   BEGIN
    INSERT INTO BelongsTo (UserID, CID) VALUES (p_UserID, p_CID);
END$$

DROP PROCEDURE IF EXISTS `insert_to_teaching`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_to_teaching` (IN `p_UserID` SMALLINT, IN `p_CID` TINYINT)   BEGIN
    INSERT INTO Teaching (UserID, CID) VALUES (p_UserID, p_CID);
END$$

DROP PROCEDURE IF EXISTS `show_extra_lesson`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `show_extra_lesson` (IN `p_username` CHAR(36))   BEGIN
    SELECT c.CName,c.CNumber,el.ELDate,el.ELTime 
    FROM Users u
    INNER JOIN BelongsTo b ON u.UserID=b.UserID
    INNER JOIN Class c ON c.CID=b.CID
    INNER JOIN ExtraLesson el ON el.CID=c.CID 
    WHERE u.username=p_username AND el.ELDate>=CURDATE();
END$$

DROP PROCEDURE IF EXISTS `update_class`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_class` (IN `p_CID` TINYINT, IN `p_CName` CHAR(1), IN `p_SchoolYear` TINYINT, IN `p_CNumber` TINYINT, IN `p_AvailableSeats` TINYINT, IN `p_CDays` CHAR(7), IN `p_TimeForFirstDay` CHAR(8), IN `p_TimeForSecondDay` CHAR(8), IN `p_NextYears` TINYINT)   BEGIN
    UPDATE Class
    SET
        CName = p_CName,
        SchoolYear = p_SchoolYear,
        CNumber = p_CNumber,
        AvailableSeats = p_AvailableSeats,
        CDays = p_CDays,
        TimeForFirstDay = p_TimeForFirstDay,
        TimeForSecondDay = p_TimeForSecondDay,
        NextYears = p_NextYears
    WHERE
        CID = p_CID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `belongsto`
--

DROP TABLE IF EXISTS `belongsto`;
CREATE TABLE `belongsto` (
  `UserID` smallint(6) NOT NULL,
  `CID` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `belongsto`
--

INSERT INTO `belongsto` (`UserID`, `CID`) VALUES
(9, 25),
(9, 26),
(9, 27),
(10, 10),
(10, 11),
(10, 14),
(13, 28),
(13, 29),
(13, 30),
(17, 31),
(17, 32),
(17, 33),
(20, 1),
(20, 2),
(20, 5),
(22, 19),
(22, 21),
(22, 22);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `CID` tinyint(4) NOT NULL,
  `CName` char(1) NOT NULL,
  `SchoolYear` tinyint(4) NOT NULL,
  `CNumber` tinyint(4) NOT NULL,
  `AvailableSeats` tinyint(4) NOT NULL,
  `CDays` char(7) NOT NULL,
  `TimeForFirstDay` char(8) NOT NULL,
  `TimeForSecondDay` char(8) NOT NULL,
  `NextYears` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`CID`, `CName`, `SchoolYear`, `CNumber`, `AvailableSeats`, `CDays`, `TimeForFirstDay`, `TimeForSecondDay`, `NextYears`) VALUES
(1, 'M', 5, 1, 10, '1001000', '15301700', '15301700', 1),
(2, 'P', 5, 1, 10, '1001000', '17301900', '17301900', 1),
(3, 'M', 5, 2, 10, '1001000', '19002030', '19002030', 1),
(4, 'P', 5, 2, 10, '0100100', '15001630', '15001630', 1),
(5, 'C', 5, 1, 10, '0100100', '16301800', '16301800', 1),
(6, 'C', 5, 2, 10, '0100100', '18001930', '18001930', 1),
(7, 'C', 5, 3, 8, '0010010', '15001700', '10001100', 1),
(8, 'P', 5, 3, 8, '0010010', '17001900', '12001300', 1),
(9, 'M', 5, 3, 8, '0010010', '19002000', '08001000', 1),
(10, 'M', 6, 1, 10, '1001000', '17301900', '17301900', 1),
(11, 'P', 6, 1, 10, '1001000', '19002030', '19002030', 1),
(12, 'M', 6, 2, 10, '1001000', '20302200', '20302200', 1),
(13, 'P', 6, 2, 10, '0100100', '16301800', '16301800', 1),
(14, 'C', 6, 1, 10, '0100100', '21002230', '21002230', 1),
(15, 'C', 6, 2, 10, '0100100', '19302100', '19302100', 1),
(16, 'C', 6, 3, 10, '0010010', '17001900', '12001300', 1),
(17, 'P', 6, 3, 10, '0010010', '19002100', '14001500', 1),
(18, 'M', 6, 3, 10, '0010010', '21002200', '10001200', 1),
(19, 'C', 4, 1, 15, '1001000', '17301900', '17301900', 1),
(20, 'C', 4, 2, 15, '1001000', '19002030', '19002030', 1),
(21, 'P', 4, 1, 15, '1001000', '20302200', '20302200', 1),
(22, 'M', 4, 1, 15, '0100100', '16301800', '16301800', 1),
(23, 'M', 4, 2, 15, '0100100', '18001930', '18001930', 1),
(24, 'P', 4, 2, 15, '0100100', '19302100', '19302100', 1),
(25, 'M', 1, 1, 15, '1001000', '15001630', '15001630', 1),
(26, 'P', 1, 1, 15, '1001000', '17001830', '17001830', 1),
(27, 'C', 1, 1, 15, '0100100', '15001630', '15001630', 1),
(28, 'P', 2, 1, 15, '1001000', '15001630', '15001630', 1),
(29, 'M', 2, 1, 15, '1001000', '17001830', '17001830', 1),
(30, 'C', 2, 1, 15, '0100100', '17001830', '17001830', 1),
(31, 'C', 3, 1, 15, '1001000', '15001630', '15001630', 1),
(32, 'P', 3, 1, 15, '0100100', '15001630', '15001630', 1),
(33, 'M', 3, 1, 15, '0100100', '17001830', '17001830', 1);

-- --------------------------------------------------------

--
-- Table structure for table `extralesson`
--

DROP TABLE IF EXISTS `extralesson`;
CREATE TABLE `extralesson` (
  `ELDate` date NOT NULL,
  `ELTime` char(8) NOT NULL,
  `CID` tinyint(4) NOT NULL,
  `ELID` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extralesson`
--

INSERT INTO `extralesson` (`ELDate`, `ELTime`, `CID`, `ELID`) VALUES
('2023-12-10', '10001100', 2, 1),
('2024-01-21', '09001000', 11, 2),
('2024-01-14', '08001000', 21, 3),
('2024-02-11', '10001100', 1, 4),
('2024-02-25', '12001300', 10, 5),
('2024-02-04', '14001500', 22, 6),
('2024-03-24', '13001430', 22, 7),
('2024-04-28', '16001700', 5, 8),
('2024-04-07', '13001500', 14, 9),
('2024-05-05', '09001030', 19, 10);

-- --------------------------------------------------------

--
-- Table structure for table `teaching`
--

DROP TABLE IF EXISTS `teaching`;
CREATE TABLE `teaching` (
  `UserID` smallint(6) NOT NULL,
  `CID` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching`
--

INSERT INTO `teaching` (`UserID`, `CID`) VALUES
(2, 9),
(2, 18),
(3, 1),
(3, 3),
(3, 10),
(3, 12),
(3, 22),
(3, 23),
(4, 5),
(4, 6),
(4, 7),
(4, 14),
(4, 15),
(4, 16),
(4, 19),
(4, 20),
(5, 2),
(5, 4),
(5, 8),
(5, 11),
(5, 13),
(5, 17),
(5, 21),
(5, 24),
(6, 25),
(6, 29),
(6, 33),
(7, 27),
(7, 30),
(7, 31),
(8, 26),
(8, 28),
(8, 32);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `UserID` smallint(6) NOT NULL,
  `Fname` char(36) NOT NULL,
  `Lname` char(36) NOT NULL,
  `username` char(36) NOT NULL,
  `Upassword` char(72) NOT NULL,
  `UType` tinyint(4) NOT NULL,
  `isEnrolled` tinyint(4) NOT NULL,
  `Phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Fname`, `Lname`, `username`, `Upassword`, `UType`, `isEnrolled`, `Phone`) VALUES
(1, 'Julios', 'Fotiou', 'JFoti1', '$2y$10$yQJG.pkGc3Qc1YxqTlVRDe4zDPFKL0eKyTVtmSKLrR.Gj598/Z3H2', 2, 1, 96833706),
(2, 'Andreas', 'Hadjoullis', 'AHadj1', '$2y$10$aO5vkcn9pFPM2Gljr/ONO.ymS0Z8lss/H2NPnW3n6aML/4IDLdyiu', 1, 1, 99630474),
(3, 'Pyrros', 'Bratskas', 'PBrat1', '$2y$10$G4NNPH/1sjcqhzm26J9N6OnRpUW/i8QdRiu.jpOEMxmPNKeAgnmBK', 1, 1, 99999999),
(4, 'Eleni', 'Constantinou', 'ECons1', '$2y$10$Cr.hvbgsbsWbOxU.AKD34eupgzxdXVn3R4eEHyYJJC5ijgEj.VZPS', 1, 1, 99999998),
(5, 'Christoforos', 'Panayiotou', 'CPana1', '$2y$10$bU2bpOedzqw0nRGrhzAik.57WefC93mQnW/iDtaBdYAjRdaLd6Qom', 1, 1, 99999997),
(6, 'Panayiotis', 'Charitonos', 'PChar1', '$2y$10$6mM5674WCnKlWFmIq3SLkedHK0GUEouo6cM4krpuKKVHE6SNqyUXG', 1, 1, 99797984),
(7, 'Christos', 'Iosif', 'CIosi1', '$2y$10$5adiRwfsWgGu.s/f6QRMAORPGdURIs2hMGMeAfjQhXtGhaSoKm.pO', 1, 1, 99013514),
(8, 'Ioannis', 'Georgiou', 'IGeor1', '$2y$10$jvwkC/OTgXZ5CA3Z.LYSkeu9BMAfihp1JBKq3N8F78yAvbsNbNfKe', 1, 1, 99900853),
(9, 'Georgia', 'Michael', 'GMich1', '$2y$10$07A0d.JYqOR34i8dTQerpe8X8bb28/IHQMjn4JA70ggY.6oqjiq0K', 0, 1, 99999996),
(10, 'Demetris', 'Miro', 'DMiro1', '$2y$10$THVhRw7PPyFtJK8ZhSASKuiqNmLuiDZDer1ImycZR8RWHSGXzdHx2', 0, 1, 96404014),
(11, 'Orestis', 'Miro', 'OMiro1', '$2y$10$T36Vo8XQJrDQXVUuRT3KV.m0FxctZrlqVvbr8qDvkRYfwJ4Q7zm2e', 0, 0, 97745522),
(12, 'Giorgos', 'Michael', 'GMich2', '$2y$10$k6okuxOrhIfZ7OuQvbjFFOC1lUC12mPkrdEizS5uBqQ7jG/FU7FKm', 0, 0, 96562210),
(13, 'George', 'Demetriou', 'GDeme1', '$2y$10$fkYUiqn0f/GO8TF6wyw/TOXdV2Es/4MJ1yDMlpw5qbxZn9ZEq6PgO', 0, 1, 96715021),
(14, 'Demetris', 'Mirozis', 'DMiro2', '$2y$10$UMCOLmbzFdVaJ7lRWYWgH.ONx.tzoROYpL0a7oWl6rCSua6NphYda', 0, 0, 99664521),
(16, 'Zinon', 'Kortas', 'ZKort1', '$2y$10$KhmH4XqEx6xHTbI1mKn4g.u5i.s0d7co.qxjKOW11tDncOG4Ol/.u', 0, 0, 96447788),
(17, 'Kendeas', 'Demetriou', 'KDeme1', '$2y$10$aYaqxzEH9va9mzuCeEH5cO3CJAJ7d3cNK.hX4rY/DhQsHkJHd1nBe', 0, 1, 97874757),
(18, 'Michalis', 'Xydias', 'MXydi1', '$2y$10$itUow2yRKmIOsiNOX6d9J.IIyehCeysmC64PwoHrPIE/C.ysrESRq', 0, 0, 99561232),
(19, 'Nektarios', 'Kolokotronis', 'NKolo1', '$2y$10$iBDs5Z0/nNhdg1CDVO465uLe/8gUdBV1lPcEoBjpJefdmriEinBmK', 0, 0, 96125789),
(20, 'Panayiotis', 'Outopos', 'POuto1', '$2y$10$bluBl0sNAVTUDAAgLejY2eGsqm/Ni/T/mN2UntBsCc/5rxrYPj0eO', 0, 1, 96788963),
(22, 'Christodoulos', 'Evangelou', 'CEvan1', '$2y$10$pnqhLjkVmrE04Y/iudDns.3V1v92zKcXJlk.hfKiFJDkR2/.5Ielu', 0, 1, 99663300),
(23, 'Giannis', 'Kosta', 'GKost1', '$2y$10$Gdar/IiWTIsZXD1XuRMpXufYxWMSq/WI.nrTH6fRhvKlM7NpNqeGy', 0, 0, 96477896);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `belongsto`
--
ALTER TABLE `belongsto`
  ADD PRIMARY KEY (`UserID`,`CID`),
  ADD KEY `FK_BT_CLASS` (`CID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `extralesson`
--
ALTER TABLE `extralesson`
  ADD PRIMARY KEY (`ELID`),
  ADD KEY `FK_EL_CLASS` (`CID`);

--
-- Indexes for table `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`UserID`,`CID`),
  ADD KEY `FK_T_CLASS` (`CID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UNQ_USRNM` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `CID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `extralesson`
--
ALTER TABLE `extralesson`
  MODIFY `ELID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `belongsto`
--
ALTER TABLE `belongsto`
  ADD CONSTRAINT `FK_BT_CLASS` FOREIGN KEY (`CID`) REFERENCES `class` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BT_USER` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `extralesson`
--
ALTER TABLE `extralesson`
  ADD CONSTRAINT `FK_EL_CLASS` FOREIGN KEY (`CID`) REFERENCES `class` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teaching`
--
ALTER TABLE `teaching`
  ADD CONSTRAINT `FK_T_CLASS` FOREIGN KEY (`CID`) REFERENCES `class` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_T_USER` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
