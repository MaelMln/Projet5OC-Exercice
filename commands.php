<?php

require 'classes.php';

class Command {
	private ContactManager $contactManager;

	public function __construct() {
		$this->contactManager = new ContactManager();
	}

	public function list(): void {
		$contactList = $this->contactManager->findAll();
		foreach ($contactList as $contact) {
			echo $contact . "\n";
		}
	}

	public function detail(int $id): void {
		$contact = $this->contactManager->findById($id);
		if ($contact) {
			echo $contact . "\n";
		} else {
			echo "Contact not found.\n";
		}
	}

	public function create(string $name, string $email, string $phone_number): void {
		$success = $this->contactManager->create($name, $email, $phone_number);
		if ($success) {
			echo "Contact created successfully.\n";
		} else {
			echo "Failed to create contact.\n";
		}
	}

	public function delete(int $id): void {
		$success = $this->contactManager->delete($id);
		if ($success) {
			echo "Contact deleted successfully.\n";
		} else {
			echo "Failed to delete contact.\n";
		}
	}

	public function modify(int $id, ?string $name, ?string $email, ?string $phone_number): void {
		$contact = $this->contactManager->findById($id);
		if ($contact) {
			if ($name) $contact->setName($name);
			if ($email) $contact->setEmail($email);
			if ($phone_number) $contact->setPhoneNumber($phone_number);
			$success = $this->contactManager->update($contact);
			if ($success) {
				echo "Contact updated successfully.\n";
			} else {
				echo "Failed to update contact.\n";
			}
		} else {
			echo "Contact not found.\n";
		}
	}

	public function help(): void {
		echo "Available commands:\n";
		echo "list - List all contacts\n";
		echo "detail [id] - Show details of a contact\n";
		echo "create [name],[email],[phone_number] - Create a new contact\n";
		echo "modify [id],[name],[email],[phone_number] - Modify a contact\n";
		echo "delete [id] - Delete a contact\n";
	}
}

?>
