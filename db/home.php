<?php

$a = "SELECT artist_id, act_name, artimage, bio_short,wqf_timeslots.timeslot,wqf_stage.stage_name,web
FROM wqf_artist
INNER JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
WHERE act_type =1
AND is_confirmed = 1
AND wqf_artist.is_active = 1";

$b = "SELECT artist_id, act_name, artimage 
FROM wqf_artist
WHERE act_type = 2
AND is_confirmed = 1
AND wqf_artist.is_active = 1";

?>