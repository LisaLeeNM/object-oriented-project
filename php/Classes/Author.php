<?php

namespace LisaLeeNM\ObjectOrientedProject;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Author Class
 *
 * This class includes data for author avatar URL, email, hash, and username.
 *
 * @author Lisa Lee <llee28@cnm.edu>
 * @version 0.0.1
 **/
class Author implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * token handed out to verify that the profile is valid and not malicious
	 * @var string $authorActivationToken
	 **/
	private $authorActivationToken;
	/**
	 * avatar URL for this person
	 * @var string $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * email for this person; this is a unique index
	 * @var string $profileEmail
	 **/
	private $authorEmail;
	/**
	 * hash for user password
	 * @var string $authorHash
	 **/
	private $authorHash;
	/**
	 * username for user
	 * @var string $authorUsername
	 **/
	private $authorUsername;

	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId new author id or null if new
	 * @param string $newAuthorActivationToken activation token to safeguard against malicious accounts
	 * @param string $newAuthorAvatarUrl new author avatar URL
	 * @param string $newAuthorEmail contains email
	 * @param string $newAuthorHash contains password hash
	 * @param string $newAuthorUsername contains account holder's username
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newAuthorId, ?string $newAuthorActivationToken, string $newAuthorAvatarUrl, string $newAuthorEmail, string $newAuthorHash, string $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid| string $newAuthorId new value of author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of author activation token
	 **/
	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken);
	}

	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if activation token is not a string
	 **/
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		// verify the author activation token is secure
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		// make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for author avatar URL
	 *
	 * @return string value of author avatar URL
	 **/
	public function getAuthorAvatarUrl(): string {
		return ($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar URL
	 *
	 * @param string $newAuthorAvatarUrl new value of author avatar URL
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is > 255 characters
	 * @throws \TypeError if $newAuthorAvatarUrl is not a string
	 **/
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		// verify the author avatar URL is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("author avatar URL is not a valid string"));
		}
		// verify the author avatar URL will fit in the database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("author avatar URL is too large"));
		}
		// store the author avatar URL
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for author email
	 *
	 * @return string value of author email
	 **/
	public function getAuthorEmail(): string {
		return ($this->authorEmail);
	}

	/**
	 * mutator method for author email
	 *
	 * @param string $newAuthorEmail new value of author email
	 * @throws \InvalidArgumentException if $newAuthorEmail is not valid email or insecure
	 * @throws \RangeException if $newAuthorEmail is > 128 characters
	 * @throws \TypeError if $newAuthorEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail): void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or not secure"));
		}
		// verify the author email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("email content is too large"));
		}
		// store the author email
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for hash
	 *
	 * @return string value of hash
	 **/
	public function getAuthorHash(): string {
		return ($this->authorHash);
	}

	/**
	 * mutator method for hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if hash is not secure
	 * @throws \RangeException if hash is not 97 characters
	 * @throws \TypeError if hash is not a string
	 **/
	public function setAuthorHash(string $newAuthorHash): void {
		// enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		$newAuthorHash = strtolower($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("password hash is empty or insecure"));
		}
		// enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newAuthorHash)) {
			throw(new \InvalidArgumentException("hash is empty or insecure"));
		}
		// enforce that the hash is exactly 97 characters
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		// store the hash
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * accessor method for username
	 *
	 * @return string value of username
	 **/
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}

	/**
	 * mutator method for username
	 *
	 * @param string $newAuthorUsername new value of username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a valid username or insecure
	 * @throws \RangeException if $newAuthorUsername is > 32 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
	 **/
	public function setAuthorUsername(string $newAuthorUsername): void {
		// verify the author username is secure
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("username is empty or insecure"));
		}
		// verify the username will fit in the database
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("username is too large"));
		}
		// store the username
		$this->authorUsername = $newAuthorUsername;
	}

	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE author SET authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind member variable to placeholders
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOExceptions when mySQL related errors occur
	 * @throwos \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorID = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the author id to the placeholder in the template
		//$parameters = ["authorId" => $authorId->getBytes()];
		//$statement->execute($parameters);

		//grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}

	/**
	* gets the Author by avatar URL
	*
	* @param \PDO $pdo PDO connection object
	* @param $authorAvatarUrl author avatar to search by
	* @return \SplFixedArray SplFixedArray of authors with author avatar URL
	* @throws \PDOException when mySQL related errors occur
	**/
	public static function getAuthorByAuthorAvatarUrl(\PDO $pdo, $authorAvatarUrl) : \SplFixedArray {
		try {
				$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorID, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		// bind the author id to the placeholder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($authors);
	}

	/**
	 * Formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();
//		unset($authors["authorHash"]);
		return ($authors);
	}
}