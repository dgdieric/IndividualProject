<!-- Database information  -->

<?php
class Database
{
  //database login information
  private static $dbName = 'CIS355dgdieric' ;
  private static $dbHost = 'localhost' ;
  private static $dbUsername = 'CIS355dgdieric';
  private static $dbUserPassword = 'dgdieric486577';
     
  private static $cont = null;
    
  public function __construct() {
      die('Init function is not allowed');
  }
    
  public static function connect()
  {
    // One connection through whole application
    if ( null == self::$cont )
    {     
      try
      {
        self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
      }
      catch(PDOException $e)
      {
        die($e->getMessage()); 
      }
    }
      return self::$cont;
  }
     
  //disconnect from database
  public static function disconnect()
  {
    self::$cont = null;
  }
}
?>