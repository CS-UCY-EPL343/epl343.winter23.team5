DELIMITER //
CREATE PROCEDURE fetch_teachers(
)
BEGIN
SELECT u.Fname,u.Lname,u.username
FROM Users u
WHERE u.UType=1;

END //
DELIMITER ;