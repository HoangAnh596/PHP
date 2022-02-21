<?php
    function pdo_get_conn(){
        $host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 's4mobile';
        try {
            $objConn = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_pass);
            $objConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $objConn;
        } catch (Exception $e) {

            die("Loi ket noi CSDL: " . $e->getMessage());
        }
    }
function pdo_execute($sql, $params){
    try{
        $conn=pdo_get_conn();
        $stmt=$conn->prepare($sql);
        if(empty($params)){
            $stmt->execute();
            if(strpos(strtoupper($sql),'INSERT') !== false){
                $last_id=$conn->lastInsertId();
                return $last_id;   
            }
        }
        else{
            $stmt->execute($params);
            if(strpos(strtoupper($sql),'INSERT') !== false){
                $last_id=$conn->lastInsertId();
                return $last_id;   
            }
        }
    }
    catch(PDOException $e){
        die("Lỗi thực thi câu lệnh $e");
    }
    finally{
        unset($conn);
    }
}
function pdo_query($sql){
    try{
        $conn=pdo_get_conn();
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows=$stmt->fetchAll();
        return $rows;
    }catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);   
    }
}
function pdo_query_one($sql){
    try{
        $conn=pdo_get_conn();
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row;    
    }
    catch(Exception $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
