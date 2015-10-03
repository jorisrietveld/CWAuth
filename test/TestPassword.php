<?php
/**
 * Author: Joris Rietveld <jorisrietveld@protonmail.com>
 * Date: 25-9-15 - 12:21
 * Licence: GPLv3
 */

require( "header.php" );

try
{
	$password = "abc123";
	//$hash = '$2y$11$gR97fbtpscafnh7Sh9Fkz.er2HLF3FQSeZ5fetqFNXFdBB0ZPxfDa';
	$options = [ "algo" => PASSWORD_DEFAULT ];

	$passwordModel = new \CWAuth\Models\Password();

	echo "<h3>passwordHash</h3>";
	$hash = $passwordModel->passwordHash( $password, $options );
	echo $hash;

	echo "<h3>password check</h3>";
	var_dump( $passwordModel->passwordCheck( $password, $hash ) );

	echo "<h3>password needs rehash</h3>";
	var_dump( $passwordModel->passwordNeedsRehash( $hash, $password ) );

	echo "<h3>password information</h3>";
	var_dump( $passwordModel->getPasswordInformation( $hash ) );

	echo "<h3>options set for hashing</h3>";
	var_dump( $passwordModel->getHashingOptions() );
}
catch( LogicException $logicE )
{
	echo "<h1>Logic exception</h1>";
	var_dump( $logicE );
}
catch( PDOException $pdoE )
{
	echo "<h1>Pdo exception</h1>";
	var_dump( $pdoE );
}
catch( Exception $e )
{
	echo "<h1>Exception</h1>";
	var_dump( $e );
}
finally
{
	echo "Code run yeay.";
}

