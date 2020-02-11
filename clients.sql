use volokolamsk;
DROP TABLE IF EXISTS clients;
CREATE TABLE clients (
  id int(11) NOT NULL auto_increment,
  name varchar(250),  
  type varchar(100),  
  pult_number varchar(50),  
  ohran_system varchar(100),
  address text,
  person text,
  dogovor varchar(255),
  ikeys varchar(25),
  payment varchar(100),
  time varchar(50),
  simcard varchar(100),
  kadastr varchar(100),
  gbr varchar(20),
  PRIMARY KEY  (id)
);


DROP TABLE IF EXISTS client_helpers;
CREATE TABLE client_helpers (
  id int(11) NOT NULL auto_increment,
  name varchar(250),  
  tel varchar(100),  
  tel2 varchar(100),  
  tel3 varchar(100),  
  email varchar(100),  
  descr text,
  sms int DEFAULT 0,
  operational tinyint(1) DEFAULT 0,
  opening tinyint(1) DEFAULT 0,
  PRIMARY KEY  (id),
  key name(name),
  key email(email)
);



INSERT INTO clients (name, type, pult_number,ohran_system,address,person,dogovor,ikeys,payment,time,simcard,kadastr)

ALTER TABLE clients add status int;
ALTER TABLE clients add simcard2 varchar(100);
ALTER TABLE clients add simcard_old varchar(100);
CREATE INDEX person ON clients(person(10));
update clients set simacard_old=simcard;
update clients set ikeys='нет' where ikeys is NULL;
ALTER TABLE clients add person_old text;
update clients set person_old=person;
ALTER TABLE clients add tel varchar(100);
ALTER TABLE clients add tel2 varchar(100);
ALTER TABLE clients add tel3 varchar(100);
ALTER TABLE clients add email varchar(100);
ALTER TABLE clients add sms int default 1;
ALTER TABLE clients add ohran_system_type varchar(255);

ALTER TABLE client_helpers add column client_id int not NULL;
CREATE INDEX client_helpers_client_id ON client_helpers(client_helpers);


DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets (
  id int(11) NOT NULL auto_increment,
  user_id int,  
  department_id int,  
  mes text,  
  date DATETIME,  
  read int default 0, 
  num_mes int DEFAULT 1,
  client_id int,
  PRIMARY KEY  (id),
  key user_id(user_id),
  key date(date),
    key client_id(client_id),
   key department(department_id)
);

CREATE INDEX ticket_mes ON tickets(mes(10));

ALTER TABLE tickets add status int;
ALTER TABLE tickets add quick tinyint(1) DEFAULT 0;
ALTER TABLE tickets add work_date date;
ALTER TABLE tickets add teh_comment text;
ALTER TABLE tickets add remind_id int;
ALTER TABLE tickets add type int;
ALTER TABLE tickets add zakaz_naryad_made tinyint(1) DEFAULT 0;
ALTER TABLE tickets add zakaz_naryad_date date;
ALTER TABLE tickets add `TO` tinyint(1) DEFAULT 0;
ALTER TABLE tickets add neopros tinyint(1) DEFAULT 0;

CREATE INDEX ticket_remind ON tickets(remind_id);
CREATE INDEX ticket_work_date ON tickets(work_date);