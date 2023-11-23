DELIMITER //

CREATE PROCEDURE get_enrolled()

BEGIN
    SELECT *
    FROM Users u 
    WHERE u.isEnrolled=1 AND u.UType != 2;
END //

DELIMITER ;