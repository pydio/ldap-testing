<?php

$source_file_path = $argv[1]; // We expect full path
$baseDN = $argv[2]; // The base DN that wil be used

$firstRow = 2; // We skip CSV file headers
$row = 1;
date_default_timezone_set('Europe/Paris');
$currDate= date("Y-m-d, H:i ");
$limit = 12000;

if (($handle = fopen($source_file_path, "r")) !== FALSE) {
    echo "# Dummy users for ".$baseDN." generated at ".$currDate." \n\n";

    $members = "";
    while ((($data = fgetcsv($handle, 0, ",")) !== FALSE) && ($row <= $limit)){
        if($row < $firstRow) { $row++; continue; }
   
        $num = count($data);
        echo "dn: uid=".$data[2].",ou=".$data[5].",ou=people,".$baseDN."\n";
        echo "changetype: add\n";
        echo "gidNumber: 0\n";
        echo "objectClass: inetOrgPerson\n";
        echo "objectClass: organizationalPerson\n";
        echo "objectClass: person\n";
        echo "objectClass: top\n";
        echo "objectClass: posixAccount\n";
        echo "uidNumber: ".$data[0]."\n";
        echo "uid: ".$data[2]."\n";
        if ($data[3] != "Umlaut"){
            echo "homeDirectory: /home/".$data[2]."\n";
        }else{
            echo "homeDirectory: /home/".$data[3]."\n";
        }
        echo "sn: ".$data[3]."\n";
        echo "cn: ".$data[4]." ".$data[3]."\n";
        echo "mail: ".$data[1]."\n";
        echo "employeeType: ".$data[5]."\n";        
        echo "displayName: ".$data[4]." ".$data[3]."\n";
        echo "userPassword:: UEBzc3cwcmQ=\n";
        echo "\n";

        if ($data[6] != ""){
            $groups = explode("|", $data[6]);
            foreach($groups as $group)
            {
                if (!empty($group)){
                    echo "dn: ".$group."\n";
                    echo "changetype: modify\n";
                    echo "add: member\n";
                    echo "member: uid=".$data[2].",ou=".$data[5].",ou=people,".$baseDN."\n";
                    echo "\n";
                }
            }
        }

        if (($row < 1020) && ($data[5] !== "visitor")) {
            $members .= "member: uid=".$data[2].",ou=".$data[5].",ou=people,".$baseDN."\n";
        }
        $row++;
    }

    fclose($handle);

    echo "dn: cn=alluser,ou=groups,".$baseDN."\n";
    echo "changetype: add\n";
    echo "objectClass: groupOfNames\n";
    echo "objectClass: top\n";
    echo "cn: alluser\n";
    echo $members;
    echo "description: All employees of the Example organisation\n";
}