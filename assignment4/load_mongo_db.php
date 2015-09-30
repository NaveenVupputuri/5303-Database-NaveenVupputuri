//Name:Naveen Sai Vupputuri
//5303-Advanced Database
<?php
//databse connection
$connection=new MongoClient();
//database selection
$db=$connection->nvupputuri;
//selecting the table in database
$rpCol=$db->random_people;
//getting 1000 random users from randomuser
$json = file_get_contents("http://api.randomuser.me/?results=1000");
$json_array=json_decode($json);

//inserting random users into random_people collection 
for($i=0;$i<sizeof($json_array->results);$i++)
{
	$rpCol->insert($json_array->results[$i]);
}

?>