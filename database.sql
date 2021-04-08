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

-- 30.3.2021
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
-- 6.4.2021 pieneläimet yksi tuote ja muutama tarjoustuote
insert into product (name, price, category_id) values ('terraario', 20, 3);
insert into product (name, price, category_id) values ('kissanhiekka', 3, 4);
insert into product (name, price, category_id) values ('mega-puruluu', 2, 4);
insert into product (name, price, category_id) values ('kalanruoka', 1, 4);

--rekisteröityminen
use webshop;

drop table if exists registration;
create table registration (
  	id INT primary key AUTO_INCREMENT,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,
    added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--8.4.
ALTER TABLE product
ADD COLUMN description varchar(255),
ADD COLUMN subcategory_id INT;

CREATE TABLE customer (
    userid INT primary key,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    streetAddress varchar(50),
    zipcode varchar(10),
    city varchar(50),
    country varchar(20),
    phonenumber varchar(20),
    FOREIGN KEY (userid)
	    REFERENCES registration(id)
);

create table subcategory (
    sub_id int primary key auto_increment,
    name varchar(50) not null
);

ALTER TABLE product
ADD CONSTRAINT sub_id
FOREIGN KEY (subcategory_id)
    REFERENCES subcategory(sub_id);