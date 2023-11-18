DELIMITER //
CREATE PROCEDURE insert_to_teaching(IN p_UserID smallint, IN p_CID tinyint)
BEGIN
    INSERT INTO Teaching (UserID, CID) VALUES (p_UserID, p_CID);
END //

DELIMITER ;