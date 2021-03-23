drop database if exists webshop;
create database webshop;
use webshop;

create table category (
    id int primary key auto_increment,
    name varchar(50) not null
);

insert into category(name) value ('Koirat');
insert into category(name) value ('Kissat');
insert into category(name) value ('Pieneläimet');
insert into category(name) value ('Tarjoukset');