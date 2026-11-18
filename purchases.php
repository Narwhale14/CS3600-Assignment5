<?php
$table = 'Purchases';
$keys = ['OID', 'FoodID', 'PetID', 'Month', 'Year'];
$columns = ['OID', 'FoodID', 'PetID', 'Month', 'Year', 'Quantity'];
$required = ['OID', 'FoodID', 'PetID', 'Month', 'Year'];
$numbers = ['OID', 'FoodID', 'PetID', 'Year', 'Quantity'];
require 'crud.php';
