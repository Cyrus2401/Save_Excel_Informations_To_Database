<?php
    /* show php error */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* include SimpleXLSX.php */
    include_once 'src/SimpleXLSX.php';

    $pdo = new PDO ("mysql:host=localhost;dbname=excel_info","cyrus","cyrus", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 

    if ($xlsx = SimpleXLSX::parse('fileExample.xlsx')) { 

        var_dump("ok");

        foreach ($xlsx->rows() as $key => $value) {
            if($key > 0) {		
        
                $pdo->beginTransaction();

                $sql = "INSERT INTO infos (firstname, lastname, gender, country, old, date, matricule) VALUES (:firstname, :lastname, :gender, :country, :old, :date, :matricule)";
                
                $stmt = $pdo->prepare($sql);
                                                                                            
                $stmt->bindparam(":firstname",$value[1]);
                $stmt->bindparam(":lastname", $value[2]);
                $stmt->bindparam(":gender", $value[3]);
                $stmt->bindparam(":country", $value[4]);
                $stmt->bindparam(":old", $value[5]);
                $stmt->bindparam(":date", $value[6]);
                $stmt->bindparam(":matricule", $value[7]);
                
                if($stmt->execute())
                {
                    $pdo->commit();				
                }
                else
                {
                    $pdo->rollback();
                }

            }
        }

        echo "Save Successfully !";
    }else{
        echo "No Save !";
    }

?>