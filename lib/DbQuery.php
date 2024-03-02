<?php 

class DbQuery extends DbBase{

  function fetchAll($query, $arguments = [])
  {
      $stmt = self::execute($query, $arguments);
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  
  function fetch($query, $arguments = [])
  {
      $stmt = self::execute($query, $arguments);
      return $stmt->fetch(\PDO::FETCH_ASSOC);
  }


}