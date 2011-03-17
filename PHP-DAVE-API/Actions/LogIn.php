<?php

/***********************************************
Evan Tahler
evantahler@gmail.com
2010

I am an example function to view a user.
If "this" user is viewing (indicated by propper password hash along with another key, all data is shown), otherwise, just basic info is returned
***********************************************/

if ($ERROR == 100){ require("CheckSafetyString.php"); }

if ($ERROR == 100)
{
	list($pass,$result) = _VIEW("Users");
	if (!$pass){ $ERROR = $result; }
}

if ($ERROR == 100)
{
	if (strlen($Password) > 0)
	{
		$PasswordHash = md5($Password.$result[0]['Salt']);
	}
	if ($PasswordHash == $result[0]['PasswordHash']) // THIS user
	{
		$OUTPUT['LOGIN'] = "TRUE";
		$OUTPUT['SessionKey'] = create_session();
		$SessionData = array();
		$SessionData["login_time"] = time();
		$userData = $result[0];
		foreach ($userData as $k => $v)
		{
			$SessionData[$k] = $v;
		}
		update_session($OUTPUT['SessionKey'], $SessionData);
		$OUTPUT['SESSION'] = get_session_data($OUTPUT['SessionKey']);
	}
	else // another user
	{
		$OUTPUT['LOGIN'] = "FALSE";
		$ERROR = "Password MissMatch or user not found";
	}
}


?>