<?php
class ParentClass{
    private $id;
    private $roleId;
    private $firstName;
    private $lastName;
    private $phone;
    private $email;
    private $password;
    private $zip;
    private $isActive;
    
    function __construct($id, $roleId, $firstName, $lastName, $phone, $email, $password, $zip, $isActive) {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->zip = $zip;
        $this->isActive = $isActive;
    }
    
    function getStatusDescription(){
        
        if ( $this->isActive == 1)
            $status = "Active";
        else
            $status = "Deleted";
        
        return $status;
    }
    
        
    function getNotStatusDescription(){
        
        if ( $this->isActive == 1)
            $status = "Deleted";
        else
            $status = "Active";
        
        return $status;
    }
    
    function getNotIsActive() {
        $notIsActive = 2;
        
       if($this->isActive == 1)
            $notIsActive = 2;
        
        if ($this->isActive == 2)
          $notIsActive = 1;  

        return $notIsActive;
    }
    
    function getRoleDescription(){
        
        if ( $this->roleId == 1)
            $role = "User";
        else
            $role = "Admin";
        
        return $role;
    }
    
        
    function getNotRoleDescription(){
        
        if ( $this->roleId == 1)
            $status = "Admin";
        else
            $status = "User";
        
        return $status;
    }
    
    function getNotRole() {
        $notRole = 2;
        
       if($this->roleId == 1)
            $notRole = 2;
        
        if ($this->roleId == 2)
          $notRole = 1;  

        return $notRole;
    }

    function getId() {
        return $this->id;
    }

    function getRoleId() {
        return $this->roleId;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getPhone() {
        return $this->phone;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getZip() {
        return $this->zip;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setZip($zip) {
        $this->zip = $zip;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}

?>