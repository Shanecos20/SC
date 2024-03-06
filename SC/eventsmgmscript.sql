-- Set the SQL mode and time zone to avoid unexpected behaviors
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Create the database (if not exists) with the new collation
CREATE DATABASE IF NOT EXISTS `eventsmgm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `eventsmgm`;

-- Drop existing tables if they exist to avoid conflicts
DROP TABLE IF EXISTS `competitors`, `db_modifications`, `events`, `event_occurrences`, `users`, `venues`;

-- Table creation for `db_modifications` with new collation
CREATE TABLE `db_modifications` (
  `modification_id` INT NOT NULL AUTO_INCREMENT,
  `modification_type` VARCHAR(10) DEFAULT NULL,
  `table_modified` VARCHAR(50) DEFAULT NULL,
  `modification_details` TEXT,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`modification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `events` table first with new collation
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` INT NOT NULL AUTO_INCREMENT,
  `event_name` VARCHAR(255) NOT NULL,
  `venue_id` INT DEFAULT NULL,
  `event_date` DATE DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Then, create `competitors` table with the foreign key and new collation
CREATE TABLE IF NOT EXISTS `competitors` (
  `competitor_id` INT NOT NULL AUTO_INCREMENT,
  `competitor_name` VARCHAR(255) NOT NULL,
  `industry` VARCHAR(255) DEFAULT NULL,
  `event_id` INT DEFAULT NULL,
  PRIMARY KEY (`competitor_id`),
  KEY `event_id_fk` (`event_id`),
  CONSTRAINT `fk_competitors_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table creation for `event_occurrences` with a foreign key constraint and new collation
