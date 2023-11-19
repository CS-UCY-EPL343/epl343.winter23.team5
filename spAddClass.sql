DELIMITER //

CREATE PROCEDURE add_class(
    IN p_CName char(1),
    IN p_SchoolYear tinyint,
    IN p_CNumber tinyint,
    IN p_AvailableSeats tinyint,
    IN p_CDays char(7),
    IN p_TimeForFirstDay char(8),
    IN p_TimeForSecondDay char(8),
    IN p_NextYears tinyint
)
BEGIN
    INSERT INTO Class (
        CName,
        SchoolYear,
        CNumber,
        AvailableSeats,
        CDays,
        TimeForFirstDay,
        TimeForSecondDay,
        NextYears
    ) VALUES (
        p_CName,
        p_SchoolYear,
        p_CNumber,
        p_AvailableSeats,
        p_CDays,
        p_TimeForFirstDay,
        p_TimeForSecondDay,
        p_NextYears
    );
    SELECT LAST_INSERT_ID() ;
END //

DELIMITER ;