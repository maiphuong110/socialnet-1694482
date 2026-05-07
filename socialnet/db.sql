
CREATE DATABASE IF NOT EXISTS socialnet;
USE socialnet;



DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
    `id`          INT NOT NULL AUTO_INCREMENT,
    `username`    VARCHAR(50) NOT NULL,
    `fullname`    VARCHAR(100) NOT NULL,
    `password`    VARCHAR(255) NOT NULL, -- Hashed with Bcrypt
    `description` TEXT,
    `profile_pic` VARCHAR(255) DEFAULT 'default.png',
    
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;





INSERT INTO `account` (`username`, `fullname`, `password`, `description`, `profile_pic`) 
VALUES 
('admin', 'Mai Phuong Bui', '$2y$10$gMwyk4IdyZitWCwjGLCuVuEzQryLKNq6ZNByKXxxBBxQivPYujqpm', 'i eat kids', '1778185458_dog.jpg'),
('ngananh', 'Ngan Anh', '$2y$10$0s0.F4ZEo1rNrUzBJcaGGukm8uYmWWSymog/ql5vZcf8QPOvRwhxG', 'Ngan Anh does not eat kids', '1778185615_huh.jpg'),
('damquangtrung', 'Dam Quang Trung', '$2y$10$rcmmXyhJJUkDOfVsrqRshe0XS.7SnuIh/k0e56p07Y5ZqmsroeU3u', 'i dont eat kids', '1778185436_hardestanimals.jpg'),
('nhinhinhi', 'Tran Yen Nhi', '$2y$10$GPIwa6LV5fMWG4KYpHKlCOd7KDoQptoui.Lat7XAcs7/KHe4q3qyO', ':)', '1778185567_9c6738bf74f9.jpg'),
('guest', 'Passby', '$2y$10$vqsXXTgXxG4yqGGTWlgc/.Sr/GbuGY1OPJ2ngg4hAsJIEQB.IoOYK', 'nothing here', '1778185830_4c0e9d68ee.jpg');
