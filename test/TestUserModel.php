<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 24-9-15 - 12:02
 * Licence: GPLv3
 */

require( "header.php" );

$userModel = new \CWAuth\Models\User();

echo "<h2>Get Statments</h2>";

echo "<h3>get by username</h3>";
var_dump( $userModel->getByUsername( "jorisrietveld" ) );

echo "<h3>get by email</h3>";
var_dump( $userModel->getByEmail( "jorisrietveld@gmail.com" ) );

echo "<h3>get by id</h3>";
var_dump( $userModel->getById(1));

echo "<h2>Update statments:</h2>";

echo "<h3>update Username</h3>";
var_dump( $userModel->updateUsername( 1, "jorisrietveld1" ) );

echo "<h3>update email</h3>";
var_dump( $userModel->updateEmail( 1, "jorisrietveld@gmail.com.nl" ) );

echo "<h3>update password</h3>";
var_dump( $userModel->updatePassword( 1, "password1" ) );

echo "<h2>Insert Statments</h2>";

echo "<h3>Insert user</h3>";
var_dump( $userModel->insertUser( "joris", "password", "email@email.com"));

echo "<h2>Delete Statements</h2>";
var_dump( $userModel->deleteUserById( 1 ));