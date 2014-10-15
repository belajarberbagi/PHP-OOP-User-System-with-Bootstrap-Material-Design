<?php
/**
 * Created by Chris on 10/8/2014 11:20 PM.
 */

//FizzBuzz Test
$table = 'users';
$items = array('id', 'name', 'username');
$order = 'date DESC';
$limit = 10;


    $set = '';
    $x = 1;

    foreach($items as $item) {
        $set .= "{$item}";
        if($x < count ($items)) {
            $set .= ', ';
        }
        $x++;
    }

echo 'SELECT ' . $set . ' FROM ' .$table . ' ORDER BY ' . $order . ' LIMIT ' . $limit;