<?php 

$task = 'CREATE TABLE task (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name char(255),
    description text,
    priority char(255),
    status char(255),
    author INT(11),
    executor INT(11),
    start_date date,
    end_date date,
    update_date	datetime
)';

$user = 'CREATE TABLE task (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    forename char(255),
    surname char(255),
    patronymic char(255),
    login char(255),
    password char(255),
    supervisor INT(11)
)';