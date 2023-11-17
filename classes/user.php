<?php

class User {

    private $username;
    private $fname;
    private $lname;
    private $pwd;
    private $pwdConf;
    private $phone;
    private $type;
    
    public function __construct($fname, $lname, $pwd, $pwdConf, $phone, $type, $username) {

        $this->fname = $fname;
        $this->lname = $lname;
        $this->pwd = $pwd;
        $this->pwdConf = $pwdConf;
        $this->phone = $phone;
        $this->type = $type;
        $this->username = $username;

    }
///////////////////////////////////////////////////////////////////////////////////////////////////////
public function getUsername()
{
  return $this->username;
}
public function getFirstName()
{
  return $this->fname;
}
public function getLastName()
{
  return $this->lname;
}

public function serialize()
{
  return serialize([
    'username' => $this->username,
    'fname' => $this->fname,
    'lname' => $this->lname,
    'phone' => $this->phone,
    'pwd'   => $this->pwd,
    'pwdConf'=> $this->pwdConf,
    'type' => $this->type
  ]);
}
public function unserialize($data)
{
  $data = unserialize($data);
  $this->username = $data['username'];
  $this->fname = $data['fname'];
  $this->lname = $data['lname'];
  $this->phone = $data['phone'];
  $this->pwd = $data['pwd'];
  $this->pwdConf = $data['pwdConf'];
  $this->type = $data['type'];
}

//////////////////////////////////// Checks //////////////////////////////////////////////////////////
    private function confirm_pwd() {
        return $this->pwd === $this->pwdConf;
    }

    private function emptyInput() {
        

        if (empty($this->fname) || empty($this->lname) || empty($this->pwd) || empty($this->pwdConf) || empty($this->phone)){
            $result = false;
        }else{ 
            $result = true;
        }
        return $result;
    }
     
    private function invalidInput(){
        
        if(!preg_match("/^[a-zA-z]*$/", $this->fname) || !preg_match("/^[a-zA-z]*$/",$this->lname) || !preg_match("/^[0-9]*$/", $this->phone))
            return false;

        return true;
    }

