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
		$newAuthorId = filter_var($newAuthorId, FILTER_VALIDATE_INT);

	}
}
?>