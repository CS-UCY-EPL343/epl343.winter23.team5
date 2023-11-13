CREATE TABLE Users (
    UserID smallint not null AUTO_INCREMENT PRIMARY KEY,
    Fname char(36) not null,
    Lname char(36) not null,
    username char(36) not null,
    password char(72) not null,
    Type tinyint not null,
    isEnrolled bit not null,
    Phone int not null
);


CREATE TABLE Class(
    CID tinyint not null AUTO_INCREMENT PRIMARY KEY,
    Name char(1) not null,
    SchoolYear tinyint not null,
    Number tinyint not null,
    AvailableSeats tinyint not null,
    Days char(7) not null,
    TimeForFirstDay char(8) not null,
    TimeForSecondDay char(8) not null,
    NextYears bit not null
    
);

CREATE TABLE ExtraLesson(
    Days char(7) not null,
    Time char(8) not null,
    CID tinyint not null,
    ELID smallint not null AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE Teaching(
    UserID smallint not null,
    CID tinyint not null,
    PRIMARY KEY(UserID,CID)
);

CREATE TABLE BelongsTo (
    UserID smallint not null,
    CID tinyint not null,
    PRIMARY KEY(UserID,CID)
);