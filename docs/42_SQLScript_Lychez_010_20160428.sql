-- JMELab
USE lychez;

DROP TABLE IF EXISTS photo_album;
DROP TABLE IF EXISTS photo_tag;
DROP TABLE IF EXISTS user_album;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS photo;
DROP TABLE IF EXISTS album;
DROP TABLE IF EXISTS user;

--
-- Create tables
--

CREATE TABLE user (
  id        INT             NOT NULL      AUTO_INCREMENT,
  firstName VARCHAR(64)     NULL,
  lastName  VARCHAR(64)     NULL,
  userName  VARCHAR(64)     NOT NULL,
  email     VARCHAR(128)    NOT NULL,
  password  CHAR(60)        NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE album (
  id		INT                 NOT NULL      AUTO_INCREMENT,
  name		VARCHAR(64)       NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE photo (
  id			      INT           NOT NULL     AUTO_INCREMENT,
  name		      VARCHAR(64)   NOT NULL,
  type          VARCHAR(5)    NOT NULL,
  height	      INT           NOT NULL,
  width 	      INT           NOT NULL,
  size          INT           NOT NULL,
  date  	      DATETIME      NULL,
  description   VARCHAR(500)  NULL,
  user_id	      INT           NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE tag (
  id		        INT           NOT NULL      AUTO_INCREMENT,
  name		      VARCHAR(64)   NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE user_album (
  id		        INT           NOT NULL      AUTO_INCREMENT,
  user_id	      INT           NOT NULL,
  album_id   	  INT           NOT NULL,
  role          VARCHAR(45)   NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (album_id) REFERENCES album(id)
);

CREATE TABLE photo_album (
  id		        INT           NOT NULL      AUTO_INCREMENT,
  photo_id      INT           NOT NULL,
  album_id   	  INT           NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (photo_id) REFERENCES photo(id),
  FOREIGN KEY (album_id) REFERENCES album(id)
);

CREATE TABLE photo_tag (
  id		        INT           NOT NULL      AUTO_INCREMENT,
  photo_id   	  INT           NOT NULL,
  tag_id	      INT           NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (photo_id) REFERENCES photo(id),
  FOREIGN KEY (tag_id) REFERENCES tag(id)
);
