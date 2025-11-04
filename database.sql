CREATE DATABASE IF NOT EXISTS `event_system_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `event_system_db`;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `event_date` DATETIME NOT NULL,
  `location` VARCHAR(255),
  `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `tickets_available` INT NOT NULL DEFAULT 100,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `bookings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `booking_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_bookings_user` (`user_id`),
  CONSTRAINT `fk_bookings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  KEY `fk_bookings_event` (`event_id`),
  CONSTRAINT `fk_bookings_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- just some sample data to display on the site.
INSERT INTO `users` (`username`, `email`, `password`) VALUES
('johndoe', 'john@example.com', 'pass123');

INSERT INTO `events` (`name`, `description`, `event_date`, `location`, `price`, `tickets_available`) VALUES
('Summer Music Fest', 'A great lineup of bands.', '2026-07-15 18:00:00', 'Central Park', 75.00, 500),
('Tech Conference 2026', 'The future of tech.', '2026-09-10 09:00:00', 'Convention Center', 250.00, 1000),
('Local Theater Play', 'A new play by local artists.', '2026-06-20 19:30:00', 'Community Theater', 25.00, 80);

INSERT INTO `bookings` (`user_id`, `event_id`, `quantity`) VALUES
(1, 1, 2);
