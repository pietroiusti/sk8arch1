WE CAN USE A SCRIPT SIMILAR TO THIS ONE TO POPULATE OUR TRICKS DATABASE. 

#!/usr/bin/env php
<?php
    
    require("../includes/config.php");

    //there should be two aguments 
    if ($argc != 2)
    {
        echo "Improper usage";
    }
    else 
    {
        //the first command line argument is $argv[1]   
        //the file path is /home/jharvard/vhosts/pset8/bin/US.txt
        //Does the file exist? file_exist
        $existence = file_exists("$argv[1]");
        if ($existence === false)
        {
            echo "File doesn't exist";
        }
        //Is the file readable? is_readable
        $readability = is_readable("$argv[1]");
        if ($readability === false)
        {
            echo "File is not readable";
        }   
        //useful functions: fopen, fgetcsv, fclose, query    
        //open the file for reading 
        $filePtr = fopen("$argv[1]", "r");
        if ($filePtr === false)
        {
            echo "Error while opening the file";
        }
    
        //copy rows in US.txt and insert them in database using query()
	    //we know there are 43633 rows in the file so we can simply use a for loop or a while loop that iterates that number of times
	    $i = 0;
	    while ($i < 43633)
	    {
	        $row = fgetcsv($filePtr, 0, "\t");
            query("INSERT INTO places (country_code, postal_code, place_name, admin_name1, admin_code1, admin_name2, admin_code2, admin_name3, admin_code3, latitude, longitude, accuracy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11] );
	        $i += 1;
        }

        //close the file
        fclose($filePtr);
    }


?>  
