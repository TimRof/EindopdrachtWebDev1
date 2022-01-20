<?php
require __DIR__ . '../../../dbconfig.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
try {
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($type == "mysql") {
    // create database
    try {
        echo "Creating Database...<br><br>";
        $connection = new PDO("$type:host=$servername", $username, $password);
        $sql = 'CREATE DATABASE appointment_manager';
        // set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->exec($sql);
        echo "Success: Database added! <br><br><br>";
    } catch (PDOException $e) {
        echo "Failed: " . $e->getMessage() . "<br><br><br>";
    }
}

echo "*** Adding tables ***<br><br>";
// create appointments table
try {
    echo "Creating Table: appointments...<br>";
    $sql = "CREATE TABLE appointments (
        id SERIAL PRIMARY KEY,
        user_id int NOT NULL,
        timeslot int NOT NULL,
        start timestamp NOT NULL,
        end timestamp NOT NULL,
        type varchar(255) NOT NULL
      )";
    $connection->exec($sql);
    echo "Success: Table added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

// create types table
try {
    echo "Creating Table: types...<br>";
    $sql = "CREATE TABLE types (
        id SERIAL PRIMARY KEY,
        type varchar(255) NOT NULL,
        price decimal(10,2) NOT NULL
      )";
    $connection->exec($sql);
    echo "Success: Table added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

// create usersbasic table
try {
    echo "Creating Table: usersbasic...<br>";
    $sql = "CREATE TABLE usersbasic (
        id SERIAL PRIMARY KEY,
        name varchar(50) NOT NULL,
        email varchar(255) NOT NULL,
        password_hash varchar(255) NOT NULL,
        admin int DEFAULT NULL
      )";
    $connection->exec($sql);
    echo "Success: Table added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

echo "*** Creating Indexes ***<br><br>";
// create appointments indexes
try {
    echo "Creating Indexes: appointments...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "ALTER TABLE appointments
    ADD PRIMARY KEY (id),
    ADD KEY user_id (user_id);";
    $connection->exec($sql);
    echo "Success: Indexes added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

// create types indexes
try {
    echo "Creating Indexes: types...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "ALTER TABLE types
    ADD PRIMARY KEY (id);";
    $connection->exec($sql);
    echo "Success: Indexes added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

// create usersbasic indexes
try {
    echo "Creating Indexes: usersbasic...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "ALTER TABLE usersbasic
    ADD PRIMARY KEY (id),
    ADD UNIQUE KEY email (email);";
    $connection->exec($sql);
    echo "Success: Indexes added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}
echo "*** Adding Constraints ***<br><br>";

// create constraint
try {
    echo "Creating constraint...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "ALTER TABLE appointments
    ADD CONSTRAINT appointments_ibfk_1 FOREIGN KEY (user_id) REFERENCES usersbasic (id);
  COMMIT;";
    $connection->exec($sql);
    echo "Success: Indexes added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

echo "*** Adding data ***<br><br>";
// adding types data
try {
    echo "Adding data: types...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "INSERT INTO types (id, type, price) VALUES
    (1, 'Haircut', '34.00'),
    (2, 'Wash & Haircut', '36.00'),
    (3, 'Clippers', '20.00'),
    (4, 'Wash', '9.50');";
    $connection->exec($sql);
    echo "Success: Data added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}
// adding usersbasic data
try {
    echo "Adding data: usersbasic...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "INSERT INTO usersbasic (id, name, email, password_hash, admin) VALUES
    (1, 'admin', 'admin@admin.admin', '$2y$10$DKLbcAVXyfrbiDfyPxxMzeA5Ulg1gTJwnfmLXpcjYucY3Izu34tzW', 1),
    (16, 'Mark de Haan', 'Mark.deHaan@inholland.nl', '$2y$10$NzFniVgWB3Dm8duJrhdUnOnG8PlgFQdLGOFS1fKdJVY2HjWCQV4eS', NULL);";
    $connection->exec($sql);
    echo "Success: Data added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}
// adding usersbasic data
try {
    echo "Adding data: appointments...<br>";
    $connection = new PDO("$type:host=$servername;dbname=$database", $username, $password);
    $sql = "INSERT INTO appointments (id, user_id, timeslot, start, end, type) VALUES
    (20, 16, 1, '2022-01-26 10:00:00', '2022-01-26 10:45:00', 'Clippers');";
    $connection->exec($sql);
    echo "Success: Data added! <br><br><br>";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage() . "<br>";
}

echo "Done!";
