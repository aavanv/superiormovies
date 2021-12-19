create database superiormovies;

use superiormovies;

create table movie (
 id int primary key,
 name varchar(100) not null,
 description varchar(300) null,
 imageurl varchar(100) not null,
 unique index sm_name_uk (name)
);

create table movie_rating (
  movie_id int not null,
  rating int not null,
  index mr_movie_id (movie_id),
  foreign key (movie_id) references movie(id) on delete cascade
);
  
 