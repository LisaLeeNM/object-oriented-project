<?php

namespace LisaLeeNM\ObjectOrientedProject;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

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
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for Author; this is the primary key
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
	 * @var $authorUsername
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
	public function __construct($newAuthorId, $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		}
			// determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception)
			$exceptionType = get_class($exception);
			// rethrow to the caller
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for author id
	 *
	 * @return int value of author id
	 **/
	public function getAuthorId() {
		return($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param int $newAuthorId new value of author id
	 * @throws UnexpectedValueException if $newAuthorId is not an integer
	 **/
	public function setAuthorId($newAuthorId) {
		// verify the author id is valid
		$newAuthorId = filter_var($newAuthorId, FILTER_VALIDATE_INT);
		if($newAuthorId === false) {
			throw(new UnexpectedValueException("author id is not a valid integer"));
		}

		// convert and store the author id
		$this->authorId = intval($newAuthorId);
	}

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of author activation token
	 **/
	public function getAuthorActivationToken() {
		return($this->authorActivationToken);
	}

	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken new value of author activation token
	 * @throws UnexpectedValueException if $newAuthorActivationToken is not valid
	 **/
	public function setAuthorActivationToken($newAuthorActivationToken) {
		// verify the author activation token is valid
		$newAuthorActivationToken = filter_var($newAuthorActivationToken, FILTER_SANITIZE_STRING);
		if($newAuthorActivationToken === false) {
			throw(new UnexpectedValueException("author activation token is not a valid string"));
		}

		// store the author activation token
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for author avatar URL
	 *
	 * @return string value of author avatar URL
	 **/
	public function getAuthorAvatarUrl() {
		return($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar URL
	 *
	 * @param string $newauthorAvatarUrl new value of author avatar URL
	 * @throws UnexpectedValueException if $newAuthorAvatarUrl is not valid
	 **/
	public function setAuthorAvatarUrl($newAuthorAvatarUrl) {
		// verify the author avatar URL is valid
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING);
		if($newAuthorAvatarUrl === false) {
			throw(new UnexpectedValueException("author avatar URL is not a valid string"));
		}

		// store the author avatar URL
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for author email
	 *
	 * @return string value of author email
	 **/
	public function getAuthorEmail() {
		return($this->authorEmail);
	}

	/**
	 * mutator method for author email
	 *
	 * @param string $newAuthorEmail new value of author email
	 * @throws UnexpectedValueException if $newAuthorEmail is not valid
	 **/
	public function setAuthorEmail($newAuthorEmail) {
		// verify the author email is valid
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_SANITIZE_STRING);
		if($newAuthorEmail === false) {
			throw(new UnexpectedValueException("author email is not a valid string"));
		}

		// store the author email
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for author hash
	 *
	 * @return string value of author hash
	 **/
	public function getAuthorHash() {
		return($this->authorHash);
	}

	/**
	 * mutator method for author hash
	 *
	 * @param string $newAuthorHash new value of author hash
	 * @throws UnexpectedValueException if $newAuthorHash is not valid
	 **/
	public function setAuthorHash($newAuthorHash) {
		// verify the author hash is valid
		$newAuthorHash = filter_var($newAuthorHash, FILTER_SANITIZE_STRING);
		if($newAuthorHash === false) {
			throw(new UnexpectedValueException("author hash is not a valid string"));
		}

		// store the author hash
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * accessor method for author username
	 *
	 * @return string value of author username
	 **/
	public function getAuthorUsername() {
		return($this->authorUsername);
	}

	/**
	 * mutator method for author username
	 *
	 * @param string $newAuthorUsername new value of author username
	 * @throws UnexpectedValueException if $newAuthorUsername is not valid
	 **/
	public function setAuthorUsername($newAuthorUsername) {
		// verify the author username is valid
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING);
		if($newAuthorUsername === false) {
			throw(new UnexpectedValueException("author username is not a valid string"));
		}

		// store the author username
		$this->authorUsername = $newAuthorUsername;
	}

	/**
	 * toString() magic method
	 *
	 * @return string HTML formatted author
	 **/
	public function __toString() {
		// create an HTML formatted Author
		$html = "<p>Author id: " . $this->authorId
				. "Author activation token: " . $this->authorActivationToken . "<br />"
				. "Author avatar URL: "       . $this->authorAvatarUrl       . "<br />"
				. "Author email: "            . $this->authorEmail           . "<br />"
				. "Author hash: "             . $this->authorHash            . "<br />"
				. "Author username: "         . $this->authorUsername
				. "</p>";
			return($html);
	}
}
?>