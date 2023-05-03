PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS DepartmentFAQ;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS AgentDepartment;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS TicketHistory;
DROP TABLE IF EXISTS TicketTag;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Status;
DROP TABLE IF EXISTS Priority;
DROP TABLE IF EXISTS User;

CREATE TABLE User(
   userId INTEGER PRIMARY KEY,
   name VARCHAR NOT NULL,
   username VARCHAR  NOT NULL UNIQUE,
   email VARCHAR NOT NULL UNIQUE,
   password VARCHAR NOT NULL,
   reputation INTEGER NOT NULL,
   type VARCHAR NOT NULL,
   CHECK (type = "client" OR type = "agent" OR type = "admin")
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
   priority VARCHAR NOT NULL,
   status VARCHAR REFERENCES Status(status) NOT NULL,
   category VARCHAR REFERENCES Department(category),
   frequentItem INTEGER REFERENCES FAQ(id),
   creator INTEGER REFERENCES User(userId),
   replier INTEGER REFERENCES User(userId)
   CHECK (priority = "critical" OR priority = "high" OR priority = "medium" OR priority = "low")
);

CREATE TABLE TicketHistory(
   id INTEGER PRIMARY KEY,
   ticketId INTEGER REFERENCES Ticket(id),
   date DATE NOT NULL,
   changes VARCHAR NOT NULL 
);


CREATE TABLE TicketTag(
   ticket INTEGER REFERENCES Ticket(id),
   tag VARCHAR NOT NULL,
   PRIMARY KEY (ticket, tag)
);

CREATE TABLE Message(
   id INTEGER PRIMARY KEY,
   user INTEGER REFERENCES User(userId) NOT NULL,
   ticket INTEGER REFERENCES Ticket(id) NOT NULL,
   text VARCHAR NOT NULL,
   date DATE NOT NULL
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

CREATE TABLE DepartmentFAQ(
   item INTEGER REFERENCES FAQ(id),
   category VARCHAR REFERENCES Department(category),
   PRIMARY KEY (item, category)
);
