set search_path = codewars;

/*--DROP-TALBES--*/
drop table if exists file;
drop table if exists studentExercise;
drop table if exists tips;
drop table if exists exercise;
drop table if exists week;
drop table if exists studentItem;
drop table if exists student;
drop table if exists item;
drop table if exists team;
drop table if exists token;
drop table if exists notification;
drop table if exists teacher;
drop table if exists log;
drop table if exists "user";
drop table if exists person;


drop schema if exists codewars;

/*--CREATE-SCHEMA--*/
create schema codewars;

/*--CREATE-TABLES--*/
create table if not exists week (
    id serial,
    number int,
    start_date date,
    is_active bool,
    constraint pk_id_week primary key (id)
);

create table if not exists exercise (
    id serial,
    week_id int,
    name varchar,
    description varchar,
    cash_reward int,
    difficulty int,
    execution_exemple varchar,
    point_reward int,
    constraint fk_id_exercise foreign key (week_id) references week(id),
    constraint pk_id_exercise primary key (id)
);

create table if not exists tips (
    id serial,
    tip varchar,
    exercise_id int,
    constraint fk_id_exercise foreign key (exercise_id) references exercise(id),
    constraint pk_id_tips primary key (id)
);

create table if not exists team (
    id serial,
    color varchar,
    name varchar,
    constraint pk_id_team primary key (id)
);

create table if not exists person (
    da int,
    firstname varchar,
    lastname varchar,
    constraint pk_da_person primary key (da)
);

create table if not exists "user" (
    id serial,
    da int,
    password varchar,
    unique (da),
    constraint fk_da_user foreign key (da) references person(da),
    constraint pk_id_user primary key (id)
);

create table if not exists student (
    da int,
    team_id int,
    cash int,
    constraint fk_team_id foreign key (team_id) references team(id),
    constraint fk_da_student foreign key (da) references "user"(da),
    constraint pk_da_student primary key (da)
);

create table if not exists teacher (
    da int,
    constraint fk_da_teacher foreign key (da) references "user"(da),
    constraint pk_da_teacher primary key (da)
);

create table if not exists studentExercise (
    id serial,
    student_da int,
    exercise_id int,
    completed bool,
    corrected bool,
    comments varchar,
    constraint fk_id_exercise foreign key (exercise_id) references exercise(id),
    constraint fk_da_student foreign key (student_da) references student(da),
    constraint pk_id_student_exercise primary key (id)
);

create table if not exists file (
    student_exercise_id int,
    file_path varchar,
    corrected_file_path varchar,
    constraint fk_student_exercise_id foreign key (student_exercise_id) references studentExercise(id),
    constraint pk_student_exercise_id primary key (student_exercise_id)
);

create table if not exists item (
    id serial,
    name varchar,
    price int,
    description varchar,
    constraint pk_id_item primary key (id)
);

create table if not exists studentItem (
    id serial,
    item_id int,
    student_da int,
    constraint fk_item_id foreign key (item_id) references item(id),
    constraint fk_student_da foreign key (student_da) references student(da),
    constraint pk_id_student_item primary key (id)
);

create table if not exists token (
    user_id int,
    token varchar,
    unique (token),
    constraint fk_user_id foreign key (user_id) references "user"(id),
    constraint pk_user_id primary key (user_id)
);

create table if not exists notification (
    id serial,
    user_id int,
    name varchar,
    is_seen bool,
    description varchar,
    date date,
    constraint fk_user_id foreign key (user_id) references "user"(id),
    constraint pk_id_notification primary key (id)
);

create table if not exists log (
    id serial,
    date date,
    ip varchar,
    da int,
    method varchar(4),
    action varchar,
    constraint fk_da_log foreign key (da) references "user"(da),
    constraint pk_id_log primary key (id)
);

insert into person(da, firstname, lastname) values (000000, 'big', 'boi');
insert into "user"(id, da, password) values (default, 000000, '$2y$10$B9bEPdKiHAl0uL/MrIQLsOCmEh4.PtGPZLaqKbODyTrytc.zW3e8y');
insert into teacher(da) values (000000);
