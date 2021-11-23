CREATE TABLE questions(
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    topic_id int(11) NOT NULL,
    question text NOT NULL,
    c1 text NOT NULL,
    c2 text NOT NULL,
    c3 text NOT NULL,
    c4 text NOT NULL,
    answer text NOT NULL,
    explantion text,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP

);
-- Alter table questions add column explanation text
CREATE TABLE topics (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    topic text NOT NULL,
    chapter text NOT NULL,
    lesson text NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
);

/*for over all scores*/
 CREATE TABLE scores (
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     topic_id int(11) NOT NULL,
     score int(11) NOT NULL,
     num_items int(11) NOT NULL,
     date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );
 /*for single record of questions either going to use for logging*/
 CREATE TABLE records (
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     topic_id int(11) NOT NULL,
     question_id int(11) NOT NULL,
     score int(11) NOT NULL,
      date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );

 CREATE TABLE users(
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username text NOT NULL,
    user_number text NOT NULL,
    avatar VARCHAR(250) NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );

 CREATE TABLE coins(
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     user_id text NOT NULL,
     coins int(11) NOT NULL,
     date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );
 Create Table rewards(
     id int(11)NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reward_name text NOT NULL,
    reward_description text NOT NULL,
    quantity int(11) NOT NULL,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );
 CREATE TABLE claim_reward(
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     user_id text NOT NULL,
     claimed boolean NOT NULL, 
     date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );

 CREATE TABLE avatars(
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     filename text NOT NULL,
     file_path text NOT NULL,
     date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );

 CREATE TABLE lessons(
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     topic_id text NOT NULL,
     lesson_title text NOT NULL,
     lesson_image text NOT NULL,
     content text NOT NULL,
     date_created DATETIME DEFAULT CURRENT_TIMESTAMP

 );

 CREATE TABLE documentations (
     id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     document_title text NOT NULL,
     document_photo text NOT NULL,
     content text NOT NULL,
     show_public boolean NOT NULL,
     date_created DATETIME DEFAULT CURRENT_TIMESTAMP
 );
