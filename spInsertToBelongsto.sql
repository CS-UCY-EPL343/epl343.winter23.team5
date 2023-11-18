DELIMITER //
CREATE PROCEDURE insert_to_belongsto(IN p_UserID smallint, IN p_CID tinyint)
BEGIN
    INSERT INTO BelongsTo (UserID, CID) VALUES (p_UserID, p_CID);
END //

DELIMITER ;