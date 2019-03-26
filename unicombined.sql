
use unicombined;
select * from applicant;
create table qualification (qualificationID int primary key auto_increment, qualificationName varchar(40),
minScore int, maxScore int, resultCalc varchar(50));
create table university (universityID int primary key auto_increment, universityName varchar(50), description varchar(100));
create table universityAdmin (universityID int auto_increment, adminID varchar(50), primary key(universityID, adminID), 
foreign key(universityID) references University(universityID), foreign key(adminID) references user(username));
create table programme (programmeID int auto_increment primary key, programmeName varchar(50), description varchar(100),
closingDate date, universityID int, foreign key(universityID) references University(universityID));


insert into university values (1, "HELP University", "The best academy school");
insert into universityAdmin values(1, "beep");
insert into programme values (1, "Bachelor of Information Technology", "A degree for IT students!", '2019-01-22',1);
insert into programme values (2, "Bachelor of Business Management", "A degree for Business students!", '2019-03-25',1);
insert into programme values (3, "Bachelor of Psychology", "A degree for Psyc students!", '2019-04-06',1);

create table gradelist (qualificationID int auto_increment, grade varchar(5), score double,
foreign key(qualificationID) references qualification(qualificationID), primary key(qualificationID,grade));

insert into qualification values (1, "STPM", 0, 4, "Average of best 3 subjects"), 
(2, "A-levels", 0, 5, "Average of best 3 subjects"), (3, "Australian Matriculation", 0, 100, "Average of best 4 subjects"),
(4, "Canadian Pre-University", 0, 100, "Average of 6 subjects"), (5, "UEC", 5, 30, "Total of best 5 subjects"),
(6, "International Baccalaureate", 0, 42, "Total of 6 subjects"); 

insert into gradelist values (1, "A", 4.00), (1, "A-", 3.67), (1, "B+", 3.33), (1, "B", 3.00), (1, "B-", 2.67),
(1, "C+", 2.33), (1, "C", 2.00), (1, "C-", 1.67), (1, "D+", 1.33), (1, "D", 1.00), (1, "F", 0.00),
(2, "A", 5), (2, "B", 4), (2,"C", 3), (2, "D", 2), (2, "E", 1), (5, "A1", 1), (5, "A2", 2), (5, "B3", 3),
(5, "B4", 4), (5, "B5", 5), (5, "B6", 6);
select resultCalcFormula from qualification where qualificationName = "UEC";
select * from qualification, gradelist where qualification.qualificationID = gradelist.qualificationID;
SELECT qualificationName FROM qualification;
alter table qualification add resultCalcFormula varchar(20);
update qualification set resultCalcFormula = "(A+B+C)/3" where qualificationName = "STPM" or qualificationName = "A-levels";
update qualification set resultCalcFormula = "(A+B+C+D)/4" where qualificationName = "Australian Matriculation";
update qualification set resultCalcFormula = "(A+B+C+D+E+F)/6" where qualificationName = "Canadian Pre-University"; 
update qualification set resultCalcFormula = "(A+B+C+D+E)" where qualificationName = "UEC";
update qualification set resultCalcFormula = "(A+B+C+D+E+F)" where qualificationName = "International Baccalaureate"; 
SELECT score FROM qualification, gradelist WHERE qualification.qualificationID = 
		gradelist.qualificationID and qualificationName = "STPM" and grade = "B";
select * from qualificationObtained;
select subjectName, grade, result.score from gradelist, result, qualification where qualification.qualificationID = gradelist.qualificationID and
gradelist.score = result.score;
select * from result;
select * from user;
select * from universityadmin;
Delete from user;
delete from applicant;
delete from qualificationObtained;
delete from result;

SELECT programmeName, programme.description, closingDate from university, universityAdmin, programme where university.universityID=universityAdmin.universityID
AND university.universityID = programme.universityID AND adminID = "beep";