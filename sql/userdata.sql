create table userdata(
id varchar(50) NOT NULL PRIMARY KEY,
submit int(11) DEFAULT 0,
solved int DEFAULT 0,
accesstime datetime DEFAULT NULL,
sangme varchar(150) DEFAULT 'Hello, World!'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
