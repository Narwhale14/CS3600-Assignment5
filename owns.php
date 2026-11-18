<?php
$table = 'Owns';
$keys = ['PetID', 'Year', 'OID'];
$columns = ['PetID', 'Year', 'OID', 'PetAgeatOwnership', 'PricePaid'];
$required = ['PetID', 'Year', 'OID'];
$numbers = ['PetID', 'Year', 'OID', 'PetAgeatOwnership', 'PricePaid'];
require 'crud.php';
