<?php

class Human {
    public Staff $staff;

//    public function __construct(Staff $staff)
//    {
//        $this->staff = $staff;
//    }
}

class Staff {

}

$human = new Human();
//$human->staff = new Staff();
var_dump($human->staff);
