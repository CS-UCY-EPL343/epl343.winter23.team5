DELIMITER //

CREATE PROCEDURE update_class(
    IN p_CID tinyint,
    IN p_CName char(1),
    IN p_SchoolYear tinyint,
    IN p_CNumber tinyint,
    IN p_AvailableSeats tinyint,
    IN p_CDays char(7),
    IN p_TimeForFirstDay char(8),
    IN p_TimeForSecondDay char(8),
    IN p_NextYears bit
)
BEGIN
    UPDATE Class
    SET
        CName = p_CName,
        SchoolYear = p_SchoolYear,
        CNumber = p_CNumber,
        AvailableSeats = p_AvailableSeats,
        CDays = p_CDays,
        TimeForFirstDay = p_TimeForFirstDay,
        TimeForSecondDay = p_TimeForSecondDay,
        NextYears = p_NextYears
    WHERE
        CID = p_CID;
END //

DELIMITER ;