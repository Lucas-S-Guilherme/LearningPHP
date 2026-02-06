<?php 

Class Database {

    public $connection;

    public function __construct($config, $username= 'root', $password = '')
    {      

        $dsn =  'mysql:' . http_build_query($config, '', ';'); 
        
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]); //PDO é uma classe nativa do php para conexão com dbs
    }

    public function query($query, $params = [])
    {
         
        {       

            $statement = $this->connection->prepare($query);

            $statement->execute($params);

            return $statement;
        }
    }
}