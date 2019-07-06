create table bbs_posts
(
    id serial primary key,
    name VARCHAR(40) NOT NULL,
    comment varchar(200) NOT NULL,
    created_at timestamp
);