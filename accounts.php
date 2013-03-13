<?php
/*
 * A Couple of sample Account Data because I don't feel like creating a DB System with CRUD for that
 */
return
	array (
		1 => array(			// keep same as ID
			'id' => 1,
			'username' => 'Admin',
			'password' => '$2y$10$0o..MIiftequlSGAj8YCDeDVRel6rrvmuQmq8w3HZaX7GjZFcmYi.', // hashed version of Admin
			'isNew' => false,
		),
		2 => array(
			'id' => 2,		// keep same as ID
			'username' => 'CookieMonster',
			'password' => '$2y$10$gb3e3q676lC8l5f/KkZDdeHBPlkOfJcw85fUGQqMByr1gZBch0OjG', // hashed version of CookieMonster
			'isNew' => false,
		),
	);
?>