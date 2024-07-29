<?php

class App
{
	private Command $command;

	public function __construct()
	{
		$this->command = new Command();
	}

	public function run(): void
	{
		while (true) {
			$line = readline("Write down your command : ");

			if ($line === "list") {
				$this->command->list();
			} elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
				$id = (int)$matches[1];
				$this->command->detail($id);
			} elseif (preg_match('/^create ([^,]+),([^,]+),([^,]+)$/', $line, $matches)) {
				$name = trim($matches[1]);
				$email = trim($matches[2]);
				$phone_number = trim($matches[3]);
				$this->command->create($name, $email, $phone_number);
			} elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
				$id = (int)$matches[1];
				$this->command->delete($id);
			} elseif (preg_match('/^modify (\d+),([^,]*),([^,]*),([^,]*)$/', $line, $matches)) {
				$id = (int)$matches[1];
				$name = trim($matches[2]) ?: null;
				$email = trim($matches[3]) ?: null;
				$phone_number = trim($matches[4]) ?: null;
				$this->command->modify($id, $name, $email, $phone_number);
			} elseif ($line === "help") {
				$this->command->help();
			} elseif ($line === "exit") {
				echo "Exiting the program. Goodbye!\n";
				exit;
			} else {
				echo "You wrote : $line\nUnknown command.\n";
			}
		}
	}
}