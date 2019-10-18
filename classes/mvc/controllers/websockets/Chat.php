<?php
	
	
	namespace mvc_router\mvc\controllers\websockets;
	
	use mvc_router\services\Logger;
	use mvc_router\websockets\MessageComponent;
	use Ratchet\ConnectionInterface;
	
	class Chat extends MessageComponent {
		/** @var \mvc_router\confs\custom\Mysql $mysql */
		public $mysql;
		
		/** @var \mvc_router\services\Logger $logger */
		public $logger;
		
		public function __construct() {
			parent::__construct();
			$this->logger->types(Logger::CONSOLE);
		}
		
		public function onOpen( ConnectionInterface $conn ) {
			// Store the new connection to send messages to later
			$this->clients->attach( $conn );
			if(!$this->mysql->is_connected()) {
				$this->mysql->connect();
			}
			if($this->mysql->is_connected()) {
				$this->logger->log( 'Connecting to the MySQL server successfully !' );
			}
			if( !empty( $conn->resourceId ) ) {
				$this->logger->log("New connection ! ({$conn->resourceId})");
			}
		}
		
		public function onMessage( ConnectionInterface $from, $msg ) {
			$numRecv = count( $this->clients ) - 1;
			if( !empty( $from->resourceId ) ) {
				$this->logger->log(sprintf( 'Connection %d sending message "%s" to %d other connection%s', $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's' ));
			}
			$this->sendBroadcast( $from, $msg );
		}
		
		public function onClose( ConnectionInterface $conn ) {
			// The connection is closed, remove from connection list
			$this->clients->detach( $conn );
			if( !empty( $conn->resourceId ) ) {
				$this->logger->log("Connection {$conn->resourceId} has disconnected !");
			}
			$this->mysql->close();
		}
		
		public function onError( ConnectionInterface $conn, \Exception $e ) {
			$this->logger->log("An error has occurred: {$e->getMessage()}");
			$conn->close();
		}
	}