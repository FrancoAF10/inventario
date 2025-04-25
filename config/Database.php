<?php

// clase de conexión SERVER > BD
class Database{
  private static $host="localhost";
  private static $dbname="Inventario";
  private static $username="root";

  private static $password="";

  private static $charset="utf8mb4";

  private static $conexion=null;

  public static function getConexion(){

    if(self::$conexion===null){
      try{
        //Estructurar la cadena de conexión
        $DSN="mysql:host=" . self::$host.";port=3306;dbname=".self::$dbname.";charset=".self::$charset;
        $option=[
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ];
        self::$conexion=new PDO($DSN, self::$username,self::$password,$option);
      }catch(PDOException $e){
        throw new PDOException($e->getMessage());
      }
    }
    return self::$conexion;
  }
public static function closeConexion(){
  self::$conexion=null;
}
}