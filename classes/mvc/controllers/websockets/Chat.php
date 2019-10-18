<?php
	
	
	namespace mvc_router\mvc\controllers\websockets;
	
	use mvc_router\websockets\MessageComponent;
	use Ratchet\ConnectionInterface;
	
	class Chat extends MessageComponent {
		public function onOpen( ConnectionInterface $conn ) {
			// Store the new connection to send messages to later
			$this->clients->attach( $conn );
			echo "New connection! ({$conn->resourceId})\n";
		}
		
		public function onMessage( ConnectionInterface $from, $msg ) {
			$numRecv = count( $this->clients ) - 1;
			echo sprintf( 'Connection %d sending message "%s" to %d other connection%s'."\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's' );
			$this->sendBroadcast( $from, $msg );
		}
		
		public function onClose( ConnectionInterface $conn ) {
			// The connection is closed, remove from connection list
			$this->clients->detach( $conn );
			echo "Connection {$conn->resourceId} has disconnected\n";
		}
		
		public function onError( ConnectionInterface $conn, \Exception $e ) {
			echo "An error has occurred: {$e->getMessage()}\n";
			$conn->close();
		}
	}