CREATE TABLE visitors (
     ip_address  varchar(45)  not null,
     user_agent  varchar(255) not null,
     page_url    varchar(255) not null,
     views_count int          not null,
     view_date   datetime     not null,
     CONSTRAINT PK_visitor PRIMARY KEY (ip_address, user_agent, page_url)
);