<?php
error_reporting(0);
$db = new mysqli('localhost', 'nvupputuri', 'Vupputuri@1991', 'nvupputuri');

if($db->connect_errno > 0)
{
    die('Unable to connect to database [' . $db->connect_error . ']');
}
//echo " Connection to database";

$json = file_get_contents("http://api.randomuser.me/?results=1000");

$json_array = json_decode($json);

print_r( "<table><tr><th>Gender</th><th>Title</th><th>First Name</th><th>Last Name</th><th>Street</th><th>city</th><th>State</th><th>Zip</th><th>Email</th><th>Username</th><th>Password</th><th>DOB</th><th>Phone</th><th>Picture</th></tr>");
for( $i=0 ; $i<sizeof($json_array->results) ; $i++ )
{
	$eid = $json_array->results[$i]->user->email;
	$sql1 = <<<SQL
	select * from users where Email='{$eid}';
SQL;
	if(!$result1 = $db->query($sql1))
	{
		die('There was an error running the query [' . $db->error . ']');
	}		
	if($result1->num_rows==0)
	{
		$gen = $json_array->results[$i]->user->gender;
		$titl = $json_array->results[$i]->user->name->title;
		$fname = $json_array->results[$i]->user->name->first;
		$lname = $json_array->results[$i]->user->name->last;
		$st = $json_array->results[$i]->user->location->street;
		$cty = $json_array->results[$i]->user->location->city;
		$stat = $json_array->results[$i]->user->location->state;
		$zp = $json_array->results[$i]->user->location->zip;
		$uname = $json_array->results[$i]->user->username;
		$pwd = $json_array->results[$i]->user->password;
		$dob = $json_array->results[$i]->user->dob;
		$ph = $json_array->results[$i]->user->phone;
		$pic = $json_array->results[$i]->user->picture->medium;
		print_r ( "<tr><td>'$gen'</td><td>'$titl'</td><td>'$fname'</td><td>'$lname'</td><td>'$st'</td><td>'$cty'</td><td>'$stat'</td><td>'$zp'</td><td>'$eid'</td><td>'$uname'</td><td>'$pwd'</td><td>'$dob'</td><td>'$ph'</td><td>'$pic'</td></tr>");
		
		$sql2 = <<<SQL
		INSERT into users
		VALUES('$gen','$titl','$fname','$lname','$st','$cty','$stat','$zp','$eid','$uname','$pwd','$dob','$ph','$pic'); 
SQL;
		if(!$result2 = $db->query($sql2))
		{
			die('There was an error running the query [' . $db->error . ']');	
		}
	}
	
}
print_r ( "</table>");

?>