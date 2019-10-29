<?php
require_once('../Classes/Author.php');

use LisaLeeNM\ObjectOrientedProject\Author;

$madeleine = new Author ("9f2da971-bede-4ed5-b302-f43d51feed9e", "650210012845ab1cfab265021001284c", "https://simple.wikipedia.org/wiki/Hexadecimal", "lisa.lee.nm@gmail.com", "d3e1c5f0e26b71d0e4fda169980682dab36647604fb95d68d0120692a8da1fd60d50b7b8c3bc2e2e9fafe6e6e3a1f1eb5", "madegupta23");

echo("Author ID: ");
echo($madeleine -> getAuthorId());
echo(" <br>Author Activation Token: ");
echo($madeleine ->  getAuthorActivationToken());
echo(" <br>Author Avatar URL: ");
echo($madeleine -> getAuthorAvatarUrl());
echo(" <br>Author Email: ");
echo($madeleine -> getAuthorEmail());
echo(" <br>Author Hash: ");
echo($madeleine -> getAuthorHash());
echo(" <br>Author Username: ");
echo($madeleine -> getAuthorUsername());