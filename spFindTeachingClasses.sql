DELIMITER //
CREATE PROCEDURE find_teaching_classes(
    IN p_username char(36)
)
BEGIN
SELECT *
FROM Class c
INNER JOIN Teaching t ON t.CID=c.CID
INNER JOIN Users u ON u.UserID=t.UserID
WHERE u.username=p_username;

END //
DELIMITER ;