DELIMITER //

CREATE PROCEDURE delete_user(IN p_username char(36))

BEGIN
    DELETE u  
    FROM Users u 
    WHERE u.username=p_username;
END //

DELIMITER ;