PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS DepartmentFAQ;
DROP TABLE IF EXISTS TagFAQ;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS AgentDepartment;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS TicketTag;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Status;
DROP TABLE IF EXISTS Priority;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS User;

CREATE TABLE User(
   userId INTEGER PRIMARY KEY,
   name VARCHAR NOT NULL,
   username VARCHAR  NOT NULL,
   email VARCHAR NOT NULL,
   password VARCHAR NOT NULL,
   reputation VARCHAR,
   type VARCHAR NOT NULL,
   CHECK (type = "client" OR type = "agent" OR type = "admin")
);

CREATE TABLE Hashtag(
   tag VARCHAR PRIMARY KEY
);

CREATE TABLE Priority(
   priority VARCHAR PRIMARY KEY,
   CHECK (priority = "critical" OR priority = "high" OR priority = "medium" OR priority = "low")
);

CREATE TABLE Status(
   status VARCHAR PRIMARY KEY
);

CREATE TABLE Ticket(
   id INTEGER PRIMARY KEY,
   title VARCHAR NOT NULL,
   text VARCHAR NOT NULL,
   createDate DATE NOT NULL,
   visibility VARCHAR NOT NULL,
   priority VARCHAR REFERENCES Priority(priority) NOT NULL,
   status VARCHAR REFERENCES Status(status) NOT NULL,
   category VARCHAR REFERENCES Department(category),
   tag VARCHAR REFERENCES Hashtag(tag),
   frequentItem INTEGER REFERENCES FAQ(id),
   creator INTEGER REFERENCES User(userId),
   replier INTEGER REFERENCES User(userId)
);

CREATE TABLE TicketTag(
   ticket INTEGER REFERENCES Ticket(id),
   tag VARCHAR REFERENCES Hashtag(tag),
   PRIMARY KEY (ticket, tag)
);

CREATE TABLE Message(
   id INTEGER PRIMARY KEY,
   priority VARCHAR REFERENCES Priority(priority) NOT NULL, 
   text VARCHAR NOT NULL,
   sent DATE NOT NULL,
   status VARCHAR REFERENCES Status(status) NOT NULL,
   user INTEGER REFERENCES User(userId) NOT NULL,
   ticket INTEGER REFERENCES Ticket(id) NOT NULL
);

CREATE TABLE Department(
   category VARCHAR PRIMARY KEY
);

CREATE TABLE AgentDepartment(
   agent INTEGER REFERENCES User(userId),
   department VARCHAR REFERENCES Department(category), 
   PRIMARY KEY (agent, department)
);

CREATE TABLE FAQ(
   id INTEGER PRIMARY KEY,
   title VARCHAR NOT NULL,
   content VARCHAR NOT NULL,
   popularity INTEGER NOT NULL,
   createDate DATE NOT NULL
);

CREATE TABLE TagFAQ(
   item INTEGER REFERENCES FAQ(id),
   tag VARCHAR REFERENCES Hashtag(tag),
   PRIMARY KEY (item, tag)
);

CREATE TABLE DepartmentFAQ(
   item INTEGER REFERENCES FAQ(id),
   category VARCHAR REFERENCES Department(category),
   PRIMARY KEY (item, category)
);
