<?php
require_once '../config/database.php';
unset($_SESSION['is_admin']); session_regenerate_id(true);
header('Location: login.php'); exit;
