<?php

//this is a fake data to the database
$employees = [
    'Liam',	'Emma',	'Noah',	'Olivia',	'Mason',	
    'Ava',	'Ethan',	'Sophia',	'Logan',	
    'Isabella',	'Lucas',	'Mia',	'Jackson',	
    'Charlotte',	'Aiden',	'Amelia',	'Oliver',	
    'Emily',	'Jacob',	'Madison',	'Elijah',	
    'Harper',	'Alexander',	'Abigail',	'James',	
    'Avery',	'Benjamin',	'Lily',	'Jack',	'Ella',	
    'Luke',	'Chloe',	'William',	'Evelyn',	
    'Michael',	'Sofia',	'Owen',	'Aria',	'Daniel',	
    'Ellie',	'Carter',	'Aubrey',	'Gabriel',	
    'Scarlett',	'Henry',	'Zoey',	'Matthew',	'Hannah',	
    'Wyatt',	'Audrey',	'Caleb',	'Grace',	
    'Jayden',	'Addison',	'Nathan',	'Zoe',	'Ryan',	
    'Elizabeth',	'Isaac'
];

$time_reports = [];

$count_employees = count($employees);
if($count_employees > 0){
    for ($i = 0; $i < $count_employees; $i++) {
        $date = '2020-08-0';
        for($day = 3; $day <= 9; $day++){
            $time_reports[$employees[$i]][] = [mt_rand(300, 800)/100, $date . $day];
        }
    }
}