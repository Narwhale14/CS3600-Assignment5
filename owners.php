<?php
$table = 'Owners';
$keys = ['OID'];
$columns = ['LastName', 'Street', 'City', 'ZipCode', 'State', 'Age', 'AnnualIncome'];
$required = ['LastName'];
$numbers = ['Age', 'AnnualIncome'];
require 'crud.php';
