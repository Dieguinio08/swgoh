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
$Nombre="caballeros-de-la-republica";//Arreglar
$Numero=9977;//Arreglar
//Los otros;
$raid=classtitles("Raid Points",$gremio);
$gp=classtitles("Galactic Power",$gremio);
$gp=str_replace(",","",$gp);
$gr=classtitles("Guild Rank",$gremio);
$arena=classtitles("Arena Rank",$gremio);
$fecha=date('Y-m-d');
print 'insert into gremio (Nombre, Url, Numero, Raid, NMiembros, Poder, Rango, Arena, Fecha) values (
    "'.$Nombre.'","'.$url.'","'.$Numero.'", "'.$raid.'", "'.$nroM.'", "'.$gp.'","'.$gr.'","'.$arena.'","'.$fecha.'");'; 
//Miembros
//en principio solo url completa y nombre
$murl=array();$mnombre=array();$marena=array();$mgpc=array();$mgps=array();$mcscore=array();$mnroc=array();$aliado=array();
$usuario=array();
$cnombre=array();$cgear=array();$cstar=array();$cnivel=array();$cpower=array();$ctotal=array();$curl=array();
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
for ($i=0;$i<$nroM;$i++){
    $miembro=file_get_contents($murl[$i]);
    //usuario
    $usuario[$i]=0;//arreglar
    //aliado
    $pos1=strpos($miembro, "<p>Ally Code");
    if(!empty($pos1)){
        $pos2=strpos($miembro, "</strong>",$pos1);
        $pos1=$pos1+40;
        $aliado[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    }else{$aliado[$i]=0;}
    //arena
    $pos1=strpos($miembro, "Arena Rank");
    $pos2=strpos($miembro, "</h5>",$pos1);
    $pos1=strpos($miembro, ">",$pos2-6)+1;
    $marena[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    //Galactic Power C
    $pos1=strpos($miembro, "Galactic Power (Characters)")+55;
    $pos2=strpos($miembro, "</strong></p>", $pos1);
    $mgpc[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    $mgpc[$i]=str_replace(",","",$mgpc[$i]);
    $pos0=$pos2;
    //Galactic Power S
    $pos1=strpos($miembro, "Galactic Power (Ships)")+50;
    $pos2=strpos($miembro, "</strong></p>", $pos1);
    $mgps[$i]=substr($miembro, $pos1, ($pos2-$pos1));
    $mgps[$i]=str_replace(",","",$mgps[$i]);
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
    print 'insert into miembros (Nombre, Url, Usuario, Aliado, NPersonajes, PoderC, PoderS, PColeccion, Arena, Gremmio, Fecha ) values (
        "'.$mnombre[$i].'", "'.$murl[$i].'","'.$usuario[$i].'", "'.$aliado[$i].'", "'.$mnroc[$i].'", "'.$mgpc[$i].'","'.$mgps[$i].'","'.$mcscore[$i].'","'.$marena[$i].'","'.$Numero.'","'.$fecha.'");';
    //Personajes
    $coleccion=file_get_contents($murl[$i]."collection/");
    $pos0=0;
    for ($j=0;$j<$mnroc[$i];$j++){
        //url
        $pos0=strpos($coleccion, "player-char-portrait char-portrait-full", $pos0);
        $pos1=strpos($coleccion, "href=", $pos0)+6;
        $pos2=strpos($coleccion, "class", $pos1)-2;
        $curl[$i][$j]="https://swgoh.gg".substr($coleccion, $pos1, ($pos2-$pos1));
        $pos0=$pos2;
        //Nombre
        switch (substr($curl[$i][$j],-5)) {
            case "cody/":
                $cnombre[$i][$j]="CC-2224 Cody";
                break;
            case "ives/":
                $cnombre[$i][$j]="CT-5555 Cincos";
                break;
            case "echo/":
                $cnombre[$i][$j]="CT-21-0408 Echo";
                break;
            case "-rex/":
                $cnombre[$i][$j]="CT-7567 Rex";
                break;
            case "lios/":
                $cnombre[$i][$j]="Garazeb Zeb Orrelios";
                break;
            default:
            $pos1=strpos($coleccion, "alt=", $pos0)+5;
            $pos2=strpos($coleccion, "height=", $pos1)-3;
            $cnombre[$i][$j]=substr($coleccion, $pos1, ($pos2-$pos1));
            $pos0=strpos($coleccion, ">", $pos2);
        }
        //estrellas
        $pos1=strpos($coleccion, "star-inactive", $pos0);
        if ((!empty($pos1)) && (($pos1-$pos0)<270)){$cstar[$i][$j]=substr($coleccion, $pos1-2,1);}else{$cstar[$i][$j]=7;}
        $pos0=$pos2;
        //Nivel
        $pos1=strpos($coleccion, "char-portrait-full-level", $pos0)+26;
        $pos2=strpos($coleccion, "</div>", $pos1);
        $cnivel[$i][$j]=substr($coleccion, $pos1, ($pos2-$pos1));
        $pos0=$pos2;
        //gear
        $pos1=strpos($coleccion, "char-portrait-full-gear-level", $pos0)+31;
        $pos2=strpos($coleccion, "</div>", $pos1);
        $cgear[$i][$j]=substr($coleccion, $pos1, ($pos2-$pos1));
        $pos0=$pos2;
        //Poder
        $pos1=strpos($coleccion, "Power", $pos0)+6;
        $pos2=strpos($coleccion, "/", $pos1)-1;
        $cpower[$i][$j]=substr($coleccion, $pos1, ($pos2-$pos1));
        $cpower[$i][$j]=str_replace(",","",$cpower[$i][$j]);
        $pos0=$pos2;
        //Total
        $pos1=strpos($coleccion, "collection-char-gp-progress-bar", $pos0)+47;
        $pos2=strpos($coleccion, "%", $pos1);
        $ctotal[$i][$j]=substr($coleccion, $pos1, ($pos2-$pos1));
        $pos0=$pos2;
        print 'insert into coleccionesp (Nombre, Url, Estrellas, Nivel, Gear, Poder, Avance, Usuario, Fecha) values (
            "'.$cnombre[$i][$j].'", "'.$curl[$i][$j].'", "'.$cstar[$i][$j].'", "'.$cnivel[$i][$j].'", "'.$cgear[$i][$j].'","'.$cpower[$i][$j].'","'.$ctotal[$i][$j].'","'.$usuario[$i].'","'.$fecha.'");';
    }
}sleep(0.5);
?>