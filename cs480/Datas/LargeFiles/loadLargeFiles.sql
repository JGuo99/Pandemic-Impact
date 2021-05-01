LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/general-data.csv' IGNORE
INTO TABLE generalData
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

select *
from generalData
where iso = 'AFG';

delete from generalData;


LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/vaccination-data.csv' IGNORE
INTO TABLE vaccination
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

select *
from vaccination
where iso = 'AFG';

delete from vaccination;