<?php
include_once "model/connectdb.php";
include_once "model/fakedata.php";

//create database
function createDataBase()
    {
        global $host, $login, $password, $dbname, $employees, $time_reports;


        
        $conn = new mysqli($host, $login, $password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            return false;
        }else
        {
            echo 'Connected successfully' . PHP_EOL;

            if (empty (mysqli_fetch_array(mysqli_query($conn,"SHOW DATABASES LIKE '$dbname'")))) 
            {
                echo 'database not exist' . PHP_EOL; 
                echo 'create a new database and add tables whith fake data...' . PHP_EOL;
                // Create database
                $sql = "CREATE DATABASE " . $dbname;
                if ($conn->query($sql) === TRUE) {
                    echo "Database created successfully" . PHP_EOL;
                    
                    //select database
                    mysqli_select_db ( $conn , $dbname );
                   

                    //create table employees
                    $sql = "CREATE TABLE employees (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(60) NOT NULL
                        )";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "Table employees created successfully" . PHP_EOL;
                            
                            //add a fake data
                            if(count($employees) >0){
                                foreach($employees as $item){
                                    $sql = "INSERT INTO employees (name)
                                        VALUES ('" . $item . "')";
                                    if ($conn->query($sql) === TRUE) {
                                       
                                        //overwrite keys in $time_reports
                                        if(array_key_exists($item, $time_reports)){
                                            $time_reports[$conn->insert_id] = $time_reports[$item];
                                            unset($time_reports[$item]);
                                        }
                                        
                                    }else{
                                        echo "Error: " . $sql . PHP_EOL . $conn->error;
                                    }
                                }
                            }else{
                                echo 'Error: Table employees is empty';
                                return false;
                            }

                        } else {
                            echo "Error creating table employees: " . $conn->error . PHP_EOL;
                            return false;
                        }
                    
                        
                    //create table time_reports
                    $sql = "CREATE TABLE time_reports (
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        employee_id INT(6) UNSIGNED,
                        hours DECIMAL(4,2) UNSIGNED,
                        date DATE,
                        FOREIGN KEY (employee_id) REFERENCES employees(id)
                        )";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "Table time_reports created successfully" . PHP_EOL;

                            //add a fake data
                            if(count($time_reports)>0){
                                
                                foreach($time_reports as $key=>$item){
                                    if(count($item)>0){
                                        foreach($item as $oneDay){
                                            $hours = $oneDay[0];
                                            $date = $oneDay[1];

                                            $sql = "INSERT INTO time_reports (employee_id, hours, date)
                                                VALUES ('" . $key . "', '" . $hours . "', '" . $date . "')";

                                                if ($conn->query($sql) === FALSE) {
                                                    echo " Error: " . $sql . PHP_EOL . $conn->error;
                                                }
                                        }
                                    }

                                }

                            }else{
                                echo 'Error: Table time_reports is empty';
                                return false;
                            }

                        } else {
                            echo "Error creating table time_reports: " . $conn->error . PHP_EOL;
                            return false;
                        }

                    return true;
                } else {
                    echo "Error creating database: " . $conn->error . PHP_EOL;
                    return false;
                }
            }
            else
            {
                echo "database is exist" . PHP_EOL;
                return true;
            }
            
        }

        $conn->close();
    }

//show Result
function viewResult()
{
    global $host, $login, $password, $dbname;
    
    $conn = new mysqli($host, $login, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return false;
    }else
    {

        $sql = "SELECT name, hours, DAYNAME(time_reports.date)
        FROM time_reports
        LEFT JOIN employees 
        ON time_reports.employee_id = employees.Id
        ORDER BY date, hours DESC
        ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0)
            return $result;
        else
            return false;

    }

    $conn->close();
}