<?php

class DBConnect
{
	private static ?self $instance = null;
	private PDO $pdo;

	private function __construct()
	{
		try {
			$this->pdo = new PDO('mysql:host=mysql;dbname=Projet-MVC-OC;charset=utf8', 'root', '123456789');
		} catch (Exception $e) {
			die('Error : ' . $e->getMessage());
		}
	}

	public static function getInstance(): self
	{
		if (self::$instance === null) {
			self::$instance = new DBConnect();
		}
		return self::$instance;
	}

	public function getPDO(): PDO
	{
		return $this->pdo;
	}
}