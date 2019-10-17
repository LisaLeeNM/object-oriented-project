<?php
/**
 * Author Class
 *
 * This class includes data for author avatar URL, email, hash, and username.
 *
 * @author Lisa Lee <llee28@cnm.edu>
 **/
class Author {
	/**
	 * id for Author; this is the primary key
	 **/
	private $authorId;
	/**
	 * activation token for this person
	 **/
	private $authorActivationToken;
	/**
	 * avatar URL for this person
	 **/
	private $authorAvatarUrl;
	/**
	 * email for this person
	 **/
	private $authorEmail;
	/**
	 * hash for this person
	 **/
	private $authorHash;
	/**
	 * username for this person
	 **/
	private $authorUsername;

	/**
	 * constructor for this Author
	 *
	 * @param int $newAuthorId new author id
	 * @param string $newAuthorActivationToken new author activation token
	 * @param string $newAuthorAvatarUrl new author avatar URL
	 * @param string $newAuthorEmail new author email
	 * @param string $newAuthorHash new author hash
	 * @param string $newAuthorUsername new author username
	 * @throws UnexpectedValueException if any of the parameters are invalid
	 **/
	public function __construct($newAuthorId, $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		} catch(UnexpectedValueException $exception) {
			// rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Author", 0, $exception));
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
}
?>