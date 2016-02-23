<?php

/**
 * RoundRobin fj-a
 *
 * @param    array    $teams
 * @return    $array
 */
 function roundRobin( array $teams ){
	
	//Ako je neparan broj ekipa, onda u svakoj rundi jedna ekipa ima pauzu
    if (count($teams)%2 != 0){
        array_push($teams,"_");
    }
    $away = array_splice($teams,(count($teams)/2));
    $home = $teams;
    for ($i=0; $i < count($home)+count($away)-1; $i++)
    {
        for ($j=0; $j<count($home); $j++)
        {
            $round[$i][$j]["Home"]=$home[$j];
            $round[$i][$j]["Away"]=$away[$j];
        }
        if(count($home)+count($away)-1 > 2)
        {
            $s = array_splice( $home, 1, 1 );
            $slice = array_shift( $s  );
            array_unshift($away,$slice );
            array_push( $home, array_pop($away ) );
        }
    }
    return $round;
}
?>