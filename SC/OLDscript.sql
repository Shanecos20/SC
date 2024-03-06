CREATE TABLE Venues (
    venue_id INT AUTO_INCREMENT PRIMARY KEY,
    venue_name VARCHAR(255) NOT NULL,
    venue_location VARCHAR(255) NOT NULL
);

CREATE TABLE Events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    venue_id INT,
    event_date DATE,
    
    FOREIGN KEY (venue_id) REFERENCES Venues(venue_id)
);


CREATE TABLE Event_Occurrences (
    event_occurrence_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    sequence_number INT,
    event_occurrence_date DATETIME,

    FOREIGN KEY (event_id) REFERENCES Events(event_id)
);


CREATE TABLE Competitors (
    competitor_id INT AUTO_INCREMENT PRIMARY KEY,
    competitor_name VARCHAR(255) NOT NULL,
    industry VARCHAR(255),
    event_id INT,

    FOREIGN KEY (event_id) REFERENCES Events(event_id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE db_modifications (
  modification_id int NOT NULL AUTO_INCREMENT,
  modification_type varchar(10) DEFAULT NULL,
  table_modified varchar(50) DEFAULT NULL,
  modification_details text,
  timestamp timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`modification_id`)
)

DROP TRIGGER IF EXISTS `log_venues_delete`;
DELIMITER $$
CREATE TRIGGER `log_venues_delete` AFTER DELETE ON `venues` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Venues', CONCAT('Deleted Venue with ID ', OLD.venue_id));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `log_venues_insert`;
DELIMITER $$
#
CREATE TRIGGER `log_venues_insert` AFTER INSERT ON `venues` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Venues', CONCAT('Inserted Venue with ID ', NEW.venue_id));
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `log_venues_update`;
DELIMITER $$
CREATE TRIGGER `log_venues_update` AFTER UPDATE ON `venues` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Venues', CONCAT('Updated Venue with ID ', NEW.venue_id));
END
$$
DELIMITER ;
COMMIT;

-- Delete trigger for Competitors
DELIMITER $$
DROP TRIGGER IF EXISTS `log_competitors_delete`;
CREATE TRIGGER `log_competitors_delete` AFTER DELETE ON `competitors` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Competitors', CONCAT('Deleted Competitor with ID ', OLD.competitor_id));
END
$$
DELIMITER ;

-- Insert trigger for Competitors
DELIMITER $$
DROP TRIGGER IF EXISTS `log_competitors_insert`;
CREATE TRIGGER `log_competitors_insert` AFTER INSERT ON `competitors` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Competitors', CONCAT('Inserted Competitor with ID ', NEW.competitor_id));
END
$$
DELIMITER ;

-- Update trigger for Competitors
DELIMITER $$
DROP TRIGGER IF EXISTS `log_competitors_update`;
CREATE TRIGGER `log_competitors_update` AFTER UPDATE ON `competitors` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Competitors', CONCAT('Updated Competitor with ID ', NEW.competitor_id));
END
$$
DELIMITER ;


-- Delete trigger for Events
DELIMITER $$
DROP TRIGGER IF EXISTS `log_events_delete`;
CREATE TRIGGER `log_events_delete` AFTER DELETE ON `events` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Events', CONCAT('Deleted Event with ID ', OLD.event_id));
END
$$
DELIMITER ;

-- Insert trigger for Events
DELIMITER $$
DROP TRIGGER IF EXISTS `log_events_insert`;
CREATE TRIGGER `log_events_insert` AFTER INSERT ON `events` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Events', CONCAT('Inserted Event with ID ', NEW.event_id));
END
$$
DELIMITER ;

-- Update trigger for Events
DELIMITER $$
DROP TRIGGER IF EXISTS `log_events_update`;
CREATE TRIGGER `log_events_update` AFTER UPDATE ON `events` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Events', CONCAT('Updated Event with ID ', NEW.event_id));
END
$$
DELIMITER ;

-- Delete trigger for Event Occurrences
DELIMITER $$
DROP TRIGGER IF EXISTS `log_event_occurrences_delete`;
CREATE TRIGGER `log_event_occurrences_delete` AFTER DELETE ON `event_occurrences` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Delete', 'Event Occurrences', CONCAT('Deleted Event Occurrence with ID ', OLD.event_occurrence_id));
END
$$
DELIMITER ;

-- Insert trigger for Event Occurrences
DELIMITER $$
DROP TRIGGER IF EXISTS `log_event_occurrences_insert`;
CREATE TRIGGER `log_event_occurrences_insert` AFTER INSERT ON `event_occurrences` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Insert', 'Event Occurrences', CONCAT('Inserted Event Occurrence with ID ', NEW.event_occurrence_id));
END
$$
DELIMITER ;

-- Update trigger for Event Occurrences
DELIMITER $$
DROP TRIGGER IF EXISTS `log_event_occurrences_update`;
CREATE TRIGGER `log_event_occurrences_update` AFTER UPDATE ON `event_occurrences` FOR EACH ROW BEGIN
    INSERT INTO db_modifications (timestamp, modification_type, table_modified, modification_details)
    VALUES (NOW(), 'Update', 'Event Occurrences', CONCAT('Updated Event Occurrence with ID ', NEW.event_occurrence_id));
END
$$
DELIMITER ;
