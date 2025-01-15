<?php
$conn = mysqli_connect("localhost","root","","simple_pos");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}