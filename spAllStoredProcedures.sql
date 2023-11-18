
-- CREATE PROCEDURE get_user
    DELIMITER //
CREATE PROCEDURE get_user(IN p_username char(36))
BEGIN
    SELECT *
    FROM Users u
    WHERE u.username = p_username;
END //
DELIMITER ;





-- CREATE PROCEDURE find_user 
DELIMITER //
CREATE PROCEDURE find_user(
    IN firstName char(36),
    IN lastName char(36),
    IN usersPhone int
)

BEGIN
    SELECT *
    FROM Users u
    WHERE u.Fname=firstName AND u.Lname=lastName AND u.Phone=usersPhone;
END //
DELIMITER ;




-- CREATE PROCEDURE insert_to_teaching
DELIMITER //
CREATE PROCEDURE insert_to_teaching(IN p_UserID smallint, IN p_CID tinyint)
BEGIN
    INSERT INTO Teaching (UserID, CID) VALUES (p_UserID, p_CID);
END //

DELIMITER ;






-- CREATE PROCEDURE insert_to_belongsto 
DELIMITER //
CREATE PROCEDURE insert_to_belongsto(IN p_UserID smallint, IN p_CID tinyint)
BEGIN
    INSERT INTO BelongsTo (UserID, CID) VALUES (p_UserID, p_CID);
END //

DELIMITER ;




-- CREATE PROCEDURE add_user 
DELIMITER //

CREATE PROCEDURE add_user(
    IN firstName CHAR(36),
    IN lastName CHAR(36),
    IN usersPhone INT,
    IN userspassword CHAR(72),
    IN userType TINYINT
)
BEGIN
    DECLARE t CHAR(36);
    DECLARE num INT;
     DECLARE un CHAR(36);
     
    SET t=CONCAT(SUBSTRING(firstName FROM 1 FOR 1), SUBSTRING(lastName FROM 1 FOR 4));


    SELECT COUNT(*)
    INTO num
    FROM Users u
    WHERE u.username LIKE CONCAT(t, '%');
    SET num=num+1;

    SET un = CONCAT(t, CAST(num AS CHAR));

    IF userType = 0 THEN
        INSERT INTO Users (Fname, Lname, username, Upassword, UType, isEnrolled, Phone)
        VALUES (firstName, lastName, un, userspassword, 0, 0, usersPhone);
    END IF;

    IF userType = 1 THEN
        INSERT INTO Users (Fname, Lname, username, Upassword, UType, isEnrolled, Phone)
        VALUES (firstName, lastName, un, userspassword, 1, 1, usersPhone);
    END IF;
END //

DELIMITER ;





-- CREATE PROCEDURE find_teaching_classes 
DELIMITER //
CREATE PROCEDURE find_teaching_classes(
    IN p_username char(36)
)
BEGIN
SELECT c.CID, c.CName, c.SchoolYear, c.CNumber, c.CDays, c.TimeForFirstDay, c.TimeForSecondDay
FROM Class c
INNER JOIN Teaching t ON t.CID=c.CID
INNER JOIN Users u ON u.UserID=t.UserID
WHERE u.username=p_username;

END //
DELIMITER ;




-- CREATE PROCEDURE insert_extra_lessonn 
DELIMITER //
CREATE PROCEDURE insert_extra_lesson(IN extraDate date, IN extraTime char(8),IN classID tinyint)
BEGIN
    INSERT INTO ExtraLesson (ELDate, ELTime,CID) VALUES (extraDate, extraTime,classID);
END //

DELIMITER ;




-- CREATE PROCEDURE fetch_teachers 
DELIMITER //
CREATE PROCEDURE fetch_teachers(
)
BEGIN
SELECT u.Fname,u.Lname,u.username
FROM Users u
WHERE u.UType=1;

END //
DELIMITER ;





-- CREATE PROCEDURE add_class 
DELIMITER //

CREATE PROCEDURE add_class(
    IN p_CName char(1),
    IN p_SchoolYear tinyint,
    IN p_CNumber tinyint,
    IN p_AvailableSeats tinyint,
    IN p_CDays char(7),
    IN p_TimeForFirstDay char(8),
    IN p_TimeForSecondDay char(8),
    IN p_NextYears bit
)
BEGIN
    INSERT INTO Class (
        CName,
        SchoolYear,
        CNumber,
        AvailableSeats,
        CDays,
        TimeForFirstDay,
        TimeForSecondDay,
        NextYears
    ) VALUES (
        p_CName,
        p_SchoolYear,
        p_CNumber,
        p_AvailableSeats,
        p_CDays,
        p_TimeForFirstDay,
        p_TimeForSecondDay,
        p_NextYears
    );
END //

DELIMITER ;




-- CREATE PROCEDURE update_class

DELIMITER //

CREATE PROCEDURE update_class(
    IN p_CID tinyint,
    IN p_CName char(1),
    IN p_SchoolYear tinyint,
    IN p_CNumber tinyint,
    IN p_AvailableSeats tinyint,
    IN p_CDays char(7),
    IN p_TimeForFirstDay char(8),
    IN p_TimeForSecondDay char(8),
    IN p_NextYears bit
)
BEGIN
    UPDATE Class
    SET
        CName = p_CName,
        SchoolYear = p_SchoolYear,
        CNumber = p_CNumber,
        AvailableSeats = p_AvailableSeats,
        CDays = p_CDays,
        TimeForFirstDay = p_TimeForFirstDay,
        TimeForSecondDay = p_TimeForSecondDay,
        NextYears = p_NextYears
    WHERE
        CID = p_CID;
END //

DELIMITER ;




-- CREATE PROCEDURE get_all_classes

DELIMITER //

CREATE PROCEDURE get_all_classes()

BEGIN
    SELECT *
    FROM Class;
END //

DELIMITER;




-- CREATE PROCEDURE delete_class

DELIMITER //

CREATE PROCEDURE delete_class(IN p_CID tinyint)

BEGIN
    DELETE c 
    FROM CLASS c 
    WHERE c.CID=p_CID;
END //

DELIMITER ;

