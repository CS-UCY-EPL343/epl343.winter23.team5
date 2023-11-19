DELIMITER //

CREATE PROCEDURE get_unenrolled()

BEGIN
    SELECT *
    FROM Users u 
    WHERE u.isEnrolled=0 ;
END //

DELIMITER ;