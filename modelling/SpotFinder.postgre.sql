CREATE TABLE Spot (
  ID       SERIAL NOT NULL, 
  Lat      numeric(19, 16) NOT NULL, 
  Lng      numeric(19, 16) NOT NULL, 
  Name     varchar(255) NOT NULL, 
  Address  varchar(255) NOT NULL, 
  Category varchar(255) NOT NULL, 
  sComment varchar(255), 
  UserID   int4 NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE Customer (
  ID        SERIAL NOT NULL, 
  Username  varchar(255) NOT NULL, 
  Firstname varchar(255) NOT NULL 			, 
  Surname   varchar(255) NOT NULL, 
  Email     varchar(255) NOT NULL, 
  Password  varchar(255) NOT NULL, 
  RoleID    int4, 
  PRIMARY KEY (ID));
CREATE TABLE Role (
  ID     SERIAL NOT NULL, 
  Role   varchar(255) NOT NULL, 
    PRIMARY KEY (ID));
CREATE TABLE AuthToken (
  ID         SERIAL NOT NULL, 
  Selector   varchar(255) NOT NULL, 
  Validator  varchar(255) NOT NULL, 
  Expiration timestamp NOT NULL, 
  aType      int4 NOT NULL, 
  UserID     int4 NOT NULL);
ALTER TABLE AuthToken ADD CONSTRAINT FKAuthToken755921 FOREIGN KEY (UserID) REFERENCES Customer (ID);
ALTER TABLE Spot ADD CONSTRAINT FKSpot759349 FOREIGN KEY (UserID) REFERENCES Customer (ID);
ALTER TABLE Customer ADD CONSTRAINT FKCustomer175792 FOREIGN KEY (RoleID) REFERENCES Role (ID);
