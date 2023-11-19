DELIMITER //

CREATE PROCEDURE show_extra_lesson(IN p_username char(36))

BEGIN
    SELECT c.CName,c.CNumber,el.ELDate,el.ELTime 
    FROM Users u
    INNER JOIN BelongsTo b ON u.UserID=b.UserID
    INNER JOIN Class c ON c.CID=b.CID
    INNER JOIN ExtraLesson el ON el.CID=c.CID 
    WHERE u.username=p_username AND el.ELDate>=CURDATE();
END //

DELIMITER ;
