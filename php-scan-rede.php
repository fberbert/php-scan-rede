<?php
/*
Programado por: Fábio Berbert de Paula <fberbert@gmail.com>
Simples scanner de rede em PHP. Ele irá imprimir na tela a lista de todos os hosts ativos em determinada rede.
*/

/* 
CONFIGURE TUA REDE AQUI -------------------------
*/
$network= "192.168.0."; //omitir a casa do IP
$from = "1"; //começa no IP 1
$to = "255"; //termina no IP 255
$show_up_only = true; //mostrar apenas hosts up, mude para "false" para mostrar todos


$nodes = array(); // criar um array vazio para armazenar os hosts da rede
/* Formato do array "nodes"
Array
(
    [0] => Array
        (
            [ip] => 192.168.0.1
            [status] => down
        )

    [1] => Array
        (
            [ip] => 192.168.0.2
            [status] => down
        )

    [2] => Array
        (
            [ip] => 192.168.0.3
            [status] => down
        )
...
)
*/

//inicializar o array nodes com todos os hosts da rede e status inicial como "down"
for ($i=$from; $i<=$to; $i++) {

    array_push($nodes, [ 
        "ip" => $network . $i, 
        "status" => "down" 
    ]);

}

//efetuar a varredura de rede
foreach ($nodes as $key => $node) {
    //recuperar valores
    list($ip, $status) = array_values($node);

    //testar o host
    exec("ping -c 1 $ip", $output, $real_status);

    $status = ($real_status==0) ? "up" : "down";

    //atualizar status no array
    $nodes[$key]['status'] = $status; 

    if ($show_up_only && $status=="down") continue;

    echo "$ip - $status\n";
}
?>
