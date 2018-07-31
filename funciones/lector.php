<?php
$gremio = file_get_contents('https://swgoh.gg/g/9977/caballeros-de-la-republica/');
function classtitles($etiqueta,$cadena){
    $pos = strpos($cadena, $etiqueta);
    $pos = strpos($cadena, 'value">',$pos-50);
    $pos2 = strpos($cadena, '<',$pos);
    return (substr($cadena, $pos+7, $pos2-$pos));
}
if (strlen($gremio)<50){die();}
//URl
$pos = strpos($gremio, "og:url");
$pos2 = strpos($gremio, '/>',$pos);
$pos3=($pos2-$pos)-19;
$url = substr($gremio, $pos+17, $pos3);
//Numero Miembros
$pos = strpos($gremio, "Profiles");
$pos2 = strpos($gremio, '/',$pos-10);
$nroM = substr($gremio, $pos2+2, ($pos-$pos2)-3);
//Los otros;
$raid=classtitles("Raid Points",$gremio);
$gp=classtitles("Galactic Power",$gremio);
$gr=classtitles("Guild Rank",$gremio);
$arena=classtitles("Arena Rank",$gremio);
$fecha=date('Y-m-d, h:i:s');
//Miembros
//en principio solo url completa y nombre
$murl=array();$mnombre=array();$marena=array();$mgpc=array();$mgps=array();$mcscore=array();$mnroc=array();
$cnombre=array();$cgear=array();$cstar=array();$cnivel=array();$cpower=array();$ctotal=array();
$pos0=strpos($gremio, "<tbody>");
for ($i=0;$i<$nroM;$i++){
    $pos1=strpos($gremio, "value=",$pos0);
    $pos2=strpos($gremio, ">",$pos1);
    $mnombre[$i]=substr($gremio, $pos1+7, (($pos2-$pos1)-8));
    $pos0=$pos2;
    $pos1=strpos($gremio, "href=",$pos0);
    $pos2=strpos($gremio, ">",$pos1);
    $murl[$i]="https://swgoh.gg".substr($gremio, $pos1+6, (($pos2-$pos1)-7));
    $pos0=$pos2;
}
$i=0;
//for ($i=0;$i<$nroM;$i++){
    $miembro=file_get_contents($murl[$i]);
    //arena
    $pos1=strpos($miembro, "Arena Rank");
    $pos2=strpos($miembro, "</h5>",$pos1);
    $pos1=strpos($miembro, ">",$pos2-4)+1;
    $marena[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    //Galactic Power C
    $pos1=strpos($miembro, "Galactic Power (Characters)")+55;
    $pos2=strpos($miembro, "</strong></p>", $pos1);
    $mgpc[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    $pos0=$pos2;
    //Galactic Power S
    $pos1=strpos($miembro, "Galactic Power (Ships)")+50;
    $pos2=strpos($miembro, "</strong></p>", $pos1);
    $mgps[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    $pos0=$pos2;
    //Collection Score
    $pos1=strpos($miembro, "Collection Score")+42;
    $pos2=strpos($miembro, "</h5>", $pos1);
    $mcscore[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    $pos0=$pos2;
    //Numero Colección
    $pos1=strpos($miembro, "<h5 class=",$pos0);
    $pos2=strpos($miembro, "</h5>", $pos1);
    $pos1=strpos($miembro, ">", ($pos2-10))+1;
    $mnroc[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    $pos0=$pos2;
    //Personajes
    $coleccion=file_get_contents($murl[$i]."collection/");
    /*for ($j=0;$)
    $pos0=strpos($miembro, "player-char-portrait char-portrait-full", $pos0);
    $pos1=strpos($miembro, "href=", $pos0);
    $pos2=strpos($miembro, "class", $pos1);*/
//}
    

//}
print $marena[$i];
?>