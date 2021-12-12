create schema working_hours;
use  working_hours;

create table users(
    id int unsigned auto_increment not null primary key,
    first_name varchar(250) not null,
    last_name varchar(250) not null,
    email varchar(250) not null unique,
    password varchar(250) not null,
    is_admin bool default 0,
    created_at timestamp default current_timestamp,
    updated_at timestamp
);

create table working_hours(
    id int unsigned auto_increment not null primary key,
    user int(10) unsigned not null,
    work_date date,
    time1 time,
    time2 time,
    time3 time,
    time4 time,
    worked_time time,
    foreign key(user) references users(id)
);