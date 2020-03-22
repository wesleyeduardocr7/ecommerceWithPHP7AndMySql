<?php

namespace Classes\Model;

use Classes\DB\Sql;
use \Classes\Model;
use Exception;

class User extends Model{


    const SESSION = "User";

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

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

            return $user;                        

        }else{
            throw new Exception("Usuário Inexistente ou Senha Inválida");
        }

    }

    public static function verifyLogin($inadmin = true)
    {

        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        
        ){
            header("Location: /admin/login");

            exit;

        }
    }

    public function logout(){

        $_SESSION[User::SESSION] = null;
    }

    
    public static function listAll(){

        $sql = new Sql();

       return  $result = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) ORDER BY b.desperson");

    }

    public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":desperson"=>utf8_decode($this->getdesperson()),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));

		$this->setData($results[0]);

	}


}

?>