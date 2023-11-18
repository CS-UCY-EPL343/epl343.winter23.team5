DELIMITER //
CREATE PROCEDURE insert_extra_lesson(IN extraDate date, IN extraTime char(8),IN classID tinyint)
BEGIN
    INSERT INTO ExtraLesson (ELDate, ELTime,CID) VALUES (extraDate, extraTime,classID);
END //

DELIMITER ;