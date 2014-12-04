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

 // Function for sorting items
function sort_menu($items) {
    
    // Ask user how they want to sort list
    echo '(A)-Z, (Z)-A, (O)rder entered, (R)everse order entered: ';

    // Get user input
    $input = getInput(true);

    // If it is A-Z, use sort($array) with SWITCH statements!
    switch ($input) {

        case 'A':
            sort($items);
            break;

        case 'Z':
            rsort($items);
            break;
        
        case 'O':
            ksort($items);
            break;
    
        case 'R':
            krsort($items);
            break;
    }

    return $items;
}

function itemPlacement($items, $todo_item) {

    // Ask the user if they want the item at the end or the beginning of the list
    echo 'Where do you want to place your item?: (B)eginning, (E)nd ';

    // Get user input
    $input = getInput(true);

    switch ($input) {

        // If the user input is 'B' then array_unshift($items)
        case 'B':
            array_unshift($items, $todo_item);
            break;

        // If the user input is 'E' then array_pop($items)
        case 'E':
            array_push($items, $todo_item);
            break;
          
        // Default to end of list if no input is given
        default:
            array_push($items, $todo_item);
            break;
    }

    return $items;

}

function saveFile($filename, $items) {

    // If the file already exists, ask to overwrite
    if (file_exists($filename)); {
        echo "File already exists! Overwrite? (Y)/(N)? " . PHP_EOL;

        $overwrite = getInput(true);

        if ($overwrite == 'N') {
                // If the answer is 'N', do not overwrite file, ask for new file name
            echo "Enter new file name: " . PHP_EOL;

            $filename = getInput();
        }
    }

    $handle = fopen($filename, 'w');

    fwrite($handle, implode(PHP_EOL, $items));

    fclose($handle);

    return "Your file has been saved! " . PHP_EOL;

}

function openFile($items) {
    
    // Set filename
    $filename = getInput();
    
    // Create our handle with fopen, that represents a file pointer.
    $handle = fopen($filename, 'r');

    // Read from the pointer, until there isn't any more file.  Returns a string.
    $contents = fread($handle, filesize($filename));

    fclose($handle);
    
    // Convert that string, to an array.
    // echo $contents;
    // explode(PHP_EOL, $contents);

    // array created
    $newItems = explode(PHP_EOL, $contents);

    // merge that array of new items, with existing items.
    // array_merge($newItems, $items);

    $items = array_merge($newItems, $items);

    return ($items); 
}

// The loop!
do {
    
    echo listItems($items);
        
        
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort list, (O)pen, s(A)ve, (Q)uit : ';

    // Get the input from user
    $input = getInput(true);

    // Check for actionable input
    switch ($input) {

        case 'N':
       
            // Ask for entry
            echo 'Enter item: ';
        
            // Re-assign user input
            $todo_item = getInput();

            // Call back itemPlacement function
            $items = itemPlacement($items, $todo_item);

                break;
        
        case 'R':
        
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

                break;

        case 'S':
        
            // call function 'sort_menu'
            $items = sort_menu($items);

                break;

        case 'F':
        
            array_shift($items);

                break;

        case 'L':

            array_pop($items);

                break;

        case 'O':

            echo "What file do you want to open? (data/filename.txt)" . PHP_EOL;

            $items = openFile($items);

            break;

        case 'A':

            echo "What do you want to name your file? (data/filename.txt) " . PHP_EOL;

            $filename = getInput();

            echo saveFile($filename, $items);
            
    }
    
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!" . PHP_EOL;

// Exit with 0 errors
exit(0);
