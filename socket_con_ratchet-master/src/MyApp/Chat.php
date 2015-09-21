<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;



class Chat implements MessageComponentInterface {
  protected $clients;
  protected $conectados;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->conectados = array();
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $parametros = $conn->WebSocket->request->getQuery();
        $login = $parametros->getData();
        $this->conectados[] = array("id_usuario"=>$login['id'],"login"=>$login['login'],"conexion_socket"=>$conn->resourceId);
        $this->clients->attach($conn);
        foreach ($this->clients as $client) {
            $client->send(json_encode($this->conectados));
        }
        
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Conexión %d enviando mensaje "%s" a %d otras conexiones%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
      
        foreach ($this->clients as $client) {
                $client->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        
        for ($i=0; $i < count($this->conectados) ; $i++) { 
            if (isset($this->conectados[$i]) and  $this->conectados[$i]['conexion_socket'] == $conn->resourceId) {
                unset($this->conectados[$i]);
                $this->conectados = array_values($this->conectados);
                var_dump($this->conectados);
            }
        }
        echo "Conexión {$conn->resourceId} se desconecto  \n";
        foreach ($this->clients as $client) {
            $client->send(json_encode($this->conectados));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Un error ha ocurrido: {$e->getMessage()}\n";
        
        $conn->close();
    }
}