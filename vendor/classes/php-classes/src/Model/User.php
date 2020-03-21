<?php

namespace Classes\Model;

use Classes\DB\Sql;
use \Classes\Model;
use Exception;

class User extends Model{

    public static function login($login,$password)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN",array(
            ":LOGIN"=>$login
        ));

        if(count($results)===0){
            throw new Exception("Usuário Inexistente ou Senha Inválida");
        }

        $data = $results[0];

        if(password_verify($password,$data["despassword"])){
            
            $user = new User();

        }else{
            throw new Exception("Usuário Inexistente ou Senha Inválida");
        }

    }

}




?>