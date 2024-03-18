<?php 

class DbQuery extends DbBase{

  public static function fetchAll($query, $arguments = [])
  {
      $stmt = self::execute($query, $arguments);
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  
  public static function fetch($query, $arguments = [])
  {
      $stmt = self::execute($query, $arguments);
      return $stmt->fetch(\PDO::FETCH_ASSOC);
  }


}