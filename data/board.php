<?php

class Board
{
    protected $area;
    protected $size=0;
    const FREE=0;
    const CAN_MOVE=3;

    public function createBoard($size){
        for ($x=1;$x<=$size;$x++){
            for ($y=1;$y<=$size;$y++){
                $this->area[$x][$y]=self::FREE;
            }
        }
        $this->size=$size;
    }

    public function setStartPosition($player1,$player2){
        $center=round($this->size/2);
        $this->area[$center][$center]=$player2;
        $this->area[$center+1][$center+1]=$player2;
        $this->area[$center][$center+1]=$player1;
        $this->area[$center+1][$center]=$player1;
    }

    public function getArea(){
        return $this->area;
    }

    public function clearMoves($player1,$player2){
        $size=$this->size;
        for ($i=1;$i<=$size;$i++){
            for ($q=1;$q<=$size;$q++)
                if ($this->area[$i][$q] != $player1 and $this->area[$i][$q] != $player2 and $this->area[$i][$q] != self::FREE)
                    $this->area[$i][$q]  = self::FREE;
        }
    }
    
    public function showBoard($player1,$player2){
        echo "<table class='cell'>";
        foreach ($this->area as $row){
            $x++;
            $y=0;
            echo "<tr width='50px'>";
            foreach ($row as $cell) {
                $y++;
                echo "<td width='50px' class='cell' align='center' valign='center'>";
                if ($cell==$player1){
                    echo "<div class='player_1'></div>";
                }elseif ($cell==$player2){
                    echo "<div class='player_2'></div>";
                }elseif ($cell==self::FREE){
                    echo "<div class='free'></div>";
                }elseif ($cell==self::CAN_MOVE){
                    echo "<a href='?x=$x&y=$y'><div class='canMove'></div></a>";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function showMoves($currentPlayer,$waitPlayer){
        $size=$this->size;
        $this->clearMoves($currentPlayer,$waitPlayer);
        foreach ($this->area as $row){
            $x++;
            $y=0;
            foreach ($row as $cell){
                $y++;
                if ($cell == $currentPlayer){                        
                    // UP FIND MOVE
                    if ($this->area[$x-1][$y] == $waitPlayer){
                        for ($i=$x-1;$i>0;$i--){
                            if ($this->area[$i][$y] == $currentPlayer or $this->area[$i][$y] == self::CAN_MOVE){
                                $i=0;
                            }elseif ($this->area[$i][$y] === self::FREE){
                                $this->area[$i][$y] = self::CAN_MOVE;
                                $i=0;
                            }
                        }
                    }
                    // DOWN FIND MOVE
                    if ($this->area[$x+1][$y] ==$waitPlayer){
                        for ($i=$x+1;$i<=$size;$i++){
                            if ($this->area[$i][$y] == $currentPlayer or $this->area[$i][$y] == self::CAN_MOVE){
                                $i=$size;
                            }elseif ($this->area[$i][$y] === self::FREE){
                                $this->area[$i][$y] = self::CAN_MOVE;
                                $i=$size;
                            }
                        }
                    }
                    // LEFT FIND MOVE
                    if ($this->area[$x][$y-1] == $waitPlayer){
                        for ($i=$y-1;$i>0;$i--){
                            if ($this->area[$x][$i] == $currentPlayer or $this->area[$x][$i] == self::CAN_MOVE){
                                $i=0;
                            }elseif ($this->area[$x][$i] === self::FREE ){
                                $this->area[$x][$i]  = self::CAN_MOVE;
                                $i=0;
                            }
                        }
                    }

                    // RIGHT FIND MOVE
                    if ($this->area[$x][$y+1] == $waitPlayer){
                        for ($i=$y+1;$i<=$size;$i++){
                            if ($this->area[$x][$i] == $currentPlayer or $this->area[$x][$i] == self::CAN_MOVE){
                                $i=$size;
                            }elseif ($this->area[$x][$i] === self::FREE){
                                $this->area[$x][$i]  = self::CAN_MOVE;
                                $i=$size;
                            }
                        }
                    }

                    // UP RIGHT FIND MOVE
                    if ($this->area[$x-1][$y+1] == $waitPlayer){
                        $temp=$y;
                        for ($i=$x-1;$i>0;$i--){
                            $temp=$temp+1;
                            if ($this->area[$i][$temp] == $currentPlayer or $this->area[$i][$temp] == self::CAN_MOVE){
                                $i=0;
                            }elseif ($this->area[$i][$temp] === self::FREE and $this->area[$i][$temp] != self::CAN_MOVE){
                                $this->area[$i][$temp] = self::CAN_MOVE;
                                $i=0;
                            }
                        }
                    }
                    
                    // UP LEFT FIND MOVE
                    if ($this->area[$x-1][$y-1] == $waitPlayer){
                        $temp=$y;
                        for ($i=$x-1;$i>0;$i--){
                            $temp=$temp-1;
                            if ($this->area[$i][$temp] == $currentPlayer or $this->area[$i][$temp] == self::CAN_MOVE){
                                $i=0;
                            }elseif ($this->area[$i][$temp] === self::FREE and $this->area[$i][$temp] != self::CAN_MOVE){
                                $this->area[$i][$temp] = self::CAN_MOVE;
                                $i=0;
                            }
                        }
                    }
                    
                    // DOWN RIGHT FIND MOVE
                    if ($this->area[$x+1][$y+1] == $waitPlayer){
                        $temp=$y;
                        for ($i=$x+1;$i<=$size;$i++){
                            $temp=$temp+1;
                            if ($this->area[$i][$temp] == $currentPlayer or $this->area[$i][$temp] == self::CAN_MOVE){
                                $i=$size;
                            }elseif ($this->area[$i][$temp] === self::FREE and $this->area[$i][$temp] != self::CAN_MOVE){
                                $this->area[$i][$temp] = self::CAN_MOVE;
                                $i=$size;
                            }
                        }
                    }

                    // DOWN RIGHT FIND MOVE
                    if ($this->area[$x+1][$y-1] == $waitPlayer){
                        $temp=$y;
                        for ($i=$x+1;$i<=$size;$i++){
                            $temp=$temp-1;
                            if ($this->area[$i][$temp] == $currentPlayer or $this->area[$i][$temp] == self::CAN_MOVE){
                                $i=$size;
                            }elseif ($this->area[$i][$temp] === self::FREE and $this->area[$i][$temp] != self::CAN_MOVE){
                                $this->area[$i][$temp] = self::CAN_MOVE;
                                $i=$size;
                            }
                        }
                    }

                }
            }
        }
    }

    public function movePlayer($currentPlayer,$waitPlayer,$x,$y){
        $size=$this->size;
        $this->area[$x][$y]=$currentPlayer;
        // UP MOVE
        if ($this->area[$x-1][$y] == $waitPlayer){
            for ($q=$x-1;$q>0;$q--){
                if ($this->area[$q][$y] == $currentPlayer){
                    for ($i=$x-1;$i>0;$i--){
                        if ($this->area[$i][$y] == $currentPlayer){
                            $this->area[$i][$y]=$currentPlayer; 
                            $i=0;
                        }else{
                            $this->area[$i][$y]=$currentPlayer;   
                        }
                    }
                    $q=0;
                }elseif($this->area[$q][$y] == self::FREE or $this->area[$q][$y] == self::CAN_MOVE){
                     $q=0;
                }
            }
        }
        // DOWN MOVE
        if ($this->area[$x+1][$y] == $waitPlayer){
            for ($q=$x+1;$q<=$size;$q++){
                if ($this->area[$q][$y] == $currentPlayer){
                    for ($i=$x+1;$i<=$size;$i++){
                        if ($this->area[$i][$y] == $currentPlayer){
                            $this->area[$i][$y]= $currentPlayer;
                            $i=$size;
                        }else{
                            $this->area[$i][$y]= $currentPlayer;
                        }
                    }
                    $q=$size;
                }elseif($this->area[$q][$y] == self::FREE or $this->area[$q][$y] == self::CAN_MOVE){
                     $q=$size;
                }
            }
        }
        // LEFT MOVE
        if ($this->area[$x][$y-1] == $waitPlayer){
            for ($q=$y-1;$q>0;$q--){
                if ($this->area[$x][$q] == $currentPlayer){
                    for ($i=$y-1;$i>0;$i--){
                        if ($this->area[$x][$i] == $currentPlayer){
                            $this->area[$x][$i]=$currentPlayer;
                            $i=0;
                        }else{
                            $this->area[$x][$i]=$currentPlayer;
                        }
                    }
                    $q=0;
                }elseif($this->area[$x][$q] == self::FREE or $this->area[$x][$q] == self::CAN_MOVE){
                     $q=0;
                }
            }
        }

        // RIGHT MOVE
        if ($this->area[$x][$y+1] == $waitPlayer){
            for ($q=$y+1;$q<=$size;$q++){
                if ($this->area[$x][$q] == $currentPlayer){
                    for ($i=$y+1;$i<=$size;$i++){
                        if ($this->area[$x][$i] == $currentPlayer){
                            $this->area[$x][$i]= $currentPlayer;
                            $i=$size;
                        }else{
                            $this->area[$x][$i]= $currentPlayer;
                        }
                    }
                    $q=$size;
                }elseif($this->area[$x][$q] == self::FREE or $this->area[$x][$q] == self::CAN_MOVE){
                    $q=$size;
                }
            }
        }
        // DOWN LEFT MOVE
        if ($this->area[$x+1][$y-1] == $waitPlayer){
            $temp=$y;
            for ($q=$x+1;$q<=$size;$q++){
                $temp=$temp-1;
                if ($this->area[$q][$temp] == $currentPlayer){
                    $tempY=$y;
                    for ($i=$x+1;$i<=$size;$i++){
                        $tempY=$tempY-1;
                        if ($this->area[$i][$tempY] == $currentPlayer){
                            $this->area[$i][$tempY]=$currentPlayer; 
                            $i=$size;
                        }else{
                            $this->area[$i][$tempY]=$currentPlayer;   
                        }
                    }
                    $q=$size;
                }elseif($this->area[$q][$temp] == self::FREE or $this->area[$q][$temp] == self::CAN_MOVE){
                    $q=$size;
                }
            }
        }
        // DOWN RIGHT MOVE
        if ($this->area[$x+1][$y+1] == $waitPlayer){
            $temp=$y;
            for ($q=$x+1;$q<=$size;$q++){
                $temp=$temp+1;
                if ($this->area[$q][$temp] == $currentPlayer){
                    $tempY=$y;
                    for ($i=$x+1;$i<=$size;$i++){
                        $tempY=$tempY+1;
                        if ($this->area[$i][$tempY] == $currentPlayer){
                            $this->area[$i][$tempY]=$currentPlayer; 
                            $i=$size;
                        }else{
                            $this->area[$i][$tempY]=$currentPlayer;   
                        }
                    }
                    $q=$size;
                }elseif($this->area[$q][$temp] == self::FREE or $this->area[$q][$temp] == self::CAN_MOVE){
                    $q=$size;
                }
            }
        }
        // UP LEFT MOVE
        if ($this->area[$x-1][$y-1] == $waitPlayer){
            $temp=$y;
            for ($q=$x-1;$q>0;$q--){
                $temp=$temp-1;
                if ($this->area[$q][$temp] == $currentPlayer){
                    $tempY=$y;
                    for ($i=$x-1;$i>0;$i--){
                        $tempY=$tempY-1;
                        if ($this->area[$i][$tempY] == $currentPlayer){
                            $this->area[$i][$tempY]=$currentPlayer; 
                            $i=0;
                        }else{
                            $this->area[$i][$tempY]=$currentPlayer;   
                        }
                    }
                    $q=0;
                }elseif($this->area[$q][$temp] == self::FREE or $this->area[$q][$temp] == self::CAN_MOVE){
                    $q=0;
                }
            }
        }
        // UP RIGHT MOVE
        if ($this->area[$x-1][$y+1] == $waitPlayer){
            $temp=$y;
            for ($q=$x-1;$q>0;$q--){
                $temp=$temp+1;
                if ($this->area[$q][$temp] == $currentPlayer){
                    $tempY=$y;
                    for ($i=$x-1;$i>0;$i--){
                        $tempY=$tempY+1;
                        if ($this->area[$i][$tempY] == $currentPlayer){
                            $this->area[$i][$tempY]=$currentPlayer; 
                            $i=0;
                        }else{
                            $this->area[$i][$tempY]=$currentPlayer;   
                        }
                    }
                    $q=0;
                }elseif($this->area[$q][$temp] == self::FREE or $this->area[$q][$temp] == self::CAN_MOVE){
                    $q=0;
                }
            }
        }
    }

}

?>