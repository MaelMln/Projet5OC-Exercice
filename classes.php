<?php

class DBConnect {
	public function getPDO() {
		try {
			$mysqlClient = new PDO('mysql:host=mysql;dbname=Projet-MVC-OC;charset=utf8', 'root', '123456789');
			return $mysqlClient;
		} catch (Exception $e) {
			die('Error : ' . $e->getMessage());
		}
	}
}

class ContactManager {
	public function findAll(): array {
		$db = new DBConnect();
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

	public function findById(int $id): ?Contact {
		$db = new DBConnect();
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

	public function create(string $name, string $email, string $phone_number): bool {
		$db = new DBConnect();
		$pdo = $db->getPDO();
		$query = $pdo->prepare("INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone_number)");
		return $query->execute(['name' => $name, 'email' => $email, 'phone_number' => $phone_number]);
	}

	public function delete(int $id): bool {
		$db = new DBConnect();
		$pdo = $db->getPDO();
		$query = $pdo->prepare("DELETE FROM contact WHERE id = :id");
		return $query->execute(['id' => $id]);
	}

	public function update(Contact $contact): bool {
		$db = new DBConnect();
		$pdo = $db->getPDO();
		$query = $pdo->prepare("UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id");
		return $query->execute([
			'id' => $contact->getId(),
			'name' => $contact->getName(),
			'email' => $contact->getEmail(),
			'phone_number' => $contact->getPhoneNumber()
		]);
	}
}

class Contact {
	private ?int $id;
	private ?string $name;
	private ?string $email;
	private ?string $phone_number;

	public function __construct(?int $id = null, ?string $name = null, ?string $email = null, ?string $phone_number = null) {
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->phone_number = $phone_number;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(?string $name): void {
		$this->name = $name;
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail(?string $email): void {
		$this->email = $email;
	}

	public function getPhoneNumber(): ?string {
		return $this->phone_number;
	}

	public function setPhoneNumber(?string $phone_number): void {
		$this->phone_number = $phone_number;
	}

	public function __toString(): string {
		return "Contact [ID: $this->id, Name: $this->name, Email: $this->email, Phone Number: $this->phone_number]";
	}
}

?>
