DELIMITER //

CREATE PROCEDURE fetch_next_years()

BEGIN
    SELECT *
    FROM Class c
    WHERE c.NextYears=1;
END //

DELIMITER ;