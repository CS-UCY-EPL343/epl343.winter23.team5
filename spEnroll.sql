DELIMITER //

CREATE PROCEDURE enroll(IN p_username char(36))

BEGIN
    UPDATE Users u 
    SET u.isEnrolled=1
    WHERE u.username=p_username ;
END //

DELIMITER ;
