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
  no_sms tinyint(1) DEFAULT 0,
  add_remove tinyint(1) DEFAULT 0,
  full_sms tinyint(1) DEFAULT 0,
  operational tinyint(1) DEFAULT 0,
  opening tinyint(1) DEFAULT 0,
  PRIMARY KEY  (id),
  key name(name),
  key email(email)
);



INSERT INTO clients (name, type, pult_number,ohran_system,address,person,dogovor,ikeys,payment,time,simcard,kadastr)


ALTER TABLE clients add simcard2 varchar(100);
ALTER TABLE clients add simcard_old varchar(100);
ALTER TABLE client_helpers add column client_id int not NULL;
CREATE INDEX client_helpers_client_id ON client_helpers(client_helpers);
update clients set simacard_old=simcard;

update clients set ikeys='нет' where ikeys is NULL;

ALTER TABLE clients add person_old text;
update clients set person_old=person;

