<?php

/**
 * @author Assidi
 * @copyright 2017
 */

abstract class AbstractDb {
    protected $mysqli;
    // открытие соединения  с БД
    public function __construct($host, $user, $password, $database) {
        $mysqli = new mysqli($host, $user, $password, $database);
        if ($mysqli->connect_errno) {
        exit ("Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
    $mysqli->set_charset("utf8");
    $this->mysqli = $mysqli;
    }
    
    // закрытие соединения с БД
    public function __destruct() {
         $this->mysqli->close ();
    }
    
    // выполняет запрос типа select  и возвращает массив результата
    public function selectQuery($query) {
        $mysqliResult = $this->mysqli->query($query);
        if(!$mysqliResult) {
            exit("Ошибка выполнения запроса ".$query);
            return false;
        }
        $n = $mysqliResult->num_rows;
        $result=array();
        
        for ($i = 0; $i < $n; $i++){
            $row = $mysqliResult->fetch_assoc();
            $result[$i] = $row;
        }        
        return $result;  
    }
    
    // извлекает все данные из таблицы $table в двумерный массив
    public function selectAll($table) {
        $query = "SELECT * FROM `".$table."`";
        $result = $this-> selectQuery($query); 
        return $result;      
    }
    
    // извлекает все данные из таблицы в двумерный масив, при этом сортируя по определенному полю
    // по умолчанию - по возрастанию, если по убыванию, то вводится дополнительный параметр
    public function selectAllSort($table, $column, $order=false) {
        $query = "SELECT * FROM `".$table."` ORDER BY `".$column."`";
        if ($order) {
            $query = $query." DESC";
        }
        $result = $this-> selectQuery($query); 
        return $result;  
    }
    
     
    // извлекает одну запись таблицы, по идентификатору $name со значением $value
    // подразумевается, что выбор идет по уникльному ключу, поэтому возвращается одномерный массив 
     public function selectOne($table, $name, $value) {
        $query = "SELECT * FROM `".$table."` WHERE `".$name."` = '".$value."'";
        $result = $this-> selectQuery($query);
        if (!$result) return false;
        return $result[0];
     }
     
     // добавление новой записи
     // параметры - массив, где ключи - имена полей, а знчение - их содержание 
     // и имя таблицы
     public function newRecord($table, $record) {
        $query = 'INSERT INTO `'.$table.'`(';
        $s1='';
        $s2='';
        // формируем обе половинки запроса
        // в какие поля и какие значения
        // mysqli::escape_string ндо вставить
        foreach($record as $key=>$value) {            
            $s1 = $s1.'`'.$key.'`,';    
            $value =  $this->mysqli->real_escape_string($value);        
            $s2 = $s2.'"'.$value.'",';
        }
        // убираем лишние запятые в конце
        $s1 = substr($s1, 0, -1);
        $s2 = substr($s2, 0, -1);
        // теперь собираем запрос
        $query = $query.$s1.') VALUES ('.$s2.')';
        //$_SESSION['debug'] = $query;
        $mysqliResult = $this->mysqli->query($query);
        if(!$mysqliResult) {
            exit("Ошибка выполнения запроса");
            return false;
        }
        return true;
     }
     
     /**
      * Редактирование записи 
      * @param $table - string имя таблицы
      * @param $name - string имя поля, по которому выбираем запись 
      * @param $value - значение этого поля
      * @param  $record array массив значение
      */
     public function editRecord($table, $idName, $idValue, $record) {
        $query = 'UPDATE `'.$table.'` SET ';
        foreach($record as $key=>$value) {
            $value =  $this->mysqli->real_escape_string($value);
            $query = $query.'`'.$key.'` = "'.$value.'",';            
        }
        // убираем лишнюю запятую в конце
        $query = substr($query, 0, -1);
        // добавляем условие
        $query = $query.' WHERE `'.$idName.'`="'.$idValue.'"';
        $mysqliResult = $this->mysqli->query($query);
        if(!$mysqliResult) {
            exit("Ошибка выполнения запроса ".$query);
            return false;
        }
        return true;  
     }
     
      /**
      * Удаление записи 
      * @param $table - string имя таблицы
      * @param $name - string имя поля, по которому выбираем запись 
      * @param $value - значение этого поля
      *       * 
      */
      
      public function deleteRecord($table, $name, $value) {
        $query = 'DELETE FROM `'.$table.'` WHERE `'.$name.'`='.'"'.$value.'"';
        $mysqliResult = $this->mysqli->query($query);
        if(!$mysqliResult) {
            exit("Ошибка выполнения запроса ".$query);
            return false;
        }
        return true;  
      }
     
      /**
      * Возвращает количество записей
      * @param $table - string имя таблицы
      * @return integer
      *        
      */
     public function countRecords($table) {
        $query = 'SELECT COUNT( * ) FROM  `'.$table.'`';
        $result = $this-> selectQuery($query);
        $arr = $result[0];
        $n = 0;
        foreach ($arr as $key=>$value) {
            $n = $value;
        }
        return $n;
     }
     
     // выбирает записи с сортировкой и ограничением по количеству
     public function selectSortLimit($table, $column, $order=false, $start, $n) {        
        $query = "SELECT * FROM `".$table."` ORDER BY `".$column."`";
        if ($order) {
            $query = $query." DESC";
        }
        $query = $query.' LIMIT '.$start.','.$n;
        $result = $this-> selectQuery($query); 
        return $result;
     }
}

?>