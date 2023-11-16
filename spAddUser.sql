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