DELIMITER //

CREATE PROCEDURE fetch_next_years(p_SchoolYear tinyint)

BEGIN
    SELECT *
    FROM Class c
    WHERE c.NextYears=1 AND c.SchoolYear=p_SchoolYear;
END //

DELIMITER ;