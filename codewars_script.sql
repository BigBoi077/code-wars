set search_path = codewars;

/*--DROP-TALBES--*/
drop table if exists transaction;
drop table if exists studenttip;
drop table if exists tips;
drop table if exists studentExercise;
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

/*--DROP-SCHEMA--*/
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
    price int,
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
    id serial,
    da varchar unique,
    username varchar,
    firstname varchar,
    lastname varchar,
    email varchar,
    constraint pk_person_id primary key (id)
);

create table if not exists "user" (
    id serial,
    da varchar unique,
    password varchar,
    unique (da),
    constraint fk_da_user foreign key (da) references person(da),
    constraint pk_id_user primary key (id)
);

create table if not exists student (
    id serial,
    da varchar unique,
    team_id int,
    cash bigint,
    points bigint,
    constraint fk_team_id foreign key (team_id) references team(id),
    constraint fk_da_student foreign key (da) references "user"(da),
    constraint pk_student_id primary key (id)
);


create table if not exists studenttip (
    id serial,
    tip_id int,
    student_da varchar,
    constraint fk_studenttip_tip_id foreign key (tip_id) references tips(id),
    constraint fk_tip_student_da foreign key (student_da) references student(da),
    constraint pk_studenttip_id primary key (id)
);

create table if not exists teacher (
    da varchar,
    constraint fk_da_teacher foreign key (da) references "user"(da),
    constraint pk_da_teacher primary key (da)
);

create table if not exists studentExercise (
    id serial,
    student_da varchar,
    exercise_id int,
    completed bool,
    corrected bool,
    comments varchar,
    student_comment varchar,
    dir_path varchar,
    submit_date timestamp,
    constraint fk_id_exercise foreign key (exercise_id) references exercise(id),
    constraint fk_da_student foreign key (student_da) references student(da),
    constraint pk_id_student_exercise primary key (id)
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
    student_da varchar,
    bought_date date,
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
    date timestamp,
    ip varchar,
    da varchar,
    method varchar(4),
    action varchar,
    constraint fk_da_log foreign key (da) references "user"(da),
    constraint pk_id_log primary key (id)
);

create table if not exists transaction (
    id serial,
    user_id int,
    date timestamp,
    action varchar,
    description varchar,
    constraint fk_transaction_user_id foreign key (user_id) references "user"(id),
    constraint pk_transaction_id primary key (id)
);

grant all privileges on database codewars to etudiant;
grant all privileges on all tables in schema codewars to etudiant;
grant all privileges on all sequences in schema codewars to etudiant;
grant all privileges on all functions in schema codewars to etudiant;
grant usage on schema codewars to etudiant;
