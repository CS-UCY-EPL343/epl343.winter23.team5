<?php
class User implements Serializable
{
  // Attributes
  private $username;
  private $first_name;
  private $last_name;
  private $phone_number;
  private $login_status = false;
  private $registered_status = false;

  // Constructor
  public function __construct($username, $first_name, $last_name, $phone_number)
  {
    $this->username = $username;
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->phone_number = $phone_number;
  }

  public function getUsername()
  {
    return $this->username;
  }
  public function getFirstName()
  {
    return $this->first_name;
  }
  public function getLastName()
  {
    return $this->last_name;
  }

  public function serialize()
  {
    return serialize([
      'username' => $this->username,
      'first_name' => $this->first_name,
      'last_name' => $this->last_name,
      'phone_number' => $this->phone_number,
      'login_status' => $this->login_status,
      'registered_status' => $this->registered_status,
    ]);
  }
  public function unserialize($data)
  {
    $data = unserialize($data);
    $this->username = $data['username'];
    $this->first_name = $data['first_name'];
    $this->last_name = $data['last_name'];
    $this->phone_number = $data['phone_number'];
    $this->login_status = $data['login_status'];
    $this->registered_status = $data['registered_status'];
  }

  // Register a user
  public function register()
  {
    $this->registered_status = true;
    echo "User '{$this->username}' has been registered.\n";
    // Insert user into database
  }

  // Log in a user
  public function login()
  {
    $this->login_status = true;
    echo "User '{$this->username}' has logged in.\n";
    // validate login
  }

  // Delete the user's account
  public function delete_account()
  {
    $this->login_status = false;
    $this->registered_status = false;
    echo "User '{$this->username}' account has been deleted.\n";
    // delete from database
  }
}

class Student extends User
{
  // Additional properties and methods for students
  // You can add specific attributes and methods here.
}

class Teacher extends User
{
  function inClass($classID)
  {
    #Search in db
  }
  // Additional properties and methods for teachers
  // You can add specific attributes and methods here.
}

class Admin extends User
{
  // Additional properties and methods for administrators
  // You can add specific attributes and methods here.
}

/*
// Example usage:
$student = new Student("student123", "John", "Doe", "123-456-7890");
$student->register();
$student->login();
$student->delete_account();
*/
?>