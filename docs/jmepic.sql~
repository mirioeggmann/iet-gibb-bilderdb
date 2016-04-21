
-- JMELab (c) 2016
-- Create a database and a user for it.
-- After that you have to change the    db name, 
--                                      username,
--                                      password 
-- in the config file (/config.php).gallery

DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id        INT NOT NULL AUTO_INCREMENT,
  firstName VARCHAR(64)  NULL,
  lastName  VARCHAR(64)  NULL,
  userName  VARCHAR(64) NOT NULL,
  email     VARCHAR(128) NOT NULL,
  password  CHAR(60)  NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS gallery;
CREATE TABLE gallery (
  id		INT NOT NULL AUTO_INCREMENT,
  name		VARCHAR(64) NOT NULL,
  PRIMARY KEY (id)
);

-- maybe thumbnail not?
DROP TABLE IF EXISTS picture;
CREATE TABLE picture (
  id			INT NOT NULL AUTO_INCREMENT,
  original		VARCHAR(64) NOT NULL,
  thumbnail 		VARCHAR(70) NOT NULL,
  height_original	INT NOT NULL,
  width_original	INT NOT NULL,
  size_original		INT NOT NULL,
  height_thumbnail	INT NOT NULL,
  width_thumbnail	INT NOT NULL,
  size_thumbnail	INT NOT NULL,
  date  		DATETIME,
  gallery_id		INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (gallery_id) REFERENCES gallery(id)
);

DROP TABLE IF EXISTS tag;
CREATE TABLE tag (
  id		INT NOT NULL AUTO_INCREMENT,
  tag		VARCHAR(64) NOT NULL,
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS user_gallery;
CREATE TABLE user_gallery (
  id		INT NOT NULL AUTO_INCREMENT,
  user_id	INT NOT NULL,
  gallery_id 	INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id),
  FOREIGN KEY (gallery_id) REFERENCES gallery(id)
);

DROP TABLE IF EXISTS picture_tag;
CREATE TABLE picture_tag (
  id		INT NOT NULL AUTO_INCREMENT,
  picture_id 	INT NOT NULL,
  tag_id	INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (picture_id) REFERENCES picture(id),
  FOREIGN KEY (tag_id) REFERENCES tag(id)
);
