<?php
$table = 'Pets';
$keys = ['PetID'];
$columns = ['Name', 'Age', 'Street', 'City', 'ZipCode', 'State', 'TypeofPet'];
$required = ['Name'];
$numbers = ['Age'];
require 'crud.php';
