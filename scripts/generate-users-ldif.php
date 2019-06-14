<?php

$row = 1;
$limit = 10;
$source_file_path = "./dummy-users-xs.csv";

if (($handle = fopen($source_file_path, "r")) !== FALSE) {
    $members = "";
    while ((($data = fgetcsv($handle, 0, ",")) !== FALSE) && ($row <= $limit)){
        $num = count($data);
        echo "# New entry \n";
        echo "dn: uid=".$data[2].",ou=staff,ou=people,dc=example,dc=com\n";
        echo "changetype: add\n";
        echo "gidNumber: 0\n";
        echo "objectClass: inetOrgPerson\n";
        echo "objectClass: organizationalPerson\n";
        echo "objectClass: person\n";
        echo "objectClass: top\n";
        echo "objectClass: posixAccount\n";
        echo "uidNumber: $row\n";
        echo "uid: ".$data[2]."\n";
        echo "homeDirectory: /home/".$data[2]."\n";
        echo "sn: ".$data[3]."\n";
        echo "cn: ".$data[3]."\n";
        echo "mail: ".$data[1]."\n";
        echo "employeeType: ".$data[4]."\n";        
        echo "displayName: Name ".$data[3]."\n";
        echo "userPassword:: UEBzc3cwcmQ=\n";
        echo "\n";
        if (($row < 1020) && ($data[4] !== "visitor")) {
            $members .= "member: uid=" . $data[2] . ",ou=staff,ou=people,dc=example,dc=com\n";
        }
        $row++;
    }

    fclose($handle);

    echo "dn: cn=employee,ou=staff,ou=groups,dc=example,dc=org\n";
    echo "changetype: add\n";
    echo "objectClass: groupOfNames\n";
    echo "objectClass: top\n";
    echo "cn: employee\n";
    echo $members;
    echo "description: All employees of the Example.com organisation\n";
}