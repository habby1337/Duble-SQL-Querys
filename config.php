<?php


// Dati per la conessione al db
#region Dichiarazione accessi al db
$login['host'] = 'localhost'; //Indirizzo del database
$login['username'] = 'query_fattura'; //Nome utente per accedere al db
$login['password'] = 'oH1gWAkfnTDZPczq'; //passwrod per accedere al db
$login['dbname'] = 'fattura'; //Nome del db dove si trovano le tabelle
#endregion Dichiarazione accessi al db


// Creal la connessione
$conn = new mysqli($login['host'], $login['username'], $login['password'], $login['dbname']);
// Controlla la connessione
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
