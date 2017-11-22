create table submit(
submit_id int not null auto_increment primary key,
state varchar(40),
uid int,
problem_id int not null,
submit_date datetime default now(),
code_length int default 0,
time_usage int default 0,
memory_usage int) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
