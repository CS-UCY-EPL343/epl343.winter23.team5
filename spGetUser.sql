    DELIMITER //
CREATE PROCEDURE get_user(IN p_username char(36))
BEGIN
    SELECT *
    FROM Users u
    WHERE u.username = p_username;
END //
DELIMITER ;