<?php
$table = 'Foods';
$keys = ['FoodID'];
$columns = ['Name', 'Brand', 'TypeofFood', 'Price', 'ItemWeight', 'ClassofFood'];
$required = ['Name'];
$numbers = ['Price', 'ItemWeight'];
require 'crud.php';
