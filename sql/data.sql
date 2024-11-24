CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    details TEXT,
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


CREATE TABLE game_developer_applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(50),
    address VARCHAR(255),
    state VARCHAR(100),
    nationality VARCHAR(100),
    years_of_experience INT,
    programming_languages VARCHAR(255),
    favorite_game_engine VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO game_developer_applicants (first_name, last_name, email, gender, address, state, nationality, years_of_experience, programming_languages, favorite_game_engine)
VALUES 
('Andrei', 'Santos', 'andrei.santos@example.com', 'Male', '123 Rizal St', 'Metro Manila', 'Philippines', 5, 'C++, Java', 'Unity'),
('Bianca', 'Alonzo', 'bianca.alonzo@example.com', 'Female', '456 Quezon Ave', 'Cebu', 'Philippines', 3, 'Python, JavaScript', 'Unreal Engine'),
('Carlos', 'Dela Cruz', 'carlos.delacruz@example.com', 'Male', '789 Bonifacio St', 'Davao', 'Philippines', 4, 'C#, HTML, CSS', 'Godot'),
('Diana', 'Reyes', 'diana.reyes@example.com', 'Female', '1011 Aguinaldo St', 'Iloilo', 'Philippines', 2, 'JavaScript, PHP', 'Unity'),
('Elijah', 'Garcia', 'elijah.garcia@example.com', 'Male', '1213 Mabini St', 'Baguio', 'Philippines', 6, 'C++, Python', 'CryEngine'),
('Fiona', 'Castillo', 'fiona.castillo@example.com', 'Female', '1415 Luna St', 'Batangas', 'Philippines', 1, 'Java, Swift', 'GameMaker'),
('Gabriel', 'Morales', 'gabriel.morales@example.com', 'Male', '1617 Rizal Ave', 'Laguna', 'Philippines', 7, 'C#, C++', 'Unity'),
('Hannah', 'Villanueva', 'hannah.villanueva@example.com', 'Female', '1819 San Juan St', 'Pampanga', 'Philippines', 3, 'Python, Ruby', 'Unreal Engine'),
('Ian', 'Bautista', 'ian.bautista@example.com', 'Male', '2021 Del Pilar St', 'Zamboanga', 'Philippines', 5, 'JavaScript, TypeScript', 'Godot'),
('Jasmine', 'Pineda', 'jasmine.pineda@example.com', 'Female', '2223 Santos St', 'Cavite', 'Philippines', 4, 'C#, HTML, CSS', 'Unity'),
('Kevin', 'Mendoza', 'kevin.mendoza@example.com', 'Male', '2425 Alabang St', 'Quezon City', 'Philippines', 2, 'C++, Java', 'CryEngine'),
('Lara', 'Santiago', 'lara.santiago@example.com', 'Female', '2627 Villanueva St', 'Antipolo', 'Philippines', 8, 'Python, C#', 'Unreal Engine'),
('Mark', 'Cruz', 'mark.cruz@example.com', 'Male', '2829 Garcia St', 'Marikina', 'Philippines', 3, 'Java, Swift', 'GameMaker'),
('Nina', 'Ocampo', 'nina.ocampo@example.com', 'Female', '3031 Ramos St', 'San Fernando', 'Philippines', 6, 'C++, Python', 'Unity'),
('Oliver', 'Tan', 'oliver.tan@example.com', 'Male', '3233 De Jesus St', 'Taguig', 'Philippines', 4, 'JavaScript, C#', 'Godot');