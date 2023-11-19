-- Drop Constraints

ALTER TABLE ExtraLesson DROP CONSTRAINT IF EXISTS FK_EL_CLASS;
ALTER TABLE Teaching DROP CONSTRAINT IF EXISTS FK_T_USER;
ALTER TABLE Teaching DROP CONSTRAINT IF EXISTS FK_T_CLASS;
ALTER TABLE BelongsTo DROP CONSTRAINT IF EXISTS FK_BT_USER;
ALTER TABLE BelongsTo DROP CONSTRAINT IF EXISTS FK_BT_CLASS;

-- Drop Tables

DROP TABLE IF EXISTS BelongsTo;
DROP TABLE IF EXISTS Teaching;
DROP TABLE IF EXISTS ExtraLesson;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Class;