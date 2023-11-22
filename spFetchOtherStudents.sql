DELIMITER //

CREATE PROCEDURE fetch_other_students(IN p_CID TINYINT)

BEGIN
    SELECT u1.*
    FROM Users u1
    WHERE u1.UType = 0
    AND NOT EXISTS (
        SELECT u2.*
        FROM Users u2
        INNER JOIN BelongsTo b ON u2.UserID = b.UserID
        INNER JOIN Class c ON b.CID = c.CID
        WHERE c.CID = p_CID AND u1.UserID = u2.UserID
    );
END //

DELIMITER ;