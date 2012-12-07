/*
 * COMP3615 Group F
 *
 * Hospital Local Network Monitor - Schema
 * version 1.0
 *
 * PostgreSQL version
 */

/* clean-up to make script idempotent */
BEGIN TRANSACTION;
DROP TABLE IF EXISTS Building;
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Device;
DROP TABLE IF EXISTS Connected;
DROP SCHEMA IF EXISTS lnm CASCADE;
COMMIT;

/* start schema */
CREATE SCHEMA lnm

CREATE TABLE lnm.Building (
   name VARCHAR(80) PRIMARY KEY
)
 
CREATE TABLE lnm.Location (
   id SERIAL PRIMARY KEY,
   roomName VARCHAR(50),
   building VARCHAR(80) REFERENCES Building(name),
   level INTEGER NOT NULL,
   roomNo VARCHAR(10) NOT NULL,
   CONSTRAINT location_UNIQUE UNIQUE(building,level,roomNo)
)

CREATE TABLE lnm.Account (
   id SERIAL PRIMARY KEY,
   username VARCHAR(20) NOT NULL,
   passwd VARCHAR(20) NOT NULL,
   fullName VARCHAR(50) NOT NULL,
   CONSTRAINT account_UNIQUE UNIQUE(username)
)

CREATE TABLE lnm.Device (
   id SERIAL PRIMARY KEY,
   name VARCHAR(50),
   macAddress VARCHAR(18) NOT NULL,
   isMobile BOOLEAN NOT NULL,
   location SERIAL REFERENCES Location(id),
   CONSTRAINT device_UNIQUE UNIQUE(macAddress)
)

CREATE TABLE lnm.Connected (
   id SERIAL PRIMARY KEY,
   hostName VARCHAR(50),
   macAddress VARCHAR(18) NOT NULL,
   ipAddress VARCHAR(50) NOT NULL,
   lastSeen TIMESTAMP NOT NULL
); 

CREATE TABLE lnm.Settings (
	enable_scanning BOOLEAN
);

CREATE TABLE lnm.MAP(
id serial primary key,
name varchar(50) unique,
width integer,
height integer,
path varchar(200)
);

alter table lnm.device add column map_id integer references lnm.map(id);
alter table lnm.device add column x_coordinate integer;
alter table lnm.device add column y_coordinate integer;
/* end schema */

/* Create Admin */
INSERT INTO lnm.Account(username,passwd,fullName) VALUES('admin','admin','John Doe');

/*stored procedures*/

CREATE OR REPLACE FUNCTION unregistered() RETURNS table(id integer,hostname varchar(50),
macaddress varchar(18),ipaddress varchar(50),last_seen timestamp) AS $$
select id,hostname,macaddress,ipaddress,lastSeen from lnm.connected c
	where c.macaddress not in (
	select d.macaddress
	from lnm.device d
	)
	order by c.hostname;

$$ LANGUAGE SQL;
