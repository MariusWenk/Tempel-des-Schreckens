<?php
$conn = new mysqli("localhost", "root", "");
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

mysqli_query($conn, "DROP DATABASE tempeldesschreckens");

if($conn->query("CREATE DATABASE tempeldesschreckens") === TRUE){
    echo "Databse created succesfully";
} else{
    echo "Error creating database: ".$conn->connect_error;
}

include "sqlConnect.php";

mysqli_query($connect, "CREATE TABLE rooms (RoomID int NOT NULL, Language varchar(255), Initialisiert boolean, PRIMARY KEY (RoomID));");
mysqli_query($connect, "CREATE TABLE players (RoomID int NOT NULL, PlayerID int NOT NULL, Name varchar(255) NOT NULL, Status varchar(255), Role varchar(255), SpielerMenu boolean, LinkMenu boolean, AmZug boolean, CardsSelected boolean, Leer int, Gold int, Feuerfalle int, CONSTRAINT FinalID PRIMARY KEY (RoomID, PlayerID));");
mysqli_query($connect, "CREATE TABLE roles (Spielerzahl int NOT NULL, Abenteurer int, Waechterinnen int, PRIMARY KEY (Spielerzahl));");
mysqli_query($connect, "CREATE TABLE doors (Spielerzahl int NOT NULL, Leer int, Gold int, Feuerfallen int, PRIMARY KEY (Spielerzahl));");
mysqli_query($connect, "CREATE TABLE game (RoomID int NOT NULL, LeerGen int, GoldGen int, FeuerfallenGen int, LeerDisc int, GoldDisc int, FeuerfallenDisc int, CardsPlayed int, SpielerZahl int, Runde int, GameMenu int, KarteSelected varchar(255), KarteSelectedPosition int, Winner varchar(255), PRIMARY KEY (RoomID));");

mysqli_query($connect,"INSERT INTO rooms VALUES (0, 'deutsch', false)");

mysqli_query($connect,"INSERT INTO roles VALUES (3, 2, 2)");
mysqli_query($connect,"INSERT INTO roles VALUES (4, 3, 2)");
mysqli_query($connect,"INSERT INTO roles VALUES (5, 3, 2)");
mysqli_query($connect,"INSERT INTO roles VALUES (6, 4, 2)");
mysqli_query($connect,"INSERT INTO roles VALUES (7, 5, 3)");
mysqli_query($connect,"INSERT INTO roles VALUES (8, 6, 3)");
mysqli_query($connect,"INSERT INTO roles VALUES (9, 6, 3)");
mysqli_query($connect,"INSERT INTO roles VALUES (10, 7, 4)");

mysqli_query($connect,"INSERT INTO doors VALUES (3, 8, 5, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (4, 12, 6, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (5, 16, 7, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (6, 20, 8, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (7, 26, 7, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (8, 30, 8, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (9, 34, 9, 2)");
mysqli_query($connect,"INSERT INTO doors VALUES (10, 37, 10, 3)");


$conn -> close();
$connect->close();
?>