CREATE TABLE `event_occurrences` (
  `event_occurrence_id` INT NOT NULL AUTO_INCREMENT,
  `event_id` INT DEFAULT NULL,
  `sequence_number` INT DEFAULT NULL,
  `event_occurrence_date` DATE DEFAULT NULL,
  PRIMARY KEY (`event_occurrence_id`),
  KEY `event_id_fk` (`event_id`),
  CONSTRAINT `fk_event_occurrences_events` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table creation for `users` with new collation
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table creation for `venues` with new collation
CREATE TABLE `venues` (
  `venue_id` INT NOT NULL AUTO_INCREMENT,
  `venue_name` VARCHAR(255) NOT NULL,
  `venue_location` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial data for each table

-- Events
INSERT INTO `events` (`event_id`, `event_name`, `venue_id`, `event_date`) VALUES
(103, 'Art Exhibition: Modern Masterpieces', 3, '2023-09-12'),
(101, 'Summer Music Festival', 1, '2023-07-15'),
(102, 'Tech Expo 2023', 2, '2023-10-08'),
(104, 'Food and Wine Tasting', 4, '2023-08-02'),
(105, 'Sports Championship Finals', 5, '2023-11-16');

-- Competitors
INSERT INTO `competitors` (`competitor_id`, `competitor_name`, `industry`, `event_id`) VALUES
(1, 'Artistic Creations Inc.', 'Art & Design', 103),
(2, 'Music Innovators', 'Entertainment', 101),
(3, 'Tech Innovations Ltd.', 'Technology', 102),
(4, 'Gourmet Delights Co.', 'Food & Beverage', 104),
(5, 'Sports Gear Pro', 'Sports & Fitness', 105);

-- Event Occurrences
INSERT INTO `event_occurrences` (`event_occurrence_id`, `event_id`, `sequence_number`, `event_occurrence_date`) VALUES
(1001, 101, 1, '2023-07-15');

-- Users
INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'root', '$2y$10$YXhkfzNUUQDRgO0gwicGO.rtle9.5lBRIMdHEkObF.cdQJf596vLW', NULL, '2023-12-01 12:38:04'),
(7, 'admin', '$2y$10$RIsi.VH1G3z/kkwwAv3fGeRx2sg.Klxh3wVeZrcI9wg4G8dJOmdNO', NULL, '2023-12-07 14:30:00');

-- Venues
INSERT INTO `venues` (`venue_id`, `venue_name`, `venue_location`) VALUES
(3, 'The Skyline Rooftop', 'Chicago, IL'),
(2, 'The Garden Pavilion', 'Los Angeles, CA'),
(1, 'The Grand Ballroom', 'New York City, NY'),
(4, 'The Lakeside Retreat', 'Seattle, WA'),
(5, 'The Historic Manor', 'Charleston, SC'),
(6, 'The Sports Arena', 'Dallas, TX'),
(7, 'The Outdoor Amphitheater', 'Atlanta, GA');

-- Define triggers for logging modifications
-- Note: Triggers for each table are created with the DELIMITER statement for MySQL command line or MySQL Workbench compatibility. 
--       For environments that do not require DELIMITER (e.g., phpMyAdmin), you may remove the DELIMITER lines.

-- Triggers for `competitors`
DELIMITER $$
CREATE TRIGGER `log_competitors_delete` AFTER DELETE ON `competitors`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Competitors', CONCAT('Deleted Competitor with ID ', OLD.competitor_id));
END$$
CREATE TRIGGER `log_competitors_insert` AFTER INSERT ON `competitors`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Competitors', CONCAT('Inserted Competitor with ID ', NEW.competitor_id));
END$$
CREATE TRIGGER `log_competitors_update` AFTER UPDATE ON `competitors`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Competitors', CONCAT('Updated Competitor with ID ', NEW.competitor_id));
END$$
DELIMITER ;

-- Triggers for `events`
DELIMITER $$

CREATE TRIGGER `log_events_insert` AFTER INSERT ON `events`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (modification_type, table_modified, modification_details, timestamp)
    VALUES ('Insert', 'Events', CONCAT('Inserted Event with ID ', NEW.event_id), NOW());
END$$

CREATE TRIGGER `log_events_update` AFTER UPDATE ON `events`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (modification_type, table_modified, modification_details, timestamp)
    VALUES ('Update', 'Events', CONCAT('Updated Event with ID ', NEW.event_id), NOW());
END$$

CREATE TRIGGER `log_events_delete` AFTER DELETE ON `events`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (modification_type, table_modified, modification_details, timestamp)
    VALUES ('Delete', 'Events', CONCAT('Deleted Event with ID ', OLD.event_id), NOW());
END$$

DELIMITER ;

-- Triggers for `event_occurrences`
DELIMITER $$

CREATE TRIGGER `log_event_occurrences_delete` AFTER DELETE ON `event_occurrences`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Event Occurrences', CONCAT('Deleted Event Occurrence with ID ', OLD.event_occurrence_id));
END$$

CREATE TRIGGER `log_event_occurrences_insert` AFTER INSERT ON `event_occurrences`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Event Occurrences', CONCAT('Inserted Event Occurrence with ID ', NEW.event_occurrence_id));
END$$

CREATE TRIGGER `log_event_occurrences_update` AFTER UPDATE ON `event_occurrences`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Event Occurrences', CONCAT('Updated Event Occurrence with ID ', NEW.event_occurrence_id));
END$$

DELIMITER ;

-- Triggers for `venues`
DELIMITER $$

CREATE TRIGGER `log_venues_delete` AFTER DELETE ON `venues`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Venues', CONCAT('Deleted Venue with ID ', OLD.venue_id));
END$$

CREATE TRIGGER `log_venues_insert` AFTER INSERT ON `venues`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Venues', CONCAT('Inserted Venue with ID ', NEW.venue_id));
END$$

CREATE TRIGGER `log_venues_update` AFTER UPDATE ON `venues`
FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Venues', CONCAT('Updated Venue with ID ', NEW.venue_id));
END$$

DELIMITER ;

-- Finalize the setup
COMMIT;

