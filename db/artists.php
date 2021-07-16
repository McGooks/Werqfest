<?php

$perf = "SELECT artist_id, act_name, artimage,wqf_timeslots.timeslot,wqf_stage.stage_name
FROM wqf_artist
INNER JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
WHERE is_confirmed = 1
AND wqf_artist.is_active = 1
ORDER BY `timeslot` ASC";

$s1 = "SELECT artist_id, act_name, wqf_artist.stage, wqf_stage.stage_name AS locale, wqf_artist.timeslot AS slotno, wqf_timeslots.timeslot, wqf_timeslots.day AS perfday, wqf_timeslots.is_active AS slotactive, artimage, wqf_artist.act_type AS actypenum, wqf_act.act_type AS atype, wqf_artist.is_confirmed, wqf_artist.is_active
FROM wqf_artist
INNER JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
INNER JOIN wqf_act ON wqf_artist.act_type = wqf_act.act_id
WHERE wqf_artist.is_confirmed = 1 AND wqf_artist.is_active = 1 AND wqf_timeslots.day = 1
ORDER BY slotno ASC";

$s2 = "SELECT artist_id, act_name, wqf_artist.stage, wqf_stage.stage_name AS locale, wqf_artist.timeslot AS slotno, wqf_timeslots.timeslot, wqf_timeslots.day AS perfday, wqf_timeslots.is_active AS slotactive, artimage, wqf_artist.act_type AS actypenum, wqf_act.act_type AS atype, wqf_artist.is_confirmed, wqf_artist.is_active
FROM wqf_artist
INNER JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
INNER JOIN wqf_act ON wqf_artist.act_type = wqf_act.act_id
WHERE wqf_artist.is_confirmed = 1 AND wqf_artist.is_active = 1 AND wqf_timeslots.day = 2
ORDER BY slotno ASC";

$s3 = "SELECT artist_id, act_name, wqf_artist.stage, wqf_stage.stage_name AS locale, wqf_artist.timeslot AS slotno, wqf_timeslots.timeslot, wqf_timeslots.day AS perfday, wqf_timeslots.is_active AS slotactive, artimage, wqf_artist.act_type AS actypenum, wqf_act.act_type AS atype, wqf_artist.is_confirmed, wqf_artist.is_active
FROM wqf_artist
INNER JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
INNER JOIN wqf_act ON wqf_artist.act_type = wqf_act.act_id
WHERE wqf_artist.is_confirmed = 1 AND wqf_artist.is_active = 1 AND wqf_timeslots.day = 3
ORDER BY slotno ASC";

$ps = "SELECT * FROM wqf_stage WHERE wqf_stage.is_active =1 AND wqf_stage.stage_id < 5";

?>