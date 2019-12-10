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

INSERT INTO clients (name, type, pult_number,ohran_system,address,person,dogovor,ikeys,payment,time,simcard,kadastr)