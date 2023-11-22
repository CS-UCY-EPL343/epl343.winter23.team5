DELIMITER //

CREATE PROCEDURE fetch_class_students(IN p_CID tinyint)

BEGIN
    SELECT u.*
    FROM Users u
    INNER JOIN BelongsTo b ON u.UserID=b.UserID
    INNER JOIN CLASS c ON b.CID=c.CID
    WHERE c.CID=p_CID;
END //

DELIMITER ;