#!/usr/bin/env php

<?php

require_once( __DIR__ . '/texttable.class.php' );

$data = [
['Weekday', 'Abbrev', 'Initial', 'Position'],
['Sunday', 'Sun', 'S', '0'],
['Monday', 'Mon', 'M', '1'],
['Tuesday', 'Tue', 'T', '2'],
['Wednesday', 'Wed', 'W', '3'],
['Thursday', 'Thu', 'T', '4'],
['Friday', 'Fri', 'F', '5'],
['Saturday', 'Sat', 'S', '6'],
];

echo "  [  Table with header from first row values ]\n";
echo texttable::table( $data, $headertype = 'firstrow' );


// Display header from keys instead.  ( default behavior )
$data[0] = ['weekday' => 'Weekday', 'abbrev' => 'Abbrev', 'initial' => 'Initial', 'position' => 'Position'];
echo "\n\n  [ Example 2.  Table with header generated from array keys ]\n";
echo texttable::table( $data );

// Add a footer row, same as header, but displaying values instead of keys.
$data[] = $data[0];
echo "\n\n  [ Example 3.  Table with header (array keys) and footer ( array vals ) ]\n";
echo texttable::table( $data, $headertype = 'keys', $footertype = 'lastrow' );

