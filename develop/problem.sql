create table problem (
problem_id int not null primary key,
title varchar(200) default "" not null,
description text,
input text,
output text,
sample_input text,
sample_output text,
special_judge bool default 0 not null,
hint text,
source varchar(100),
in_date datetime,
time_limit int default 0 not null,
memory_limit int default 0 not null,
submit int default 0 not null,
solved int default 0 not null
defunct bool default 0 not null
) ENGINE=MyISAM default charset=utf8;
