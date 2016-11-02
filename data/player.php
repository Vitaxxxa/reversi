<?php

class Player
{
    protected $name='noname';
    protected $id=NULL;

    public function setName($name){
        $this->name=$name;
    }

    public function getName(){
        return $this->name;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getId(){
        return $this->id;
    }

    public function getCount($board){
        foreach ($board as $row) {
            foreach ($row as $cell){
                if ($cell == $this->id){
                    $count++;
                }
            }
        }
        return $count;
    }
}

?>