    private function emptyLogin(){
        if(empty($this->username) || empty($this->pwd)){
            return true;
        }

        return false;
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////// Register a user /////////////////////////////////////////////////
    public function register() {

        // Check if registration info is emtpy.
        if($this-> emptyInput() == false){
            // echo "Empty input"
            header("location: ../index.php?error=emtpyInput");
            exit();
        }

        // Check if input is valid.
        if($this-> invalidInput() == false){
            // echo "Empty input"
            header("location: ../index.php?error=nameorphone");
            exit();
        }

        if(!$this->confirm_pwd()){
            // echo "not the same"
            header("location: ../index.php?error=pwdConfnotmatch");
            exit();
        }

        $database = new Dbh();
        

        // Select the stored proc and exexute
        $sql = "CALL find_user(:fname, :lname, :phone)";
        $params = [':fname' => $this->fname, ':lname' => $this->lname, ':phone' => $this->phone];
        $sqlResult = $database->executeQuery($sql, $params);

        if($sqlResult == false){
            $sqlResult = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }else{

            $result = $sqlResult->fetch(PDO::FETCH_ASSOC);

            if($result !== false) {
                // echo "user exists"
                header("location: ../index.php?error=userexists");
                exit();
            }else{
                
                // Close previous query
                $sqlResult->closeCursor();

                // Here we register the user
                

                // hash user password before adding to database.
                $hashedPwd = password_hash($this->pwd, PASSWORD_BCRYPT);
                $sql = "CALL add_user(:fname, :lname, :phone, :pwd, :type)";
                $params = [':fname' => $this->fname, ':lname' => $this->lname, ':phone' => $this->phone, ':pwd' => $hashedPwd, ':type' => $this->type];
                $sqlRegister = $database->executeQuery($sql, $params);

                if($sqlRegister == false){
                    $sqlResult = null;
                    echo "add_user";
                    //header("location: ../index.php?error=stmtfailed");
                    exit();
                }
            }
        }
        // Close previous query
        $sqlResult->closeCursor();
        echo "User '{$this->username}' has been registered.\n";
  }
////////////////////////////////////end of register code//////////////////////////////////////


/////////////////////////////////// Log in a user ////////////////////////////////////////////

  public function login() {

    // Check if login info is emtpy.
    if($this-> emptyLogin() == true){
        header("location: ../index.php?error=emtpyInput");
        exit();
    }

    //Connect to database using handler
    $database = new Dbh();
    

    // Select the stored proc and exexute
    $sql = "CALL get_user(:username)";
    $params = [':username' => $this->username];
    $sqlResult = $database->executeQuery($sql, $params);

    // If the query has a problem exit.
    if($sqlResult == false){
        $sqlResult = null;
        header("location: ../index.php?error=stmtfailed");
        exit();
    }else{

        $result = $sqlResult->fetch(PDO::FETCH_ASSOC);

        // If there are no rows result is false.
        if($result == false) {

            // echo "user not exists"
            header("location: ../index.php?error=usernotexists");
            exit();

        }else{

            // Check password user entered with the one in the db (pwd_ver returns t/f)
            $checkPwd = password_verify($this->pwd,  $result["Upassword"]);

            if($checkPwd == false){

                $sql = null;
                //echo '<pre>';
                //print_r($result[0]['Username']);
                //echo '</pre>';
                header("location: ../index.php?error=wrongpassword");
                exit();

            }elseif($checkPwd == true){

                // Check if user is enrolled
                if($result["isEnrolled"] == 1){

                    // lock in the user
                    session_start();

                    // Create a user according to the type of user
                    $serialized = serialize($this);
                    $_SESSION['user'] = $serialized;

                    if ($result['UType'] == 2) {

                        // Create Admin user.
                        $adminUser = new Admin($fname=$result['Fname'], $lname=$result['Lname'], $pwd=null, $pwdConf=null, $phone=$result['Phone'], $type = $result['UType'], $username=$result['username']);
                        $adminUser = serialize($adminUser);
                        $_SESSION['user'] = $adminUser;
                        $_SESSION['type'] = 'Admin';

                        // Send to Admin page.
                        header("location: ../admin/dashboard.php");
                        
                    } elseif($result['UType'] == 1) {

                        // Create Teacher user.
                        $teacherUser = new Teacher($fname=$result['Fname'], $lname=$result['Lname'], $pwd=null, $pwdConf=null, $phone=$result['Phone'], $type = $result['UType'], $username=$result['username']);
                        $teacherUser = serialize($teacherUser);
                        $_SESSION['user'] = $teacherUser;
                        $_SESSION['type'] = 'Teacher';

                        // Send to Teacher page.
                        header("location: ../user/teacherdashboard.php");

                    }elseif($result['UType'] == 0){

                        // Create Student user.
                        $studentUser = new Student($fname=$result['Fname'], $lname=$result['Lname'], $pwd=null, $pwdConf=null, $phone=$result['Phone'], $type = $result['UType'], $username=$result['username']);
                        $studentUser = serialize($studentUser);
                        $_SESSION['user'] = $studentUser;
                        $_SESSION['type'] = 'Student';

                        // Send to Student page.
                        header("location: ../user/studentdashboard.php");
                        
                    }
                }else{

                    // If not enrolled display error.
                    $sql = null;
                    header("location: ../index.php?error=notenrolled");

                }
                exit();
            }
        }
    }

  }

/////////////////////////////////// end of login code //////////////////////////////////////////////////////

} // This is the class bracket dont delete.


// Break down users into smaller classes.
class Student extends User {
    // Student specific functions.
}

class Teacher extends User {
    // Teacher specific functions.
}

class Admin extends User {
    // Student specific content.
}