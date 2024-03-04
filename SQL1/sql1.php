<?php
$conn = connessione();
if (!controlloConnessione($conn))
    return;

creaDatabase($conn,"nomeDatabase");

$conn->select_db($DB);

creaTabella($conn,"Customers (
    CustomerID      INT AUTO_INCREMENT PRIMARY KEY,
    Address         VARCHAR(30) NOT NULL,
    CustomerName    VARCHAR(30) NOT NULL,
    City            VARCHAR(30) NOT NULL,
    PostalCode      INT,
    Country         VARCHAR(30) NOT NULL);");

// Aggiunnta del vincolo di Foreign Key  (Collegamento tra Customers e Orders)
$SQL =
    "ALTER TABLE Orders
 ADD CONSTRAINT FK_CustomerID
 FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID);";

if ($conn->query($SQL)) {
    echo "Vincolo aggiunto con successo!<br>";
} else {
    echo "Crazione Vincolop fallito:<br>" . mysql_error();
}
$conn->close();

/*
    Inserimenti da scrivere direttamente in phpMyAdmin
INSERT INTO Customers (Address, CustomerName, City, PostalCode, Country)
VALUES
    ('123 Main St', 'John Doe', 'Seattle', 98101, 'USA'),
    ('456 Elm St', 'Jane Smith', 'New York', 10001, 'USA');
   
INSERT INTO Orders (CustomerID, EmployeeID, ShipperID, PostalCode)
VALUES
    (1, 101, 201, 98101),
    (1, 102, 202, 10001);
*/

function connessione()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DB = "W3School";
    // Crea  oggetto di connessione
    $conn = new mysqli($servername, $username, $password);

    // Controlla connessione
    if ($conn->connect_error)
        echo "Connessione non trovata!<br>";
    else
        echo "Connessione trovata!<br>";

    return $conn;
}

function controlloConnessione($conn)
{
    if ($conn->connect_error) {
        echo "Connesione non trovata!<br>";
        return true;
    } else {
        echo "Connessione non trovata!<br>";
        return false;
    }
}

function creaDatabase($conn, $nomeDB)
{
    $sql = 'CREATE DATABASE ' . $nomeDB;
    if (mysqli_query($conn, $sql))
        echo "Database creato con successo!<br>";
    else
        echo 'Errore nella creazione del database: ' . mysqli_error($conn) . "<br>";
}

function creaTabella($conn,$query)
{
    $SQL = "CREATE TABLE $query";
    $conn->query($SQL);
    return $conn;
}