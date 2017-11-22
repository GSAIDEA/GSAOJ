delete from submit;
delete from solved;
update problem set submit=0, solved=0;
update userdata set submit=0, solved=0, cperr=0, rterr=0, exprerr=0, wrong=0;
alter table submit auto_increment=1;
