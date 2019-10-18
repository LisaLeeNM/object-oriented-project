<?php

namespace LisaLeeNM\ObjectOrientedProject;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use http\QueryString;
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
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			// rethrow to the caller
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId() : Uuid {
		return($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid|string $newAuthorId new value of author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 **/
	public function setAuthorId( $newAuthorId) : void {
		try {
				$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->authorId = $uuid);
	}

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of author activation token
	 **/
	public function getAuthorActivationToken() : string {
		return($this->authorActivationToken);
	}

	/**
	 * mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken new value of author activation token
	 * @throws \InvalidArgumentException if $newAuthorActivationToken is not a string or insecure
	 * @throws \RangeException if $newAuthorActivationToken is > 32 characters
	 * @throws \TypeError if $newAuthorActivationToken is not a string
	 **/
	public function setAuthorActivationToken(string $newAuthorActivationToken) : void {
		// verify the author activation token is valid
		$newAuthorActivationToken = trim($newAuthorActivationToken);
		$newAuthorActivationToken = filter_var($$newAuthorActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorActivationToken === true) {
			throw(new \InvalidArgumentException("author activation token is not a valid string"));
		}

		// verify the activation token fits in the database
		if(strlen($newAuthorActivationToken) > 32) {
			throw(new \RangeException("activation token is too long"));
		}

		// store the author activation token
		$this->authorActivationToken = $newAuthorActivationToken;
	}

	/**
	 * accessor method for author avatar URL
	 *
	 * @return string value of author avatar URL
	 **/
	public function getAuthorAvatarUrl() : string {
		return($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar URL
	 *
	 * @param string $newAuthorAvatarUrl new value of author avatar URL
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is > 255 characters
	 * @throws \TypeError if $newAuthorAvatarUrl is not a string
	 **/
	public function setAuthorAvatarUrl($newAuthorAvatarUrl) : void {
		// verify the author avatar URL is valid
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl === true) {
			throw(new \InvalidArgumentException("author avatar URL is not a valid string"));
		}

		// verify the author avatar URL will fit in the database
		if(strlen($newAuthorAvatarUrl) > 255)
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
	public function getAuthorEmail() : string {
		return($this->authorEmail);
	}

	/**
	 * mutator method for author email
	 *
	 * @param string $newAuthorEmail new value of author email
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a string or insecure
	 * @throws \RangeException if $newAuthorEmail is > 128 characters
	 * @throws \TypeError if $newAuthorEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail) : void {
		// verify the author email is valid
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorEmail === true) {
			throw(new \InvalidArgumentException("author email is empty or not a valid string"));
		}

		// verify the author email will fit the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email content is too large"));
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