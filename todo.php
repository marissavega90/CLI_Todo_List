<?php
// Create array to hold list of todo items
$items = array();


 // List array items formatted for CLI
 function listItems($items) {
    
    // Defined the variable here so that it is not undefined
    $itemList = '';
    
    // The loop!
    foreach ($items as $key => $item) {

    // Reindexes key to start at [1] instead of [0]
    $key++;
    
    // Return string of list items separated by newlines.
        $itemList .= "[{$key}] {$item}" . PHP_EOL;
    }

        return $itemList;
 }

 // Get STDIN, strip whitespace and newlines,
 // and convert to uppercase if $upper is true
 function getInput($upper = false) {

    // accept some user input
    $input = trim(fgets(STDIN));

    // if we want uppercase, make that input uppercase and return
    if ($upper) {
        return strtoupper($input); 
        
    // otherwise, return it as is
    } else { 

    // Return filtered STDIN input    
        return $input;
    }

    // Option for ternary operator:
    // return ($upper) ? strtoupper($input) : $input;
    
 }


// The loop!
do {
    
    echo listItems($items);
        
        
    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit : ';

    // Get the input from user
    $input = getInput(true);

    // Check for actionable input
    if ($input == 'N') {
       
        // Ask for entry
        echo 'Enter item: ';
        
        // Add entry to list array
        $items[] = getInput();
    
    } elseif ($input == 'R') {
        
        // Remove which item?
        echo 'Enter item number to remove: ';
       
        // Get array key
        $key = getInput();

        // Reindexes array to reset numbered keys after removal of item
        $key--;

        // Remove from array
        
        unset($items[$key]);
        // Reindex numerical array
        $items = array_values($items);
    }
    
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);
