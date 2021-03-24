CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT,username TEXT,password TEXT);
CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT,document TEXT,user_id INTEGER NOT NULL ,FOREIGN KEY(user_id) REFERENCES user(id));
CREATE INDEX note_user_id_idx ON note (user_id);
