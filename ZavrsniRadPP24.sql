drop database if exists zavrsniRadPP24;
create database zavrsniRadPP24 character set utf8;

use zavrsniRadPP24;
    
create table operater(
    sifra       int not null primary key auto_increment,
    email       varchar(50) not null,
    lozinka     varchar(60) not null,
    ime         varchar(50) not null,
    prezime     varchar(50) not null,
    uloga       varchar(10) not null
);

create table kupac(
    sifra           int not null primary key auto_increment,
    ime             varchar(50) not null,
    prezime         varchar(50) not null,
    ulica           varchar(50) not null,
    kucniBroj       varchar(5) not null,
    grad            varchar(50) not null,
    email           varchar(50),
    narudzba        varchar(50)
);

create table narudzba(
    sifra           int not null primary key auto_increment,
    kupac           int not null,
    proizvod        int not null,
    iznos           decimal(18,2) not null,
    datum           datetime not null
);

create table proizvod(
    sifra           int not null primary key auto_increment,
    kategorija      varchar(50) not null,
    naziv           varchar(50) not null,
    cijena          decimal(18,2) not null
  
);


alter table narudzba add foreign key (kupac) references kupac(sifra);
alter table narudzba add foreign key (proizvod) references proizvod(sifra);

insert into operater(email,lozinka,ime,prezime,uloga) values
('khegedus@gmail.com','$2a$12$gcFbIND0389tUVhTMGkZYem.9rsMa733t9J9e9bZcVvZiG3PEvSla','Kristijan','Hegedus','admin');