<?php

$db = 'wqf_account';
$t = "SELECT * FROM wqf_geo";
$g = "SELECT * FROM wqf_gender";
$s = "SELECT * FROM wqf_status WHERE status_id <= 8";
$at = "SELECT * FROM wqf_act WHERE wqf_act.is_active =1";
$ps = "SELECT * FROM wqf_stage WHERE wqf_stage.is_active =1";
$eq = "SELECT * FROM wqf_req_type";
$ti = "SELECT wqf_timeslots.time_id, wqf_timeslots.timeslot, day, wqf_timeslots.is_active, wqf_artist.artist_id, wqf_artist.stage
FROM wqf_timeslots 
LEFT JOIN wqf_artist ON wqf_timeslots.time_id = wqf_artist.timeslot
LEFT JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
WHERE artist_id IS NULL OR stage IS NULL";

$ti = "SELECT wqf_timeslots.time_id, wqf_timeslots.timeslot, day, wqf_timeslots.is_active, wqf_artist.artist_id, wqf_artist.stage
FROM wqf_timeslots 
LEFT JOIN wqf_artist ON wqf_timeslots.time_id = wqf_artist.timeslot
LEFT JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
WHERE artist_id IS NULL OR stage IS NULL";

$artistedit = "SELECT artist_id, userid, wqf_account.fname, astatus, wqf_status.status_name AS statusname, act_name, wqf_artist.stage, wqf_stage.stage_name, wqf_timeslots.timeslot, is_confirmed, wqf_artist.is_active, wqf_artist.last_edited_by
FROM wqf_artist
INNER JOIN wqf_account ON userid = wqf_account.users_account
INNER JOIN wqf_status ON wqf_artist.astatus = wqf_status.status_id
INNER JOIN wqf_stage ON stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
ORDER BY wqf_timeslots.timeslot ASC";

$useredit = "SELECT account_id, fname, lname, wqf_gender.gender, users_account, wqf_users.user_type, wqf_usertype.type_name, wqf_account.isArtist, wqf_account.isActive, wqf_artist.artist_id
FROM wqf_account
INNER JOIN wqf_gender ON wqf_account.gender = wqf_gender.gen_id
INNER JOIN wqf_users ON users_account = wqf_users.user_id
INNER JOIN wqf_usertype ON wqf_users.user_type = wqf_usertype.type_id
LEFT JOIN wqf_artist ON users_account = wqf_artist.userid
ORDER BY lname ASC, fname ASC";

$confartist ="SELECT artist_id, act_name
FROM wqf_artist
WHERE wqf_artist.is_confirmed =1";

?>