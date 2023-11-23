DELIMITER //

CREATE PROCEDURE delete_class(IN p_CID tinyint)

BEGIN
    DELETE c 
    FROM Class c 
    WHERE c.CID=p_CID;
END //

DELIMITER ;