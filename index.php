<?php

include_once "model/tasks.php";


if(createDataBase()){

    $result = viewResult();
    if($result !== FALSE){
        $day = null;
        $i = 0;
        $masResult = [];
        while($row = $result->fetch_assoc()) {
            
            if ($day != $row["DAYNAME(time_reports.date)"]){
                $day = $row["DAYNAME(time_reports.date)"];
                $i = 0;
            }

            ++$i;

            if(($day == $row["DAYNAME(time_reports.date)"]) && ($i<=3)){
                $masResult[$day][$row["name"]] = $row["hours"];

            }

        }

        if(count($masResult)>0){
            $dayMaxLen = strlen('Wednesday')+2;
            $mas = [];
            $maxString = 0;

            foreach($masResult as $day=>$item){
                $str = '| ' . $day;
                $lentgh = strlen($str);
                
                while ($lentgh < $dayMaxLen){
                    $str .= ' ';
                    $lentgh = strlen($str);
                }
                $str .= ' |';    
                
                if(count($item)>0){

                    foreach($item as $name=>$hours){
                        $str = $str . $name . ' (' . $hours . ' hours), ';
                    }
                    $str = rtrim($str, ', ');
                    if(strlen($str) > $maxString)
                        $maxString = strlen($str);

                    $mas[] = $str;
                }

            }
            if(count($mas)>0){
                foreach($mas as  $item){
                    $str = $item;
                    $lentgh = strlen($str);
                    if( $lentgh < $maxString){
                        while ($lentgh < $maxString){
                            $str .= ' ';
                            $lentgh = strlen($str);
                        }

                    }
                    $str .= ' |';
                    echo $str . PHP_EOL;
                }

            }

        }

    }else
    echo 'no results';

}





?>