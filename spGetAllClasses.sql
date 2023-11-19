DELIMITER //

CREATE PROCEDURE get_all_classes()

BEGIN
    SELECT *
    FROM Class;
END //

DELIMITER ;