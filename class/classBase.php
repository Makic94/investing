<?php
class Base{
    protected $location;
    protected $username;
    protected $password;
    protected $base;
    protected $db;
    public function __construct(){
        $this->location="localhost";
        $this->username="root";
        $this->password="";
        $this->base="investing";
    }
    public function __destruct(){
        mysqli_close($this->db);
    }
    public function connect(){
        $this->db=@mysqli_connect($this->location,$this->username,$this->password,$this->base);
        if(!$this->db) return false;
        $this->query("SET NAMES utf8");
        return $this->db;
    }
    public function query($upit){
        return mysqli_query($this->db,$upit);
    }
    public function fetch_assoc($rez){
        return mysqli_fetch_assoc($rez);
    }
    public function error(){
        return mysqli_error($this->db);
    }
    public function fetch_object($rez){
        return mysqli_fetch_object($rez);
    }
    public function num_rows($rez){
        return mysqli_num_rows($rez);
    }
    public function fetch_array($rez){
        return mysqli_fetch_array($rez);
    }
}
?>