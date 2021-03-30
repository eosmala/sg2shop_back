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

// 30.3.2021
create table product (
    id int primary key auto_increment,
    name varchar(100) not null,
    price double (10,2) not null,
    image varchar(50),
    category_id int not null,
    index category_id(category_id),
    foreign key (category_id) references category(id)
    on delete restrict
);

insert into product (name, price, category_id) values ('raapimapuu', 15, 2);
insert into product (name, price, category_id) values ('hihna', 10, 1);