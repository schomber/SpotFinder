CREATE TABLE Spot (
  ID        integer NOT NULL, 
  mLat      decimal(12, 9) NOT NULL, 
  mLong     decimal(12, 9) NOT NULL, 
  sName     varchar(255) NOT NULL, 
  sAddress  varchar(255) NOT NULL, 
  sCategory varchar(255) NOT NULL, 
  sComment  varchar(255), 
  UseruID   integer NOT NULL, 
  PRIMARY KEY (ID));
CREATE TABLE Customer (
  uID       integer NOT NULL, 
  uUsername varchar(255) NOT NULL, 
  uFName    varchar(255) NOT NULL 			, 
  uSName    varchar(255) NOT NULL, 
  sEmail    varchar(255) NOT NULL, 
  sPassword varchar(255) NOT NULL, 
  AdminaID  integer NOT NULL, 
  PRIMARY KEY (uID));
CREATE TABLE Admin (
  aID   integer NOT NULL, 
  aPriv integer NOT NULL, 
  PRIMARY KEY (aID));
CREATE TABLE AuthToken (
  authID     integer NOT NULL, 
  Expiration integer NOT NULL, 
  AdminaID   integer NOT NULL, 
  PRIMARY KEY (authID));
ALTER TABLE Customer ADD CONSTRAINT FKCustomer439828 FOREIGN KEY (AdminaID) REFERENCES Admin (aID);
ALTER TABLE AuthToken ADD CONSTRAINT Token FOREIGN KEY (AdminaID) REFERENCES Admin (aID);
ALTER TABLE Spot ADD CONSTRAINT FKSpot910978 FOREIGN KEY (UseruID) REFERENCES Customer (uID);
