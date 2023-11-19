CREATE TABLE Users (
    UserID smallint not null AUTO_INCREMENT PRIMARY KEY,
    Fname char(36) not null,
    Lname char(36) not null,
    username char(36) not null,
    Upassword char(72) not null,
    UType tinyint not null,
    isEnrolled tinyint not null,
    Phone int not null,
    CONSTRAINT CHK_UTYPE CHECK (UType>=0 AND UType<=2),
    CONSTRAINT CHK_UENROLL CHECK (isEnrolled>=0 AND isEnrolled<=1),
    CONSTRAINT CHK_UPHONE CHECK  ((Phone >= 96000000 AND Phone <= 96999999)
                                    OR (Phone >= 99000000 AND Phone <= 99999999) 
                                    OR (Phone >= 97000000 AND Phone <= 97999999)),
    CONSTRAINT UNQ_USRNM UNIQUE (username)
);


CREATE TABLE Class(
    CID tinyint not null AUTO_INCREMENT PRIMARY KEY,
    CName char(1) not null,
    SchoolYear tinyint not null,
    CNumber tinyint not null,
    AvailableSeats tinyint not null,
    CDays char(7) not null,
    TimeForFirstDay char(8) not null,
    TimeForSecondDay char(8) not null,
    NextYears tinyint not null,
    CONSTRAINT CHK_CNEXTY CHECK (NextYears>=0 AND NextYears<=1),
     CONSTRAINT CHK_CLASSNAME CHECK (CName IN ('M','P','C')),
     CONSTRAINT CHK_CLASSSCHOOLY CHECK (SchoolYear>=1 AND SchoolYear<=6),
     CONSTRAINT CHK_CLASSNUM CHECK (CNumber>=0 AND CNumber<=5),
     CONSTRAINT CHK_CLASSAVLSEATS CHECK (AvailableSeats>=0 AND AvailableSeats<=10),
     CONSTRAINT CHK_CLASSDAYS CHECK (CDays REGEXP '^[01]{7}$'),
     CONSTRAINT CHK_CLASSTIMEFIRSTD CHECK (
        SUBSTRING(TimeForFirstDay, 1, 1) BETWEEN '0' AND '2'
        AND SUBSTRING(TimeForFirstDay, 2, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(TimeForFirstDay, 3, 1) BETWEEN '0' AND '5'
        AND SUBSTRING(TimeForFirstDay, 4, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(TimeForFirstDay, 5, 1) BETWEEN '0' AND '2'
        AND SUBSTRING(TimeForFirstDay, 6, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(TimeForFirstDay, 7, 1) BETWEEN '0' AND '5'
        AND SUBSTRING(TimeForFirstDay, 8, 1) BETWEEN '0' AND '9'),
    CONSTRAINT CHK_CLASSTIMESECONDD CHECK (
        SUBSTRING(TimeForSecondDay, 1, 1) BETWEEN '0' AND '2'
        AND SUBSTRING(TimeForSecondDay, 2, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(TimeForSecondDay, 3, 1) BETWEEN '0' AND '5'
        AND SUBSTRING(TimeForSecondDay, 4, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(TimeForSecondDay, 5, 1) BETWEEN '0' AND '2'
        AND SUBSTRING(TimeForSecondDay, 6, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(TimeForSecondDay, 7, 1) BETWEEN '0' AND '5'
        AND SUBSTRING(TimeForSecondDay, 8, 1) BETWEEN '0' AND '9')
    
);

CREATE TABLE ExtraLesson(
    ELDate date not null,
    ELTime char(8) not null,
    CID tinyint not null,
    ELID smallint not null AUTO_INCREMENT PRIMARY KEY,
    CONSTRAINT CHK_ELESSONT CHECK (
        SUBSTRING(ELTime, 1, 1) BETWEEN '0' AND '2'
        AND SUBSTRING(ELTime, 2, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(ELTime, 3, 1) BETWEEN '0' AND '5'
        AND SUBSTRING(ELTime, 4, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(ELTime, 5, 1) BETWEEN '0' AND '2'
        AND SUBSTRING(ELTime, 6, 1) BETWEEN '0' AND '9'
        AND SUBSTRING(ELTime, 7, 1) BETWEEN '0' AND '5'
        AND SUBSTRING(ELTime, 8, 1) BETWEEN '0' AND '9'
    )
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
