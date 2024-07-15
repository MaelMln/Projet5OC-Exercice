<?php

require 'commands.php';

$command = new Command();

while (true) {
	$line = readline("Write down your command : ");

	if ($line === "list") {
		$command->list();
	} elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
		$id = (int)$matches[1];
		$command->detail($id);
	} elseif (preg_match('/^create ([^,]+),([^,]+),([^,]+)$/', $line, $matches)) {
		$name = trim($matches[1]);
		$email = trim($matches[2]);
		$phone_number = trim($matches[3]);
		$command->create($name, $email, $phone_number);
	} elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
		$id = (int)$matches[1];
		$command->delete($id);
	} elseif (preg_match('/^modify (\d+),([^,]*),([^,]*),([^,]*)$/', $line, $matches)) {
		$id = (int)$matches[1];
		$name = trim($matches[2]) ?: null;
		$email = trim($matches[3]) ?: null;
		$phone_number = trim($matches[4]) ?: null;
		$command->modify($id, $name, $email, $phone_number);
	} elseif ($line === "help") {
		$command->help();
	} else {
		echo "You wrote : $line\nUnknown command.\n";
	}
}

?>
