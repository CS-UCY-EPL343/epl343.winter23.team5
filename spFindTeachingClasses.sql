DELIMITER //
CREATE PROCEDURE find_teaching_classes(
    IN p_username char(36)
)
BEGIN
SELECT c.CID, c.CName, c.SchoolYear, c.CNumber, c.CDays, c.TimeForFirstDay, c.TimeForSecondDay
FROM Class c
INNER JOIN Teaching t ON t.CID=c.CID
INNER JOIN Users u ON u.UserID=t.UserID
WHERE u.username=p_username;

END //
DELIMITER ;