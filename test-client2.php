
<?php

error_reporting(E_ALL);

echo "<h2>TCP/IP Connection</h2>\n";
$address = '10.10.75.118';
$port = 80;
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}

echo "Attempting to connect to '$address' on port '$port'...";
$result = socket_connect($socket, $address, $port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}

$in = "HEAD / HTTP/1.1\r\n";
$in .= "Host: 127.0.0.1\r\n";
$in .= "Connection: Close\r\n\r\n";
$out = '';

echo "Sending HTTP HEAD request...";
socket_write($socket, $in, strlen($in));
echo "OK.\n";

echo "Reading response:\n\n";
sleep(3);
$out = socket_read($socket, 2048);
echo $out."\n";
while (false !== ($msg = fgets(STDIN))){
	socket_write($socket, $msg, strlen($msg));
	sleep(3);
	$out = socket_read($socket,2048);
	echo $out."\n";
}
echo "Closing socket...";
socket_close($socket);
echo "OK.\n\n";
