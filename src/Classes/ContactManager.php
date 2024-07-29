<?php

class ContactManager
{
	public function findAll(): array
	{
		$db = DBConnect::getInstance();
		$pdo = $db->getPDO();
		$query = $pdo->prepare("SELECT * FROM contact");
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
		$contacts = [];

		foreach ($results as $result) {
			$contacts[] = new Contact(
				$result['id'] ?? null,
				$result['name'] ?? null,
				$result['email'] ?? null,
				$result['phone_number'] ?? null
			);
		}

		return $contacts;
	}

	public function findById(int $id): ?Contact
	{
		$db = DBConnect::getInstance();
		$pdo = $db->getPDO();
		$query = $pdo->prepare("SELECT * FROM contact WHERE id = :id");
		$query->execute(['id' => $id]);
		$result = $query->fetch(PDO::FETCH_ASSOC);

		if ($result) {
			return new Contact(
				$result['id'] ?? null,
				$result['name'] ?? null,
				$result['email'] ?? null,
				$result['phone_number'] ?? null
			);
		}

		return null;
	}

	public function create(string $name, string $email, string $phone_number): bool
	{
		try {
			$db = DBConnect::getInstance();
			$pdo = $db->getPDO();
			$query = $pdo->prepare("INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)");
			return $query->execute(['name' => $name, 'email' => $email, 'phone_number' => $phone_number]);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}

	public function delete(int $id): bool
	{
		try {
			$db = DBConnect::getInstance();
			$pdo = $db->getPDO();
			$query = $pdo->prepare("DELETE FROM contact WHERE id = :id");
			return $query->execute(['id' => $id]);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}

	public function update(Contact $contact): bool
	{
		try {
			$db = DBConnect::getInstance();
			$pdo = $db->getPDO();
			$query = $pdo->prepare("UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id");
			return $query->execute([
				'id' => $contact->getId(),
				'name' => $contact->getName(),
				'email' => $contact->getEmail(),
				'phone_number' => $contact->getPhoneNumber()
			]);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
			return false;
		}
	}
}