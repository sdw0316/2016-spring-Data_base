create table account (
  account_id VARCHAR NOT NULL,
  password VARCHAR NOT NULL,
  user_name VARCHAR NOT NULL,
  PRIMARY KEY (account_id)
)
create table department(
	dept_name varchar not null,
	primary key (dept_name)
)
create table instructor(
	instructor_id serial not null,
	instructor_name varchar not null,
	dept_name varchar not null,
	primary key (instructor_id),
	foreign key (dept_name) references department
)
create table course(
	course_id varchar not null,
	course_name varchar not null,
	dept_name varchar not null,
	credit int not null,
	primary key (course_id),
	foreign key (dept_name) references department
)
create table section(
	sec_id varchar not null,
	course_id varchar not null,
	semester int not null,
	year int not null,
	primary key (sec_id,course_id,semester,year),
	foreign key (course_id) references course,
	check (semester in (1, 2))
)

create table teach(
	instructor_id int not null,
	sec_id varchar not null,
	course_id varchar not null,
	semester int not null,
	year int not null,
	foreign key (instructor_id) references instructor,
	foreign key (sec_id,course_id,semester,year) references section,
	primary key (instructor_id,course_id,sec_id,semester,year)
)

create table evaluation(
	index serial not null,	
	instructor_id int not null,
	sec_id varchar not null,
	course_id varchar not null,
	semester int not null,
	year int not null,
	account_id varchar not null,
	rate int not null,
	comment text not null,
	foreign key (instructor_id,course_id,sec_id,semester,year) references teach,
	foreign key (account_id) references account
)

insert into department (department) values ('cs')
insert into instructor (instructor_name, dept_name) values ('박성빈','cs');
insert into course (course_id, course_name, dept_name, credit) values ('cose-371','데이터베이스','cs',3);
insert into section (sec_id, course_id, semester, year) values ('01','cose-371',5,2015);
insert into teach (instructor_id, sec_id, course_id, semester, year) values (2, '01', 'cose-371',1,2015);
insert into evaluation (instructor_id, sec_id, course_id, semester, year, account_id, rate, comment) values (2, '01','cose-371', 1,2015,'sdw0316',5,'아 시발');