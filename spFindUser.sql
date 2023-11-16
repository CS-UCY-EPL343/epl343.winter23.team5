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